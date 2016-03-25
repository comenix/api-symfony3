<?php

namespace Hip\User\Dispatcher;

use Hip\AppBundle\Entity\User;

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
     * @param User $object
     * @param array $parameters
     * @return mixed
     */
    public function put(User $object, array $parameters);

    /**
     * @param User $object
     * @param array $parameters
     * @return mixed
     */
    public function patch(User $object, array $parameters);

    /**
     * @param User $object
     * @return mixed
     */
    public function delete(User $object);
}
