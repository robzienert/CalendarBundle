<?php

namespace Rizza\CalendarBundle\FormFactory;

use Symfony\Component\Form\Form;

interface CalendarFormFactoryInterface
{

    /**
     * @return Form
     */
    public function createForm($data = null);

}
