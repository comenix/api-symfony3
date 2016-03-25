<?php

namespace Hip\Content\Provider;

use Hip\Content\Form\Handler\ContentFormHandler;
use Hip\AppBundle\Entity\Content;
use Hip\Content\Repository\ContentRepository;
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
}
