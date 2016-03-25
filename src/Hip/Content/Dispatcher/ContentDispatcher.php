<?php

namespace Hip\Content\Dispatcher;

use Hip\Content\Form\Handler\ContentFormHandler;
use Hip\AppBundle\Entity\Content;
use Hip\Content\Repository\ContentRepository;
use Hip\AppBundle\Exception\InvalidFormException;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

/**
 * Class ContentDispatcher
 * @package Hip\Content\Dispatcher
 */
class ContentDispatcher implements DispatcherInterface
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
     * ContentDispatcher constructor.
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
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws InvalidFormException
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function post(array $parameters)
    {
        return $this->formHandler->processForm($this->object, $parameters, 'POST');
    }

    /**
     * @param Content $object
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws InvalidFormException
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function put(Content $object, array $parameters)
    {
        return $this->formHandler->processForm($object, $parameters, 'PUT');
    }

    /**
     * @param Content $object
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws InvalidFormException
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function patch(Content $object, array $parameters)
    {
        return $this->formHandler->processForm($object, $parameters, 'PATCH');
    }

    /**
     * @param Content $object
     * @return mixed
     */
    public function delete(Content $object)
    {
        return $this->formHandler->delete($object);
    }
}
