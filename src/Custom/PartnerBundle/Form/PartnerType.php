<?php

namespace Custom\PartnerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('title')
            ->add('description')
            ->add('website')
            ->add('weight')
        ;
    }

    public function getName()
    {
        return 'custom_partnerbundle_partnertype';
    }
}
