<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Rizza\CalendarBundle\Model\CalendarManagerInterface;
use Rizza\CalendarBundle\Model\EventManagerInterface;
use Symfony\Component\Form\Form;

abstract class BaseController extends ContainerAware
{

    /**
     * @return CalendarManagerInterface
     */
    protected function getCalendarManager()
    {
        return $this->container->get('rizza_calendar.manager.calendar');
    }

    /**
     * @return EventManagerInterface
     */
    protected function getEventManager()
    {
        return $this->container->get('rizza_calendar.manager.event');
    }

    /**
     * Creates and returns a Form instance from the type of the form.
     *
     * @param string|FormTypeInterface $type    The built type of the form
     * @param mixed $data                       The initial data for the form
     * @param array $options                    Options for the form
     *
     * @return Form
     */
    public function createForm($type, $data = null, array $options = array())
    {
        return $this->container->get('form.factory')->create($type, $data, $options);
    }

}
