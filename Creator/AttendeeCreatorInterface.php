<?php

namespace Rizza\CalendarBundle\Creator;

use Rizza\CalendarBundle\Model\AttendeeInterface;

interface AttendeeCreatorInterface
{

    public function create(AttendeeInterface $attendee);

}
