<?php

namespace Hip\AppBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Hip\AppBundle\Exception\InvalidFormException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Hip\AppBundle\Entity\BaseEntity;

/**
 * Class FormHandler
 * @package Hip\AppBundle\Form\Handler
 */
class BaseFormHandler
{
    /** @var ObjectManager $entityManager */
    protected $entityManager;
    /** @var FormFactoryInterface $formFactory */
    protected $formFactory;
    /** @var string $formType */
    protected $formType;

    /**
     * FormHandler constructor.
     * @param ObjectManager $objectManager
     * @param FormFactoryInterface $formFactory
     * @param string $formType
     */
    public function __construct(ObjectManager $objectManager, FormFactoryInterface $formFactory, string $formType)
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
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException (if any given option is not applicable to the given type)
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException (if the form has already been submitted)
     * @throws InvalidFormException (if the form is invalid)
     *
     * // not type hinting BaseEntity because we set the form type in the constructor and symfony error is returned if invalid object
     * // public function processForm(BaseEntity $object, array $parameters, $method)
     */
    public function processForm($object, array $parameters, $method)
    {
        // if no html, then no csrf protection is okay
        $options = ['method' => $method, 'csrf_protection' => false];
        $form = $this->formFactory->create($this->formType, $object, $options);

        /**
         * The second parameter ($clearMissing) to allow patch being applied atomically (only patched fields are saved)
         * patch doesn't follow the RESTful convention 100% correctly, but it's close enough
         * see http://williamdurand.fr/2014/02/14/please-do-not-patch-like-an-idiot/
         */
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
