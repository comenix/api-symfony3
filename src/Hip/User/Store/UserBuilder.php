<?php

namespace Hip\User\Store;

/**
 * Class UserBuilder
 * @package Hip\User\Store
 */
class UserBuilder
{

    /**
     * @param $id
     * @return mixed
     */
    public function getUserValueObject($id)
    {
        $user = new UserValueObject();
        $user->setId($id);

        return $id;
    }
}
