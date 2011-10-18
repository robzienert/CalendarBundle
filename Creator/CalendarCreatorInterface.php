<?php

namespace Rizza\CalendarBundle\Creator;

use Rizza\CalendarBundle\Model\CalendarInterface;

interface CalendarCreatorInterface
{

    public function create(CalendarInterface $calendar);

}
