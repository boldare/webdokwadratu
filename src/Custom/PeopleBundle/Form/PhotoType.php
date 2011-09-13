<?php

namespace Custom\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('file', 'file')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Custom\PeopleBundle\Entity\Photo',
        );
    }

    public function getName()
    {
        return 'custom_peoplebundle_phototype';
    }
}
