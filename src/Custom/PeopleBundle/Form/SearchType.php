<?php

namespace Custom\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('keyword', 'text')
        ;
    }

    public function getName()
    {
        return 'custom_peoplebundle_searchtype';
    }
}
