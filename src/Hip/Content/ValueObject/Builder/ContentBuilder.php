<?php

namespace Hip\Content\ValueObject\Builder;

use Hip\AppBundle\Entity\Content;
use Hip\Content\ValueObject\PageValueObject;
use Hip\Content\ValueObject\PostValueObject;

/**
 * Class ContentBuilder
 * @package Hip\Content\ValueObjectBuilder
 */
class ContentBuilder
{

    /**
     * @param Content $content
     * @return PageValueObject
     */
    public static function buildPageValueObject(Content $content)
    {
        $page        = new PageValueObject();
        $page->id    = $content->getId();
        $page->title = $content->getTitle();
        $page->body  = $content->getBody();
        return $page;
    }

    /**
     * @param Content $content
     * @return PostValueObject
     */
    public static function buildPostValueObject(Content $content)
    {
        $post        = new PostValueObject();
        $post->id    = $content->getId();
        $post->title = $content->getTitle();
        $post->body  = $content->getBody();
        return $post;
    }

    /**
     * @param $contents
     * @return array
     */
    public static function buildBlogHomeFromContents($contents)
    {
        $home        = [];
        /** @var Content $content */
        foreach ($contents as $content) {
            //TODO: use prototype pattern
            $home[] = self::buildPostValueObject($content);
        }

        return $home;
    }
}
