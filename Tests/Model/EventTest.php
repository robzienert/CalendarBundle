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

    protected function getEvent()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Event');
    }

    protected function getCalendar()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Calendar');
    }
}