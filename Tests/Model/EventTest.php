<?php

namespace Rizza\CalendarBundle\Tests\Model;

// @todo Look into Mockery
if (!class_exists('Rizza\CalendarBundle\Tests\Model\MockOrganizer')) {
    class MockOrganizer implements \Rizza\CalendarBundle\Model\Organizer {}
}
if (!class_exists('Rizza\CalendarBundle\Tests\Model\MockAttendee')) {
    class MockAttendee implements \Rizza\CalendarBundle\Model\Attendee {}
}

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetTitle()
    {
        $event = $this->getEvent();

        $this->assertNull($event->getTitle());

        $event->setTitle('Do absolutely nothing');
        $this->assertEquals('Do absolutely nothing', $event->getTitle());
    }

    public function testSetGetDescription()
    {
        $event = $this->getEvent();

        $this->assertNull($event->getDescription());

        $event->setDescription('...Or try the sun');
        $this->assertEquals('...Or try the sun', $event->getDescription());
    }

    public function testSetGetCategory()
    {
        $event = $this->getEvent();

        $this->assertNull($event->getCategory());

        $event->setCategory('Indecision');
        $this->assertEquals('Indecision', $event->getCategory());
    }

    public function testSetGetCalendar()
    {
        $event = $this->getEvent();

        $this->assertNull($event->getCalendar());

        $event->setCalendar($this->getCalendar());
        $this->assertType('Rizza\CalendarBundle\Model\Calendar', $event->getCalendar());
    }

    public function testSetGetAllDay()
    {
        $event = $this->getEvent();

        $this->assertFalse($event->getAllDay());
        $this->assertFalse($event->isAllDay());

        $event->setAllDay(true);

        $this->assertTrue($event->getAllDay());
        $this->assertTrue($event->isAllDay());
    }

    public function testSetGetDates()
    {
        $event = $this->getEvent();

        $date = new \DateTime();

        $event->setStartDate($date);
        $this->assertEquals($date, $event->getStartDate());

        $event->setEndDate($date);
        $this->assertEquals($date, $event->getEndDate());
    }

    public function testSetGetLocation()
    {
        $event = $this->getEvent();
        $event->setLocation('my house');

        $this->assertEquals('my house', $event->getLocation());
    }

    public function testSetGetUrl()
    {
        $event = $this->getEvent();
        $event->setUrl('http://google.com');

        $this->assertEquals('http://google.com', $event->getUrl());
    }

    public function testAddRemoveException()
    {
        $event = $this->getEvent();

        $exception1 = new \DateTime();
        $exception2 = new \DateTime();

        $event->addException($exception1);
        $event->addException($exception2);

        $this->assertEquals(array($exception1, $exception2), $event->getExceptions()->getValues());

        $event->removeException($exception2);

        $this->assertEquals(array($exception1), $event->getExceptions()->getValues());
    }

    public function testAddRemoveRecurrence()
    {
        $event = $this->getEvent();

        $recur1 = $this->getRecurrence();
        $recur2 = $this->getRecurrence();
        $recur3 = $this->getRecurrence();

        $event->addRecurrence($recur1);
        $event->addRecurrence($recur2);
        $event->addRecurrence($recur3);

        $this->assertEquals(array($recur1, $recur2, $recur3), $event->getRecurrences()->getValues());

        $event->removeRecurrence($recur2);

        $this->assertEquals(array($recur1, $recur3), $event->getRecurrences()->getValues());
    }

    public function testSetGetOrganizer()
    {
        $event = $this->getEvent();

        $this->assertNull($event->getOrganizer());

        $event->setOrganizer(new MockOrganizer());

        $this->assertType('MockOrganizer', $event->getOrganizer());
    }

    public function testAddRemoveAttendee()
    {
        $event = $this->getEvent();

        $attendee1 = new MockAttendee();
        $attendee2 = new MockAttendee();
        $attendee3 = new MockAttendee();

        $event->addAttendee($attendee1);
        $event->addAttendee($attendee2);
        $event->addAttendee($attendee3);

        $this->assertEquals(array($attendee1, $attendee2, $attendee3), $event->getAttendees()->getValues());

        $event->removeAttendee($attendee2);

        $this->assertEquals(array($attendee1, $attendee3), $event->getAttendees()->getValues());
    }

    public function testSetEndDateThrowsExceptionWithValueBeforeStart()
    {
        $this->setExpectedException('InvalidArgumentException');

        $event = $this->getEvent();
        $event->setStartDate(\DateTime::createFromFormat('Y-m-d', '2011-11-01'));

        $event->setEndDate(\DateTime::createFromFormat('Y-m-d', '2011-10-01'));
    }

    public function testSetStartDateThrowsExceptionWithValueAfterEnd()
    {
        $this->setExpectedException('InvalidArgumentException');

        $event = $this->getEvent();
        $event->setEndDate(\DateTime::createFromFormat('Y-m-d', '2011-10-01'));

        $event->setStartDate(\DateTime::createFromFormat('Y-m-d', '2011-11-01'));
    }

    public function testIsOnDateThrowsExceptionsWithoutStartDate()
    {
        $this->setExpectedException('RuntimeException');
        
        $event = $this->getEvent();
        $event->isOnDate(new \DateTime());
    }
    
    public function testIsOnDateThrowsExceptionsWithoutEndDate()
    {
        $this->setExpectedException('RuntimeException');

        $event = $this->getEvent();
        $event->setStartDate(new \DateTime());
        $event->isOnDate(new \DateTime());
    }

    /**
     * @dataProvider dateTimeProvider
     */
    public function testIsOnDate(\DateTime $dateTime)
    {
        $event = $this->getEvent();
        $event->setStartDate(\DateTime::createFromFormat('Y-m-d', '2011-10-01'));
        $event->setEndDate(\DateTime::createFromFormat('Y-m-d', '2011-10-02'));

        if ($event->getStartDate()->format('Y-m-d') > $dateTime->format('Y-m-d')) {
            $this->assertFalse($event->isOnDate($dateTime));
        } else {
            $this->assertTrue($event->isOnDate($dateTime));
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

    protected function getEvent()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Event');
    }

    protected function getCalendar()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Calendar');
    }

    protected function getRecurrence()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Recurrence');
    }
}