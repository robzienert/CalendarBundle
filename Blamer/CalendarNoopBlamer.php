<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\CalendarInterface;

class CalendarNoopBlamer implements CalendarBlamerInterface
{

    public function blame(CalendarInterface $calendar)
    {
        // do nothing
    }

}
