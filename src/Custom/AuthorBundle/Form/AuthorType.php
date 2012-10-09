<?php

namespace Custom\AuthorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Author form
 */
class AuthorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('description')
            ->add('website')
            ->add('twitter')
            ->add('facebook')
            ->add('linkedin')
            ->add('email')
        ;
    }

    public function getName()
    {
        return 'custom_authorbundle_authortype';
    }
}
