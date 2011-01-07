<?php

namespace Bundle\CalendarBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Symfony\Component\Validator\ValidatorInterface;

class EventForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('title'));
        $this->add(new TextareaField('descriptio'));
        $this->add(new TextareaField('expression'));
        $this->add(new TextField('category'));
        $this->add(new TextField('calendar'));
    }
}