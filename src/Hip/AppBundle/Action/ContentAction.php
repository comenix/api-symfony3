<?php

namespace Hip\AppBundle\Action;

use Symfony\Component\HttpFoundation\Response;
use Hip\Content\Dispatcher\ContentDispatcher;
use Hip\Content\Event\ContentEvent;
use Hip\Content\Provider\ContentProvider;
use Hip\AppBundle\Entity;

/**
 * Class ContentAction
 * @package Hip\AppBundle\Action
 */
class ContentAction
{
    /**
     * @var ContentDispatcher
     */
    protected $dispatcher;
    /**
     * @var ContentProvider
     */
    protected $provider;
    /**
     * @var ContentEvent
     */
    protected $event;

    public function __construct($dispatcher, $provider, $event)
    {
        $this->dispatcher = $dispatcher;
        $this->provider   = $provider;
        $this->event      = $event;
    }


    /**
     * @param $contentId
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     */
    public function putContentFromRequest($contentId, array $parameters)
    {
        /** @var Entity\Content $content */
        $content = $this->provider->get($contentId);
        
        if ($content === null) {
            $statusCode = Response::HTTP_CREATED;
            $content = $this->dispatcher->post($parameters);
        } else {
            $statusCode = Response::HTTP_NO_CONTENT;
            $content = $this->dispatcher->put($content, $parameters);
        }
        
        return ['contentId' => $content->getId(), 'statusCode' => $statusCode];
    }
}
