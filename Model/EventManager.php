<?php

namespace Rizza\CalendarBundle\Model;

abstract class EventManager implements EventManagerInterface
{

    public function createEvent(CalendarInterface $calendar)
    {
        $class = $this->getClass();
        $event = new $class();

        $event->setCalendar($calendar);

        return $event;
    }

}
