<?php

namespace Custom\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TagType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('name')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Custom\PeopleBundle\Entity\Tag',
        );
    }

    public function getName()
    {
        return 'custom_peoplebundle_tagtype';
    }
}
