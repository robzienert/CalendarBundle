<?php

namespace Rizza\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Rizza\CalendarBundle\Model\CalendarInterface;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name')
            ->add('visibility', 'choice', array(
                'choices' => array(
                    CalendarInterface::VISIBILITY_PUBLIC => 'Public',
                    CalendarInterface::VISIBILITY_PRIVATE => 'Private',
                ),
            ));
    }

    public function getName()
    {
        return 'calendar';
    }
}