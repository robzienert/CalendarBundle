<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\AttendeeInterface;

interface AttendeeBlamerInterface
{

    public function blame(AttendeeInterface $attendee);

}
