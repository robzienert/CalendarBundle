<?php

namespace Bundle\CalendarBundle\Tests\Model;

use Bundle\CalendarBundle\Model\Event as AbstractEvent;
use  Bundle\CalendarBundle\TemporalExpression\TemporalExpression as ExpressionInterface;

class Event extends AbstractEvent
{
}

class TemporalExpression implements ExpressionInterface
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

    public function testExpression()
    {
        $event = new Event();

        $this->assertNull($event->getExpression());

        $event->setExpression(new TemporalExpression());
        $this->assertType('TemporalExpression', $event->getExpression());
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

        $event->setCategory(new Calendar());
        $this->assertType('Calendar', $event->getCalendar());
    }
}