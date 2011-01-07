<?php

namespace Bundle\CalendarBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Validator\ValidatorInterface;

class CalendarForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('name'));
    }
}