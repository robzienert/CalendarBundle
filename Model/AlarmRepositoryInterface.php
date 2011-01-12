<?php

namespace Bundle\CalendarBundle\Model;

use Bundle\CalendarBundle\Model\Event;
use Bundle\CalendarBundle\Model\Attendee;

interface AlarmRepositoryInterface
{
    /**
     * Returns all alarms for a given Event.
     *
     * @param Event $event
     * @return Doctrine\Common\Collections\Collection
     */
    public function findByEvent(Event $event);

    /**
     * Returns all alarams for a given Attendee.
     *
     * @param Attendee $attendee
     * @return Doctrine\Common\Collections\Collection
     */
    public function findByAttendee(Attendee $attendee);
}