<?php

namespace Hip\User\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Form\Factory\FormFactory;
use Hip\AppBundle\Entity\User;
use Hip\AppBundle\Exception\InvalidFormException;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

/**
 * Class FormHandler
 * @package Hip\AppBundle\Form\Handler
 */
class UserFormHandler
{
    /** @var ObjectManager $entityManager */
    protected $entityManager;
    /** @var FormFactory $formFactory */
    protected $formFactory;
    /** @var string $formType */
    protected $formType;

    /**
     * UserFormHandler constructor.
     * @param ObjectManager $objectManager
     * @param FormFactory $formFactory
     * @param string $formType
     */
    public function __construct(ObjectManager $objectManager, FormFactory $formFactory, string $formType)
    {
        $this->entityManager = $objectManager;
        $this->formFactory = $formFactory;
        $this->formType = $formType;
    }

    /**
     * @param $object
     * @param array $parameters
     * @param $method
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws AlreadySubmittedException (if the form has already been submitted)
     * @throws InvalidFormException (if the form is invalid)
     * @throws LogicException
     */
    public function processForm(User $object, array $parameters, $method)
    {
        $options = ['method' => $method, 'csrf_protection' => false];

        $form = $this->formFactory->createForm($options);
        $form->setData($object);

        $form->submit($parameters, $method !== 'PATCH');

        if (!$form->isValid()) {
            //exit($form->getErrors());
            throw new InvalidFormException($form);
        }

        $data = $form->getData();
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }

    /**
     * @param $object
     * @return bool
     */
    public function delete($object)
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();

        return true;
    }
}
