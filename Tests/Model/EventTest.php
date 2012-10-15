<?php

namespace Rizza\CalendarBundle\Tests\Model;

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

        $this->event->setStartDate(\DateTime::createFromFormat('Y-m-d', '2011-11-01'));

        $this->event->setEndDate(\DateTime::createFromFormat('Y-m-d', '2011-10-01'));
    }

    public function testSetStartDateThrowsExceptionWithValueAfterEnd()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->event->setEndDate(\DateTime::createFromFormat('Y-m-d', '2011-10-01'));

        $this->event->setStartDate(\DateTime::createFromFormat('Y-m-d', '2011-11-01'));
    }

    public function testIsOnDateThrowsExceptionsWithoutStartDate()
    {
        $this->setExpectedException('RuntimeException');

        $this->event->isOnDate(new \DateTime());
    }

    public function testIsOnDateThrowsExceptionsWithoutEndDate()
    {
        $this->setExpectedException('RuntimeException');

        $this->event->setStartDate(new \DateTime());
        $this->event->isOnDate(new \DateTime());
    }

    /**
     * @dataProvider dateTimeProvider
     */
    public function testIsOnDate(\DateTime $dateTime)
    {
        $this->event->setStartDate(\DateTime::createFromFormat('Y-m-d', '2011-10-01'));
        $this->event->setEndDate(\DateTime::createFromFormat('Y-m-d', '2011-10-02'));

        if ($this->event->getStartDate()->format('Y-m-d') > $dateTime->format('Y-m-d')) {
            $this->assertFalse($this->event->isOnDate($dateTime));
        } else {
            $this->assertTrue($this->event->isOnDate($dateTime));
        }
    }

    public function dateTimeProvider()
    {
        return array(
            array(\DateTime::createFromFormat('Y-m-d H:i:s', '2011-10-01 12:00:00')),
            array(\DateTime::createFromFormat('Y-m-d H:i:s', '2011-10-02 17:00:00')),
            array(\DateTime::createFromFormat('Y-m-d H:i:s', '2011-03-14 20:30:00'))
        );
    }
}