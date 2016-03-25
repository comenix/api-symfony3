<?php

namespace Page;

/**
 * Class BasePage
 * @package Page
 */
abstract class BasePage
{
    public static $domain = 'http://api.hiphiparray.dev';
    public static $environment = '/app_dev.php';

    public static $email = 'tester@example.com';
    public static $username = 'tester';
    public static $password = 'password';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     *
     * @param $route
     * @param bool|false $withEnvironment
     * @param bool|false $withDomain
     * @return string
     */
    public static function route($route = '', $withEnvironment = true, $withDomain = false)
    {
        if ($withEnvironment) {
            $route = self::$environment . $route;
        }

        if ($withDomain) {
            $route = self::$domain . $route;
        }

        return $route;
    }
}
