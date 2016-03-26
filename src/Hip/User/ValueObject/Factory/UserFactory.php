<?php

namespace Hip\User\ValueObject\Factory;

use Hip\AppBundle\Entity\User;
use Hip\User\ValueObject;

/**
 * Class UserFactory
 * @package Hip\User\ValueObject\Factory
 */
class UserFactory
{

    /**
     * @param User $user
     * @return ValueObject\User
     */
    public static function buildUserValueObject(User $user)
    {
        $object           = new ValueObject\User();
        $object->id       = $user->getId();
        $object->username = $user->getUsername();
        $object->email    = $user->getEmail();
        return $object;
    }
}
