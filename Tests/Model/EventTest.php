<?php

namespace Rizza\CalendarBundle\Tests\Model;

use \DateTime;
use Rizza\CalendarBundle\Model\Event;
use Rizza\CalendarBundle\Tests\CalendarTestCase;

class EventTest extends CalendarTestCase
{
    /**
     * The class to test
     *
     * @var Event
     */
    private $event;

    public function setUp()
    {
        parent::setUp();

        $this->event = $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Event');
    }

    public function tearDown()
    {
        $this->event = null;

        parent::tearDown();
    }

    public function testSetId()
    {
        $this->assertNull($this->event->getId(), "Id is null on creation");
    }

    public function testSetGetTitle()
    {
        $this->assertNull($this->event->getTitle());
        $this->assertSetterGetter($this->event, "title", uniqid("title-"));
    }

    public function testSetGetDescription()
    {
        $this->assertNull($this->event->getDescription());
        $this->assertSetterGetter($this->event, "description", uniqid("description-"));
    }

    public function testSetGetCategory()
    {
        $this->assertNull($this->event->getCategory());
        $this->assertSetterGetter($this->event, "category", uniqid("category-"));
    }

    public function testSetGetCalendar()
    {
        $this->assertNull($this->event->getCalendar());
        $this->assertSetterGetter($this->event, "calendar", $this->getMockCalendar());
    }

    public function testSetGetAllDay()
    {
        $this->assertFalse($this->event->getAllDay());
        $this->assertFalse($this->event->isAllDay());

        $this->event->setAllDay(true);

        $this->assertTrue($this->event->getAllDay());
        $this->assertTrue($this->event->isAllDay());
    }

    public function testSetGetDates()
    {
        $this->assertNull($this->event->getStartDate());
        $this->assertSetterGetter($this->event, "startDate", $this->getMockDatetime());

        $this->assertNull($this->event->getEndDate());
        $this->assertSetterGetter($this->event, "endDate", $this->getMockDatetime());
    }

    public function testSetGetLocation()
    {
        $this->assertSetterGetter($this->event, "location", uniqid("location-"));
    }

    public function testSetGetUrl()
    {
        $this->assertSetterGetter($this->event, "url", 'http://google.com');
    }

    public function testAddRemoveException()
    {
        $exception1 = $this->getMockDatetime();
        $exception2 = $this->getMockDatetime();

        $this->event->addException($exception1);
        $this->event->addException($exception2);

        $this->assertEquals(array($exception1, $exception2), $this->event->getExceptions()->getValues());

        $this->event->removeException($exception2);

        $this->assertEquals(array($exception1), $this->event->getExceptions()->getValues());
    }

    public function testAddRemoveRecurrence()
    {
        $recur1 = $this->getMockRecurrence();
        $recur2 = $this->getMockRecurrence();
        $recur3 = $this->getMockRecurrence();

        $this->event->addRecurrence($recur1);
        $this->event->addRecurrence($recur2);
        $this->event->addRecurrence($recur3);

        $this->assertEquals(array($recur1, $recur2, $recur3), $this->event->getRecurrences()->getValues());

        $this->event->removeRecurrence($recur2);

        $this->assertEquals(array($recur1, $recur3), $this->event->getRecurrences()->getValues());
    }

    public function testSetGetOrganizer()
    {
        $this->assertNull($this->event->getOrganizer());
        $this->assertSetterGetter($this->event, "organizer", $this->getMockOrganizer());
    }

    public function testAddRemoveAttendee()
    {
        $attendee1 = $this->getMockAttendee();
        $attendee2 = $this->getMockAttendee();
        $attendee3 = $this->getMockAttendee();

        $this->event->addAttendee($attendee1);
        $this->event->addAttendee($attendee2);
        $this->event->addAttendee($attendee3);

        $this->assertEquals(array($attendee1, $attendee2, $attendee3), $this->event->getAttendees()->getValues());

        $this->event->removeAttendee($attendee2);

        $this->assertEquals(array($attendee1, $attendee3), $this->event->getAttendees()->getValues());
    }

    public function testSetEndDateThrowsExceptionWithValueBeforeStart()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->event->setStartDate(DateTime::createFromFormat('Y-m-d', '2011-11-01'));

