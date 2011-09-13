<?php

namespace Custom\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * News form 
 */
class NewsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('header')
            ->add('extract', 'textarea')
            ->add('content', 'textarea')
            ->add('file', 'file', array('required' => true));
    }

    public function getName()
    {
        return 'custom_newsbundle_newstype';
    }
}
