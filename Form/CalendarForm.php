<?php

namespace Bundle\CalendarBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class CalendarForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('name'));
    }
}