        $this->event->setEndDate(DateTime::createFromFormat('Y-m-d', '2011-10-01'));
    }

    public function testSetStartDateThrowsExceptionWithValueAfterEnd()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->event->setEndDate(DateTime::createFromFormat('Y-m-d', '2011-10-01'));

        $this->event->setStartDate(DateTime::createFromFormat('Y-m-d', '2011-11-01'));
    }

    public function testIsOnDateThrowsExceptionsWithoutStartDate()
    {
        $this->setExpectedException('RuntimeException');

        $this->event->isOnDate(new DateTime());
    }

    public function testIsOnDateThrowsExceptionsWithoutEndDate()
    {
        $this->setExpectedException('RuntimeException');

        $this->event->setStartDate(new DateTime());
        $this->event->isOnDate(new DateTime());
    }

    /**
     * @dataProvider dateTimeProvider
     */
    public function testIsOnDate($isOnDate, DateTime $dateTime, $isInRecurrences = null, $exception = null)
    {
        // Event duration is all the 2012 year
        $this->event->setStartDate(DateTime::createFromFormat('Y-m-d H:i:s', '2012-01-01 00:00:00'));
        $this->event->setEndDate(DateTime::createFromFormat('Y-m-d H:i:s', '2012-12-31 23:59:59'));

        if (null !== $isInRecurrences) {
            $recurrence = $this->getMockRecurrence();
            $recurrence->expects($this->once())->method("contains")->will($this->returnValue($isInRecurrences));
            $this->event->addRecurrence($recurrence);
        }

        if (null !== $exception) {
            $this->event->addException($exception);
        }

        $this->assertEquals($isOnDate, $this->event->isOnDate($dateTime));
    }

    public function dateTimeProvider()
    {
        // Exceptions tolerance is in hours (+- 1 hour)
        $dateNotInException         = DateTime::createFromFormat('Y-m-d H:i:s', '2012-02-01 00:00:00');
        $dateInException            = DateTime::createFromFormat('Y-m-d H:i:s', '2012-04-01 00:00:00');
        $dateGreaterByOneHour       = DateTime::createFromFormat('Y-m-d H:i:s', '2012-04-01 00:01:00');
        $dateLowerByOneHour         = DateTime::createFromFormat('Y-m-d H:i:s', '2012-03-31 23:00:00');
        $dateGreaterByOneHourOneSec = DateTime::createFromFormat('Y-m-d H:i:s', '2012-04-01 01:00:01');
        $dateLowerByOneHourOneSec   = DateTime::createFromFormat('Y-m-d H:i:s', '2012-03-31 22:59:59');

        return array(
            // Date is lower than startdate by 1 second
            array(false, DateTime::createFromFormat('Y-m-d H:i:s', '2011-12-31 23:59:59')),
            // Date is lower than startdate by 1 day
            array(false, DateTime::createFromFormat('Y-m-d H:i:s', '2011-12-31 00:00:00')),
            // Date is greater than enddate by 1 second
            array(false, DateTime::createFromFormat('Y-m-d H:i:s', '2013-01-01 00:00:00')),
            // Date is greater than enddate by day
            array(false, DateTime::createFromFormat('Y-m-d H:i:s', '2013-01-02 23:59:59')),
            // Date is equals to startdate
            array(true, DateTime::createFromFormat('Y-m-d H:i:s', '2012-01-01 00:00:00')),
            // Date is equals to enddate
            array(true, DateTime::createFromFormat('Y-m-d H:i:s', '2012-12-31 23:59:59')),
            // Date is between startdate and enddate
            array(true, DateTime::createFromFormat('Y-m-d H:i:s', '2012-07-01 12:00:00')),
            // Event has recurrences and date is not in recurrences
            array(false, DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00'), false),
            // Event has recurrences and date is in recurrences
            array(true, DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00'), true),
            // Event has exceptions and date is in exceptions
            array(false, $dateInException, null, $dateGreaterByOneHour),
            // Event has exceptions and date is in exceptions
            array(false, $dateInException, null, $dateLowerByOneHour),
            // Event has exceptions and date is in exceptions
            array(false, $dateInException, null, $dateInException),
            // Event has exceptions and date is in exceptions
            array(true, $dateInException, null, $dateGreaterByOneHourOneSec),
            // Event has exceptions and date is in exceptions
            array(true, $dateInException, null, $dateLowerByOneHourOneSec),
            // Event has exceptions and date is not in exceptions
            array(true, $dateInException, null, $dateNotInException),
        );
    }
}