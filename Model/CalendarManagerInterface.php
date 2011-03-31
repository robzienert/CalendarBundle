<?php

namespace Rizza\CalendarBundle\Model;

interface CalendarManagerInterface
{
    public function createCalendar($name);

    public function updateCalendar(Calendar $calendar);
    
    public function deleteCalendar(Calendar $calendar);

    public function getClass();
}