<?php

namespace Rizza\CalendarBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class CalendarForm extends Form
{
    public function configure()
    {
        $this->setDataClass('Rizza\\CalendarBundle\\Entity\\Calendar');
        $this->add('name');
    }
}