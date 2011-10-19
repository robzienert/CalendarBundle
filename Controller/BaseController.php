<?php

namespace Rizza\CalendarBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Rizza\CalendarBundle\Model\CalendarManagerInterface;
use Rizza\CalendarBundle\Model\EventManagerInterface;
use Rizza\CalendarBundle\Form\Factory\CalendarFormFactoryInterface;
use Rizza\CalendarBundle\Form\Factory\EventFormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
    protected function getCalendarFormFactory()
    {
        return $this->container->get('rizza_calendar.form_factory.calendar');
    }

    /**
     * @return EventFormFactoryInterface
     */
    protected function getEventFormFactory()
    {
        return $this->container->get('rizza_calendar.form_factory.event');
    }

    protected function createRedirect($controller, $action, $data = array())
    {
        return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter(sprintf('rizza_calendar.routing.%s.%s', $controller, $action)), $data));
    }

}
