<?php

namespace Hip\Content\ValueObject\Factory;

use Hip\AppBundle\Entity\Content;
use Hip\Content\ValueObject;

/**
 * Class MenuFactory
 * @package Hip\Content\ValueObject\Factory
 */
class MenuFactory
{

    /**
     * @param $contents
     * @return array
     */
    public static function buildMenuFromContents($contents)
    {
        $menu        = [];
        $valueObject = new ValueObject\Menu();

        /** @var Content $content */
        foreach ($contents as $content) {
            $menu[] = self::getMenuValueObject($valueObject, $content);
        }

        return $menu;
    }

    /**
     * @param $valueObject
     * @param Content $content
     * @return mixed
     */
    private static function getMenuValueObject($valueObject, Content $content)
    {
        $menuValueObject        = clone $valueObject;
        $menuValueObject->id    = $content->getId();
        $menuValueObject->title = $content->getTitle();
        return $menuValueObject;
    }
}
