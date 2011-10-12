<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Rizza\CalendarBundle\Model\CalendarManagerInterface;
use Rizza\CalendarBundle\Model\EventManagerInterface;
use Rizza\CalendarBundle\FormFactory\CalendarFormFactoryInterface;
use Rizza\CalendarBundle\FormFactory\EventFormFactoryInterface;

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
     * @return CalendarFormFactoryInterface
     */
    public function getCalendarFormFactory()
    {
        return $this->container->get('rizza_calendar.form_factory.calendar');
    }

    /**
     * @return EventFormFactoryInterface
     */
    public function getEventFormFactory()
    {
        return $this->container->get('rizza_calendar.form_factory.event');
    }

}
