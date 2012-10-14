<?php

namespace Rizza\CalendarBundle\Model;

abstract class AttendeeManager implements AttendeeManagerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeManagerInterface::createAttendee()
     */
    public function createAttendee(EventInterface $event)
    {
        $class = $this->getClass();
        $attendee = new $class();

        $attendee->setEvent($event);

        return $attendee;
    }
}