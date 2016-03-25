<?php

namespace Hip\Content\Dispatcher;

use Hip\AppBundle\Entity\Content;

/**
 * Interface DispatcherInterface
 * @package Hip\AppBundle\Dispatcher
 */
interface DispatcherInterface
{
    /**
     * @param array $parameters
     * @return mixed
     */
    public function post(array $parameters);

    /**
     * @param Content $object
     * @param array $parameters
     * @return mixed
     */
    public function put(Content $object, array $parameters);

    /**
     * @param Content $object
     * @param array $parameters
     * @return mixed
     */
    public function patch(Content $object, array $parameters);

    /**
     * @param Content $object
     * @return mixed
     */
    public function delete(Content $object);
}
