<?php

namespace Rizza\CalendarBundle\Model;

interface AlarmManagerInterface
{
    /**
     * Returns all alarms for a given Event.
     *
     * @param EventInterface $event
     * @return Doctrine\Common\Collections\Collection
     */
    public function findByEvent(EventInterface $event);

    /**
     * Returns all alarams for a given Attendee.
     *
     * @param Attendee $attendee
     * @return Doctrine\Common\Collections\Collection
     */
    public function findByAttendee(Attendee $attendee);
}