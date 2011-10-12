<?php

namespace Rizza\CalendarBundle\FormFactory;

use Symfony\Component\Form\Form;

interface CalendarFormFactoryInterface
{

    /**
     * @return Form
     */
    function createForm($data = null);

}
