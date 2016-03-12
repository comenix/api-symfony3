<?php

namespace Hip\User\Store;

/**
 * Class UserValueObject
 * @package Hip\User\Store
 */
class UserValueObject
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return UserValueObject
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
