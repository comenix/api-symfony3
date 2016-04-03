<?php

use Symfony\Component\HttpFoundation\Response;
use Page\LoginPage;
use Page\ContentPage;

/**
 * Class ContentControllerCest
 */
class ContentControllerCest
{
    private $token;

    public function _before(ApiTester $I)
    {
        $this->token = LoginPage::tryToLogin($I);
        $I->amBearerAuthenticated($this->token[0]);
    }

    public function _after(ApiTester $I)
    {
    }

    // tests

    /**
     * GET TESTING
     */

    public function getInvalidCredentials(ApiTester $I)
    {
        $I->wantTo('ensure getting an invalid Content id returns a 401 code');

        $I->amBearerAuthenticated('');
        $I->sendGET(ContentPage::route('/1'));
        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
        $I->seeResponseIsJson();
    }

    public function getInvalidContent(ApiTester $I)
    {
        $I->wantTo('ensure getting an invalid Content id returns a 404 code');

        $I->sendGET(ContentPage::route('/555'));
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
    }

    public function ensureDefaultResponseTypeIsJson(ApiTester $I)
    {
        $I->wantTo('ensure default response type is json');

        $I->sendGET(ContentPage::route('/1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
    }

    public function getValidContent(ApiTester $I)
    {
        $I->wantTo('get valid content');

        foreach ($this->validContentProvider() as $id => $data) {
            $I->sendGET(ContentPage::route('/' . $id . '.json'));
            $I->seeResponseCodeIs(Response::HTTP_OK);
            $I->seeResponseIsJson();

            $I->seeResponseContainsJson($data);
        }
    }

    public function getContentsCollection(ApiTester $I)
    {
        $I->wantTo('get contents collection');

        $I->sendGET(ContentPage::route());
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'id' => 1,
                'title'  => 'Veggies es bonus',
            ],
            [
                'id' => 2,
                'title'  => 'Turnip greens',
            ]
        );
    }

