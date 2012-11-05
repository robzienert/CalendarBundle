<?php

namespace Rizza\CalendarBundle\Creator;

use Rizza\CalendarBundle\Model\CalendarInterface;

interface CalendarCreatorInterface
{
    /**
     * Performs operations when creating a $calendar
     *
     * @param CalendarInterface $calendar The calendar
     *
     * @return boolean Whether the creation was a success
     */
    public function create(CalendarInterface $calendar);
}