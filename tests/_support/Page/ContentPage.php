<?php
namespace Page;

class ContentPage extends BasePage
{
    // include url of current page
    public static $url = '/1.0/contents';

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
        return parent::route(self::$url.$route, $withEnvironment, $withDomain);
    }

    /**
     * Full route is required when the location returns the full url
     * For example, // full route is required when the location returns the full url
     *
     * @param string $route
     * @return string
     */
    public static function fullRoute($route = '')
    {
        return self::route($route, true, true);
    }
}
