<?php

namespace Rizza\CalendarBundle\Model;

interface CalendarManagerInterface
{

    /**
     * @return CalendarInterface
     */
    function createCalendar();

    /**
     * @return boolean whether the calendar was successfully persisted
     */
    function addCalendar(CalendarInterface $calendar);

    /**
     * @return boolean whether the calendar was successfully updated
     */
    function updateCalendar(CalendarInterface $calendar);

    /**
     * @return boolean whether the calendar was successfully removed
     */
    function removeCalendar(CalendarInterface $calendar);

    /**
     * @return CalendarInterface
     * @throws NotFoundHttpException if the calendar cannot be found
     */
    function find($id);

    function findAll();

    function getClass();

}
