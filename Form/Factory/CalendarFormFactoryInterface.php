<?php

namespace Rizza\CalendarBundle\Form\Factory;

use Symfony\Component\Form\Form;

interface CalendarFormFactoryInterface
{

    /**
     * @return Form
     */
    public function createForm($data = null);

}
