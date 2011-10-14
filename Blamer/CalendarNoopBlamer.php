<?php

namespace Rizza\CalendarBundle\Blamer;

class CalendarNoopBlamer implements CalendarBlamerInterface
{

    public function blame(CalendarInterface $calendar)
    {
        // do nothing
    }

}
