<?php

namespace Hip\User\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 *
 * Generated with "app/console doctrine:generate:form HipAppBundle:User" (and then moved to Type folder)
 *
 * @package Hip\User\Form
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email')
            ->add('username', null)
            ->add(
                'plainPassword',
                'repeated',
                [
                    'type'           => 'password',
                    'first_options'  => ['label' => 'password'],
                    'second_options' => ['label' => 'password_confirmation'],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Hip\AppBundle\Entity\User'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Hip_AppBundle_content';
    }
}
