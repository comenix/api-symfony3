<?php

namespace Hip\Content\ValueObject\Builder;

use Hip\AppBundle\Entity\Content;
use Hip\Content\ValueObject\MenuValueObject;

/**
 * Class MenuBuilder
 * @package Hip\Content\ValueObjectBuilder
 */
class MenuBuilder
{

    /**
     * @param $contents
     * @return array
     */
    public static function buildMenuFromContents($contents)
    {
        $menu        = [];
        $valueObject = new MenuValueObject();

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
