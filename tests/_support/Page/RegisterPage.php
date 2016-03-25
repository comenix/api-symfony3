<?php

namespace Page;

use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterPage extends BasePage
{
    // include url of current page
    public static $url           = '/1.0/registers';
    public static $plainPassword = ['first' => 'password', 'second' => 'password'];

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
        return parent::route(static::$url . $route, $withEnvironment, $withDomain);
    }

    /**
     * @return string
     */
    public static function getRandomEmail()
    {
        return base64_encode(random_bytes(10)) . '@example.com';
    }

    /**
     * @return string
     */
    public static function getRandomUsername()
    {
        return base64_encode(random_bytes(10));
    }

    /**
     * @param \ApiTester $I
     * @param string $email
     * @param string $username
     */
    public static function tryToRegister(\ApiTester $I, $email = '', $username = '')
    {
        $I->wantTo('create a new user by API');
        // set the headers
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');

        // post the registration
        $I->sendPOST(self::route(), self::getRegistrationParams($email, $username));

        // check response
        $I->seeResponseCodeIs(JsonResponse::HTTP_CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['result' => 'ok']);
    }

    /**
     * @param $email
     * @param $username
     * @return array
     */
    private static function getRegistrationParams($email, $username)
    {
        if ($email === '') {
            $email = parent::$email;
        }
        if ($username === '') {
            $username = parent::$username;
        }
        return ['email' => $email, 'username' => $username, 'plainPassword' => self::$plainPassword];
    }
}
