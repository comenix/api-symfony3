<?php

namespace Hip\Content\ValueObject\Factory;

use Hip\AppBundle\Entity\Content;
use Hip\Content\ValueObject;

/**
 * Class ContentFactory
 * @package Hip\Content\ValueObject\Factory
 */
class ContentFactory
{

    /**
     * @param Content $content
     * @return ValueObject\Page
     */
    public static function buildPageValueObject(Content $content)
    {
        $page        = new ValueObject\Page();
        $page->id    = $content->getId();
        $page->title = $content->getTitle();
        $page->body  = $content->getBody();
        return $page;
    }

    /**
     * @param Content $content
     * @return ValueObject\BlogPost
     */
    public static function buildPostValueObject(Content $content)
    {
        $post          = new ValueObject\BlogPost();
        $post->id      = $content->getId();
        $post->title   = $content->getTitle();
        $post->body    = $content->getBody();
        //$post->summary = substr($content->getBody(), 0, 100);

        return $post;
    }

    /**
     * @param $contents
     * @return array
     */
    public static function buildHomeFromContents($contents)
    {
        $home       = [];
        $postObject = new ValueObject\BlogPost();
        /** @var Content $content */
        foreach ($contents as $content) {
            $post          = clone $postObject;
            $post->id      = $content->getId();
            $post->title   = $content->getTitle();
            //TODO: create new field
//            $post->summary = substr($content->getBody(), 0, 300);
            $post->summary = $content->getBody();
            $home[] = $post;
        }

        return $home;
    }
}
