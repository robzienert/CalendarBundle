<?php

namespace Rizza\CalendarBundle\Creator;

use Rizza\CalendarBundle\Model\AttendeeManagerInterface;
use Rizza\CalendarBundle\Blamer\AttendeeBlamerInterface;
use Rizza\CalendarBundle\Model\AttendeeInterface;

class AttendeeCreator implements AttendeeCreatorInterface
{

    protected $attendeeManager;
    protected $attendeeBlamer;

    public function __construct(AttendeeManagerInterface $attendeeManager, AttendeeBlamerInterface $attendeeBlamer)
    {
        $this->attendeeManager = $attendeeManager;
        $this->attendeeBlamer = $attendeeBlamer;
    }

    public function create(AttendeeInterface $attendee)
    {
        $this->attendeeBlamer->blame($attendee);
        $this->attendeeManager->addAttendee($attendee);

        return true;
    }

}
