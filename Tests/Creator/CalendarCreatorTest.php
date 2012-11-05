<?php

namespace Rizza\CalendarBundle\Tests\Creator;

use Rizza\CalendarBundle\Blamer\CalendarBlamerInterface;
use Rizza\CalendarBundle\Model\CalendarManagerInterface;
use Rizza\CalendarBundle\Creator\CalendarCreator;
use Rizza\CalendarBundle\Tests\CalendarTestCase;

/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */
class CalendarCreatorTest extends CalendarTestCase
{
    public function testCreate()
    {
        $calendar = $this->getMockCalendar();
        $manager  = $this->getMockCalendarManager_ExpectsAddCalendar($calendar);
        $blamer   = $this->getMockCalendarBlamer_ExpectsBlame($calendar);

        $creator = $this->getCreator($manager, $blamer);
        $this->assertTrue($creator->create($calendar), "Should return true on success");
    }

    /**
     * Returns the creator to test
     *
     * @param CalendarManagerInterface $calendarManager The calendar manager
     * @param CalendarBlamerInterface  $calendarBlamer  The calendarBlamer
     *
     * @return \Rizza\CalendarBundle\Creator\CalendarCreator
     */
    protected function getCreator(CalendarManagerInterface $calendarManager, CalendarBlamerInterface $calendarBlamer)
    {
        return new CalendarCreator($calendarManager, $calendarBlamer);
    }
}