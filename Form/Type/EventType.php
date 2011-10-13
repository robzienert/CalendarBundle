<?php

namespace Rizza\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EventType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('category', 'text', array(
                'required' => false
            ))
            ->add('startDate', 'datetime')
            ->add('endDate', 'datetime')
            ->add('description', 'textarea')
            ->add('location', 'text', array(
                'required' => false
            ))
            ->add('url', 'url', array(
                'required' => false
            ));
    }

    public function getName()
    {
        return 'event';
    }
}