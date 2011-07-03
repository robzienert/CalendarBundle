<?php

namespace Rizza\CalendarBundle\Tests\Model;

use Rizza\CalendarBundle\Model\Event as AbstractEvent;

class Event extends AbstractEvent
{
}

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $event = new Event();

        $this->assertNull($event->getTitle());

        $event->setTitle('Do absolutely nothing');
        $this->assertEquals('Do absolutely nothing', $event->getTitle());
    }

    public function testDescription()
    {
        $event = new Event();

        $this->assertNull($event->getDescription());

        $event->setDescription('...Or try the sun');
        $this->assertEquals('...Or try the sun', $event->getDescription());
    }

    public function testCategory()
    {
        $event = new Event();

        $this->assertNull($event->getCategory());

        $event->setCategory('Indecision');
        $this->assertEquals('Indecision', $event->getCategory());
    }

    public function testCalendar()
    {
        $event = new Event();

        $this->assertNull($event->getCalendar());

        $event->setCalendar(new Calendar());
        $this->assertType('Calendar', $event->getCalendar());
    }
}