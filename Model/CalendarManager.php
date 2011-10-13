<?php

namespace Rizza\CalendarBundle\Model;

abstract class CalendarManager implements CalendarManagerInterface
{

    public function createCalendar()
    {
        $class = $this->getClass();
        $calendar = new $class();

        return $calendar;
    }

}
