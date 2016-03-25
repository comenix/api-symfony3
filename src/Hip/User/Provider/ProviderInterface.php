<?php

namespace Hip\User\Provider;

/**
 * Interface ProviderInterface
 * @package Hip\AppBundle\Provider
 */
interface ProviderInterface
{
    /**
     * @param $userId
     * @return mixed
     */
    public function get($userId);

    /**
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function all($limit, $offset);
}
