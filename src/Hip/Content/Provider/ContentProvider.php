<?php

namespace Hip\Content\Provider;

use Hip\AppBundle\Form\Handler\ContentFormHandler;
use Hip\AppBundle\Provider\BaseProvider;
use Hip\AppBundle\Entity\Content;
use Hip\Content\Repository\ContentRepository;

/**
 * Class ContentProvider
 * @package Hip\Content\Provider
 */
class ContentProvider extends BaseProvider
{
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
}
