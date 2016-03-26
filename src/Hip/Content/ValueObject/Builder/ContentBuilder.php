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
        $post          = new PostValueObject();
        $post->id      = $content->getId();
        $post->title   = $content->getTitle();
        $post->body    = $content->getBody();
        $post->summary = substr($content->getBody(), 0, 100);

        return $post;
    }

    /**
     * @param $contents
     * @return array
     */
    public static function buildHomeFromContents($contents)
    {
        $home       = [];
        $postObject = new PostValueObject();
        /** @var Content $content */
        foreach ($contents as $content) {
            $post          = clone $postObject;
            $post->id      = $content->getId();
            $post->title   = $content->getTitle();
            $post->summary = substr($content->getBody(), 0, 100);

            $home[] = $post;
        }

        return $home;
    }
}
