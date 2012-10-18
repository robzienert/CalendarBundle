<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\AttendeeInterface;

interface AttendeeBlamerInterface
{
    /**
     * Performs operations on the $attendee
     *
     * @param AttendeeInterface $attendee The attendee
     */
    public function blame(AttendeeInterface $attendee);

}
