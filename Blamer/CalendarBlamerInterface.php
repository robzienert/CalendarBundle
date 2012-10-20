<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\CalendarInterface;

interface CalendarBlamerInterface
{
    /**
     * Perfoms operations on the $calendar
     *
     * @param CalendarInterface $calendar The calendar
     */
    public function blame(CalendarInterface $calendar);
}
