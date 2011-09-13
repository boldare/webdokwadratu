<?php

namespace Custom\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Article form
 */
class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
	    ->add('title')
	    ->add('slug')
	    ->add('content', 'textarea')
        ;
    }

    public function getName()
    {
        return 'custom_articlebundle_articletype';
    }
}
