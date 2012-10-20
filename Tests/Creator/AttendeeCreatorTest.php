<?php
namespace Rizza\CalendarBundle\Tests\Creator;

use Rizza\CalendarBundle\Blamer\AttendeeBlamerInterface;
use Rizza\CalendarBundle\Creator\AttendeeCreator;
use Rizza\CalendarBundle\Model\AttendeeManagerInterface;
use Rizza\CalendarBundle\Tests\CalendarTestCase;

/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */
class AttendeeCreatorTest extends CalendarTestCase
{
    public function testCreate()
    {
        $attendee = $this->getMockAttendee();
        $manager  = $this->getMockAttendeeManager_ExpectsAddAttendee($attendee);
        $blamer   = $this->getMockAttendeeBlamer_ExpectsBlame($attendee);

        $creator = $this->getCreator($manager, $blamer);
        $this->assertTrue($creator->create($attendee), "Should return true on success");
    }

    /**
     * Returns the creator to test
     *
     * @param AttendeeManagerInterface $attendeeManager The attendee manager
     * @param AttendeeBlamerInterface  $attendeeBlamer  The attendee blamer
     *
     * @return \Rizza\CalendarBundle\Creator\AttendeeCreator
     */
    protected function getCreator(AttendeeManagerInterface $attendeeManager, AttendeeBlamerInterface  $attendeeBlamer)
    {
        return new AttendeeCreator($attendeeManager, $attendeeBlamer);
    }
}