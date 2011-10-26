<?php

namespace Rizza\CalendarBundle\Model;

abstract class AttendeeManager implements AttendeeManagerInterface
{

    public function createAttendee(EventInterface $event)
    {
        $class = $this->getClass();
        $attendee = new $class();

        $attendee->setEvent($event);

        return $attendee;
    }

}
