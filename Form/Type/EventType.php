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
            ->add('category')
            ->add('startDate', 'datetime')
            ->add('endDate', 'datetime')
            ->add('description', 'textarea')
            ->add('location')
            ->add('url', 'url');
    }

    public function getName()
    {
        return 'event';
    }
}