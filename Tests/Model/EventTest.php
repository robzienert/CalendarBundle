<?php

namespace Rizza\CalendarBundle\Tests\Model;

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $event = $this->getEvent();

        $this->assertNull($event->getTitle());

        $event->setTitle('Do absolutely nothing');
        $this->assertEquals('Do absolutely nothing', $event->getTitle());
    }

    public function testDescription()
    {
        $event = $this->getEvent();

        $this->assertNull($event->getDescription());

        $event->setDescription('...Or try the sun');
        $this->assertEquals('...Or try the sun', $event->getDescription());
    }

    public function testCategory()
    {
        $event = $this->getEvent();

        $this->assertNull($event->getCategory());

        $event->setCategory('Indecision');
        $this->assertEquals('Indecision', $event->getCategory());
    }

    public function testCalendar()
    {
        $event = $this->getEvent();

        $this->assertNull($event->getCalendar());

        $event->setCalendar($this->getCalendar());
        $this->assertType('Rizza\CalendarBundle\Model\Calendar', $event->getCalendar());
    }

    public function testAllDay()
    {
        $event = $this->getEvent();

        $this->assertFalse($event->getAllDay());
        $this->assertFalse($event->isAllDay());

        $event->setAllDay(true);

        $this->assertTrue($event->getAllDay());
        $this->assertTrue($event->isAllDay());
    }

    public function testDates()
    {
        $event = $this->getEvent();

        $date = new \DateTime();

        $event->setStartDate($date);
        $this->assertEquals($date, $event->getStartDate());

        $event->setEndDate($date);
        $this->assertEquals($date, $event->getEndDate());
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
}