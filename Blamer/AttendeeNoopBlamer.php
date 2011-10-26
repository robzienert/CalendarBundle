<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\AttendeeInterface;

class AttendeeNoopBlamer implements AttendeeBlamerInterface
{

    public function blame(AttendeeInterface $attendee)
    {
        // do nothing
    }

}
