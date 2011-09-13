<?php

namespace Custom\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $person = $options['data'];
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('twitter')
            ->add('facebook')
            ->add('linkedin')
            ->add('website')
            ->add('email')
            ->add('description')
            ->add('quotation')
            ->add('first_computer')
            ->add('industry')
            ->add('photos', 'collection', array(
                'type' => new PhotoType(),
                'options' => array('required' => $person->isNew()),
            ))
            ->add('tags', 'collection', array(
                'type' => new TagType(),
            ))
        ;
    }

    public function getName()
    {
        return 'custom_peoplebundle_persontype';
    }
}
