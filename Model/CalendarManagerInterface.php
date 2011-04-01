<?php

namespace Rizza\CalendarBundle\Model;

interface CalendarManagerInterface
{
    public function createCalendar($name);

    public function updateCalendar(CalendarInterface $calendar, $andFlush = true);
    
    public function deleteCalendar(CalendarInterface $calendar);

    public function findCalendars();

    public function findCalendarBy(array $criteria);

    public function getClass();
}