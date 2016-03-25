<?php

namespace Hip\User\Provider;

use Hip\User\Form\Handler\UserFormHandler;
use Hip\AppBundle\Entity\User;
use Hip\User\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserProvider
 * @package Hip\User\Provider
 */
class UserProvider implements ProviderInterface
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
     * UserProvider constructor.
     * @param UserRepository $userRepository
     * @param UserFormHandler $formHandler
     */
    public function __construct(UserRepository $userRepository, UserFormHandler $formHandler)
    {
        $this->repository = $userRepository;
        $this->formHandler = $formHandler;
        $this->object = new User();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function get($userId)
    {
        return $this->repository->find($userId);
    }

    /**
     * @param $limit
     * @param $offset
     *
     * @return array
     */
    public function all($limit, $offset)
    {
        return $this->repository->findBy([], [], $limit, $offset);
    }

    /**
     * @param $userId
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function fetchResponse($userId)
    {
        $response = $this->get($userId);

        if ($response === null) {
            throw new NotFoundHttpException();
        }

        return $response;
    }
}
