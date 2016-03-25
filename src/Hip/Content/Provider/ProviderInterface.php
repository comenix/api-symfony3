<?php

namespace Hip\Content\Provider;

/**
 * Interface ProviderInterface
 * @package Hip\AppBundle\Provider
 */
interface ProviderInterface
{
    /**
     * @param $contentId
     * @return mixed
     */
    public function get($contentId);

    /**
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function all($limit, $offset);
}
