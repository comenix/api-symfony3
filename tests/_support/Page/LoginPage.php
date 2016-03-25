<?php

namespace Page;

use Symfony\Component\HttpFoundation\JsonResponse;

class LoginPage extends BasePage
{
    // include url of current page
    public static $url = '/1.0/login_check';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * @param string $route
     * @param bool $withEnvironment
     * @param bool $withDomain
     * @return string
     */
    public static function route($route = '', $withEnvironment = true, $withDomain = false)
    {
        return parent::route(static::$url.$route, $withEnvironment, $withDomain);
    }

    /**
     * @param \ApiTester $I
     * @param string $username
     * @param string $password
     * @return array
     *
     * @throws \Exception
     */
    public static function tryToLogin(\ApiTester $I, $username = '', $password = '')
    {
        $I->wantTo('login and get Json Web Token');
        // set the headers
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');

        // post the registration
        $I->sendPOST(self::route(), self::getLoginParams($username, $password));

        // check response
        $I->seeResponseCodeIs(JsonResponse::HTTP_OK);

        return $I->grabDataFromResponseByJsonPath('$.token');
    }

    /**
     * @param $username
     * @param $password
     * @return array
     */
    private static function getLoginParams($username, $password)
    {
        if ($username === '') {
            $username = parent::$username;
        }
        if ($password === '') {
            $password = parent::$password;
        }
        return ['_username' => $username, '_password' => $password];
    }
}
