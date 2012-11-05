<?php

namespace Rizza\CalendarBundle\Form\Type;

use Rizza\CalendarBundle\Form\DataTransformer\UsernameToUserTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UsernameType extends AbstractType
{

    protected $usernameTransformer;

    public function __construct(UsernameToUserTransformer $usernameTransformer)
    {
        $this->usernameTransformer = $usernameTransformer;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->appendClientTransformer($this->usernameTransformer);
    }

    public function getParent(array $options)
    {
        return 'text';
    }

    public function getName()
    {
        return 'rizza_calendar_username';
    }

}
