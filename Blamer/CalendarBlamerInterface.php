<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\CalendarInterface;

interface CalendarBlamerInterface
{

    public function blame(CalendarInterface $calendar);

}
