<?php

namespace Hip\User\Dispatcher;

use Hip\AppBundle\Dispatcher\BaseDispatcher;
use Hip\AppBundle\Form\Handler\FormHandler;
use Hip\AppBundle\Entity\User;
use Hip\User\Repository\UserRepository;

/**
 * Class UserDispatcher
 * @package Hip\User\Dispatcher
 */
class UserDispatcher extends BaseDispatcher
{
    /**
     * UserDispatcher constructor.
     * @param UserRepository $userRepository
     * @param FormHandler $formHandler
     */
    public function __construct(UserRepository $userRepository, FormHandler $formHandler)
    {
        $this->repository = $userRepository;
        $this->formHandler = $formHandler;
        $this->object = new User();
    }
}
