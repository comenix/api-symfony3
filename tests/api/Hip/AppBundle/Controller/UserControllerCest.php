<?php

use Page\LoginPage;
use Page\RegisterPage;

/**
 * Class UserControllerCest
 */
class UserControllerCest
{
    private $token;

    public function _before(ApiTester $I)
    {

    }

    public function _after(ApiTester $I)
    {
    }

    // tests

    /**
     * GET TESTING
     */

    /**
     * @param ApiTester $I
     */
    public function tryToRegisterUser(ApiTester $I)
    {
        $email = RegisterPage::getRandomEmail();
        $username = RegisterPage::getRandomUsername();
        RegisterPage::tryToRegister($I, $email, $username);
    }

    /**
     * @param ApiTester $I
     */
    public function tryToLogin(ApiTester $I)
    {
        $this->token = LoginPage::tryToLogin($I);
    }
}
