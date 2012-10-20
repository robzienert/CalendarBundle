<?php

namespace Rizza\CalendarBundle\Creator;

use Rizza\CalendarBundle\Model\AttendeeInterface;

interface AttendeeCreatorInterface
{
    /**
     * Performs operations when creating an $attendee
     *
     * @param AttendeeInterface $attendee The attendee
     *
     * @return boolean Whether the creation was a success
     */
    public function create(AttendeeInterface $attendee);
}