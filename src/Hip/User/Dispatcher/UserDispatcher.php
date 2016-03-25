<?php

namespace Hip\User\Dispatcher;

use FOS\UserBundle\Model\UserManager;
use Hip\AppBundle\Entity\User;
use Hip\User\Form\Handler\UserFormHandler;
use Hip\User\Repository\UserRepository;
use Hip\AppBundle\Exception\InvalidFormException;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

/**
 * Class UserDispatcher
 * @package Hip\User\Dispatcher
 */
class UserDispatcher implements DispatcherInterface
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserFormHandler
     */
    protected $formHandler;

    /**
     * @var User
     */
    protected $object;


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


    /**
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws InvalidFormException
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function post(array $parameters)
    {
        return $this->formHandler->processForm($this->object, $parameters, 'POST');
    }

    /**
     * @param User $object
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws InvalidFormException
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function put(User $object, array $parameters)
    {
        return $this->formHandler->processForm($object, $parameters, 'PUT');
    }

    /**
     * @param User $object
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws InvalidFormException
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function patch(User $object, array $parameters)
    {
        return $this->formHandler->processForm($object, $parameters, 'PATCH');
    }

    /**
     * @param User $object
     * @return mixed
     */
    public function delete(User $object)
    {
        return $this->formHandler->delete($object);
    }
}
