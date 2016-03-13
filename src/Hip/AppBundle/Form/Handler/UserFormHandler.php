<?php

namespace Hip\AppBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Form\Factory\FormFactory;
use Hip\AppBundle\Exception\InvalidFormException;
use Symfony\Component\Serializer\Exception\LogicException;

/**
 * Class BaseFormHandler
 * @package Hip\AppBundle\Form\Handler
 */
class UserFormHandler extends BaseFormHandler
{

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
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException (if any given option
     * is not applicable to the given type)
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException (if the form has already been submitted)
     * @throws InvalidFormException (if the form is invalid)
     *
     * Not type hinting BaseEntity $object because we set the form type in the constructor and
     * symfony error is returned if invalid object
     */
    public function processForm($object, array $parameters, $method)
    {
        $options = ['method' => $method, 'csrf_protection' => false];

        $form = $this->formFactory->createForm($options);
        $form->setData($object);

        $form->submit($parameters, $method !== 'PATCH');

        if (!$form->isValid()) {
//            exit($form->getErrors());
            throw new InvalidFormException($form);
        }

        $data = $form->getData();
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
