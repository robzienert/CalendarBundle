<?php

namespace Rizza\CalendarBundle\FormFactory;

use Symfony\Component\Form\Form;

interface EventFormFactoryInterface
{

    /**
     * @return Form
     */
    public function createForm($data = null);

}
