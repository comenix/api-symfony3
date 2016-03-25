<?php

namespace Hip\Content\Provider;

use Hip\Content\Form\Handler\ContentFormHandler;
use Hip\AppBundle\Entity\Content;
use Hip\Content\Repository\ContentRepository;
use Hip\Content\ValueObject\Builder\ContentBuilder;
use Hip\Content\ValueObject\Builder\MenuBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ContentProvider
 * @package Hip\Content\Provider
 */
class ContentProvider implements ProviderInterface
{
    /**
     * @var ContentRepository
     */
    protected $repository;

    /**
     * @var ContentFormHandler
     */
    protected $formHandler;

    /**
     * @var Content
     */
    protected $object;

    /**
     * ContentProvider constructor.
     * @param ContentRepository $contentRepository
     * @param ContentFormHandler $formHandler
     */
    public function __construct(ContentRepository $contentRepository, ContentFormHandler $formHandler)
    {
        $this->repository = $contentRepository;
        $this->formHandler = $formHandler;
        $this->object = new Content();
    }

    /**
     * @param $contentId
     * @return mixed
     */
    public function get($contentId)
    {
        return $this->repository->find($contentId);
    }

    /**
     * @param $limit
     * @param $offset
     *
     * @return array
     */
    public function all($limit, $offset)
    {
        return $this->repository->findBy([], [], $limit, $offset);
    }

    /**
     * @param $contentId
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function fetchResponse($contentId)
    {
        $response = $this->get($contentId);

        if ($response === null) {
            throw new NotFoundHttpException();
        }

        return $response;
    }

    /**
     * @return array
     */
    public function getPageTitles()
    {
        $contents = $this->repository->findBy([]);
        return MenuBuilder::buildMenuFromContents($contents);
    }

    /**
     * @param $contentId
     * @return \Hip\Content\ValueObject\PageValueObject
     */
    public function getPageContent($contentId)
    {
        //TODO: where page type = page
        $pageContent = $this->get($contentId);

        if ($pageContent === null) {
            throw new NotFoundHttpException();
        }

        return ContentBuilder::buildPageValueObject($pageContent);
    }

    /**
     * @param $contentId
     * @return \Hip\Content\ValueObject\PostValueObject
     */
    public function getPostContent($contentId)
    {
        //TODO: where post type = post
        $postContent = $this->get($contentId);

        if ($postContent === null) {
            throw new NotFoundHttpException();
        }

        return ContentBuilder::buildPostValueObject($postContent);
    }

    /**
     * @return array
     */
    public function getHomePageContent()
    {
        //TODO: where page type = blog
        $contents = $this->repository->findBy([]);
        return ContentBuilder::buildBlogHomeFromContents($contents);
    }
}