    public function getContentsCollectionWithLimit(ApiTester $I)
    {
        $I->wantTo('get contents collection with limit');

        $I->sendGET(ContentPage::route('?limit=1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'id' => 1,
                'title'  => 'Veggies es bonus',
            ],
        ]);
    }

    public function getContentsCollectionWithOffset(ApiTester $I)
    {
        $I->wantTo('get contents collection with offset');

        $I->sendGET(ContentPage::route('?offset=1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['title'  => 'Turnip greens']);
    }

    public function getContentsCollectionWithLimitAndOffset(ApiTester $I)
    {
        $I->wantTo('get contents collection with limit and offset');

        $I->sendGET(ContentPage::route('?offset=1&limit=3'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['title'  => 'Turnip greens']);
    }

    public function getContentsCollectionWithHateoasSelfHref(ApiTester $I)
    {
        $I->wantTo('get contents collection with hateoas self href');

        $I->sendGET(ContentPage::route('', false));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['href'  => '/1.0/contents/1']);
    }

    /**
     * POST TESTING
     */

    public function postWithEmptyFieldsReturns400ErrorCode(ApiTester $I)
    {
        $I->wantTo('post With Empty Fields Returns 400 Error Code');

        $I->sendPOST(ContentPage::route(), []);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }


    public function postWithBadFieldsReturn400ErrorCode(ApiTester $I)
    {
        $I->wantTo('post With Bad Fields Return 400 Error Code');

        $I->sendPOST(ContentPage::route(), ['bad_field' => 'qwerty']);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function postWithValidDataReturns201WithHeader(ApiTester $I)
    {
        $I->wantTo('post With Valid Data Returns 201 With Header');

        // add the time to the title so it's unique(ish)
        $title = 'api testing ' . date('H:i:s');
        $I->sendPOST(ContentPage::route(), ['title' => $title, 'body' => 'test has passed']);

        $id = $I->grabFromDatabase('contents', 'id', ['title' => $title]);

        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        // full route is required because the location returns the full url
        $I->canSeeHttpHeader('Location', ContentPage::fullRoute('/' . $id));
    }

    /**
     * PUT TESTING
     */

    public function putWithInvalidIdAndInvalidDataReturns400ErrorCode(ApiTester $I)
    {
        $I->sendPUT(ContentPage::route('/214234.json'), ['qwerty' => 'asdfgh']);

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function putWithInvalidIdAndValidDataCreatesNewResourceAndReturns201(ApiTester $I)
    {
        $title = 'example with invalid id';
        $body  = 'and valid data';

        $I->sendPUT(ContentPage::route('/5555.json'), [
            'title' => $title,
            'body' => $body,
        ]);

        $id = $I->grabFromDatabase('contents', 'id', ['title'  => $title]);

        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->canSeeHttpHeader('Location', ContentPage::fullRoute('/' . $id));
    }

    public function putWithValidIdAndInvalidDataReturns400ErrorCode(ApiTester $I)
    {
        $I->sendPUT(ContentPage::route('/2.json'), ['ytrewq' => 'qwerty']);

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function putWithValidIdAndValidDataReplacesExistingDataAndReturns204(ApiTester $I)
    {
        $title = 'valid id - new and improved title';
        $body  = 'valid data - new content here';

        $I->sendPUT(ContentPage::route('/2.json'), [
            'title' => $title,
            'body' => $body,
        ]);

        $newTitle = $I->grabFromDatabase('contents', 'title', ['id'  => 2]);

        $I->seeResponseCodeIs(Response::HTTP_NO_CONTENT);
        // full route is required because the location returns the full url
        $I->canSeeHttpHeader('Location', ContentPage::fullRoute('/2'));
        $I->assertEquals($title, $newTitle);
    }


    /**
     * PATCH TESTING
     */

    public function patchWithInvalidIdReturns404(ApiTester $I)
    {
        $I->sendPATCH(ContentPage::route('/5555.json'), ['qwerty' => 'abcdef']);
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
    }

    public function patchWithValidIdAndInvalidDataReturns400ErrorCode(ApiTester $I)
    {
        $I->sendPATCH(ContentPage::route('/2.json'), ['qwerty' => 'abcdef']);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function patchWithValidIdAndValidDataReturns204(ApiTester $I)
    {
        $title        = 'valid id - newly patched title';
        $originalBody = "Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. Celery potato scallion desert raisin.";

        // send the patch
        $I->sendPATCH(ContentPage::route('/2.json'), ['title' => $title]);

        // get the new title and existing body
        $newTitle = $I->grabFromDatabase('contents', 'title', ['id'  => 2]);

        $existingBody = $I->grabFromDatabase('contents', 'body', ['id'  => 2]);

        // ensure the response code, header location, title is correct, and body hasn't changed
        $I->seeResponseCodeIs(Response::HTTP_NO_CONTENT);
        // full route is required because the location returns the full url
        $I->canSeeHttpHeader('Location', ContentPage::fullRoute('/2'));
        $I->assertEquals($title, $newTitle);
        $I->assertEquals($originalBody, $existingBody);
    }


    /**
     * DELETE TESTING
     */

    public function deleteWithInvalidArtistReturns404(ApiTester $I)
    {
        $I->sendDELETE(ContentPage::route('/555555.json'));

        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
    }

    public function deleteWithValidArtistReturns204(ApiTester $I)
    {
        $I->seeInDatabase('contents', ['id'    => 1]);

        $I->sendDELETE(ContentPage::route('/1.json'));

        $I->dontSeeInDatabase('contents', ['id'    => 1]);

        $I->seeResponseCodeIs(Response::HTTP_NO_CONTENT);
    }


    /**
     * @return array
     */
    private function validContentProvider()
    {
        return [1 => ['title' => 'Veggies es bonus'], 2 => ['title' => 'Turnip greens']];
    }
}
