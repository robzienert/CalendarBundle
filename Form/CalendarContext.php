<?php

namespace Rizza\CalendarBundle\Form;

use Symfony\Component\Form\FormContext;

class CalendarContext extends FormContext
{
    /**
     * @validation:MaxLength(255)
     * @validation:NotBlank()
     */
    public $name;
}