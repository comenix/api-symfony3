<?php

namespace Hip\Content\Provider;

use Hip\Content\Form\Handler\ContentFormHandler;
use Hip\AppBundle\Entity\Content;
use Hip\Content\Repository\ContentRepository;
use Hip\Content\ValueObject\Factory\ContentFactory;
use Hip\Content\ValueObject\Factory\MenuFactory;
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
        $this->repository  = $contentRepository;
        $this->formHandler = $formHandler;
        $this->object      = new Content();
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
        return MenuFactory::buildMenuFromContents($contents);
    }

    /**
     * @param $contentId
     * @return \Hip\Content\ValueObject\Page
     */
    public function getPageContent($contentId)
    {
        //TODO: where page type = page
        $pageContent = $this->get($contentId);

        if ($pageContent === null) {
            throw new NotFoundHttpException();
        }

        return ContentFactory::buildPageValueObject($pageContent);
    }

    /**
     * @param $contentId
     * @return \Hip\Content\ValueObject\Page
     */
    public function getSecureContent($contentId)
    {
        //TODO: where content type = secure
        $pageContent = $this->get($contentId);

        if ($pageContent === null) {
            throw new NotFoundHttpException();
        }

        return ContentFactory::buildPageValueObject($pageContent);
    }

    /**
     * @param $contentId
     * @return \Hip\Content\ValueObject\BlogPost
     */
    public function getPostContent($contentId)
    {
        //TODO: where content type = post
        $postContent = $this->get($contentId);

        if ($postContent === null) {
            throw new NotFoundHttpException();
        }

        return ContentFactory::buildPostValueObject($postContent);
    }

    /**
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getBlogPostsSummary($limit, $offset)
    {
        //TODO: where content type = blog
        $contents = $this->repository->findBy([], [], $limit, $offset);
        return ContentFactory::buildHomeFromContents($contents);
    }
}
