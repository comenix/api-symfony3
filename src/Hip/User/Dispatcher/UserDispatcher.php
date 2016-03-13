<?php

namespace Hip\User\Dispatcher;

use FOS\UserBundle\Model\UserManager;
use Hip\AppBundle\Dispatcher\BaseDispatcher;
use Hip\AppBundle\Form\Handler\UserFormHandler;
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
     * @param UserFormHandler $formHandler
     * @param UserManager $userManager
     */
    public function __construct(UserRepository $userRepository, UserFormHandler $formHandler, UserManager $userManager)
    {
        $this->repository = $userRepository;
        $this->formHandler = $formHandler;
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $this->object = $user;
    }
}
