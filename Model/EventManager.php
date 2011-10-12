<?php

namespace Rizza\CalendarBundle\Model;

abstract class EventManager implements EventManagerInterface
{

    public function createEvent()
    {
        $class = $this->getClass();
        $event = new $class();

        return $event;
    }

}
