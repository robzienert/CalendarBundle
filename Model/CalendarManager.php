<?php

namespace Rizza\CalendarBundle\Model;

abstract class CalendarManager implements CalendarManagerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarManagerInterface::createCalendar()
     */
    public function createCalendar()
    {
        $class = $this->getClass();
        $calendar = new $class();

        return $calendar;
    }
}