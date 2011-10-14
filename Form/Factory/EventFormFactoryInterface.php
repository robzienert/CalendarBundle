<?php

namespace Rizza\CalendarBundle\Form\Factory;

use Symfony\Component\Form\Form;

interface EventFormFactoryInterface
{

    /**
     * @return Form
     */
    public function createForm($data = null);

}
