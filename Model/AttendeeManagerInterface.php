<?php

namespace Rizza\CalendarBundle\Model;

interface AttendeeManagerInterface
{

    public function getClass();

    /**
     * @return AttendeeInterface
     */
    public function createAttendee(EventInterface $event);
    
    /**
     * @return AttendeeInterface
     */
    public function find($id);

    public function addAttendee(AttendeeInterface $attendee);

    public function updateAttendee(AttendeeInterface $attendee);

    public function removeAttendee(AttendeeInterface $attendee);

    public function isAdmin($user, AttendeeInterface $attendee);

}
