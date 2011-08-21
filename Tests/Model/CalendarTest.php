<?php

namespace Rizza\CalendarBundle\Tests\Model;

class CalendarTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $calendar = $this->getCalendar();
        
        $this->assertNull($calendar->getName());

        $calendar->setName('Home');
        $this->assertEquals('Home', $calendar->getName());
        $this->assertEquals('Home', $calendar->__toString());
    }

    public function testAddRemoveEvent()
    {
        $calendar = $this->getCalendar();

        $event1 = $this->getEvent();
        $event1->setTitle('event1');
        $event2 = $this->getEvent();
        $event2->setTitle('event2');
        $event2->setStartDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2011-07-10 17:00:00'));
        $event2->setEndDate($event2->getStartDate());
        $event3 = $this->getEvent();
        $event3->setTitle('event3');
        $event3->setStartDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2011-10-10 17:00:00'));
        $event3->setEndDate($event3->getStartDate());

        $calendar->addEvent($event1);
        $calendar->addEvent($event2);
        $calendar->addEvent($event3);

        $this->assertEquals(array($event1, $event2, $event3), $calendar->getEvents()->getValues());

        $calendar->removeEvent($event1);

        $this->assertEquals(array($event2, $event3), $calendar->getEvents()->getValues());

        $this->assertEquals(array($event2), 
                            $calendar->getEventsOnDay(\DateTime::createFromFormat('Y-m-d', '2011-07-10'))
                                ->getValues());
    }

    protected function getCalendar()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Calendar');
    }

    protected function getEvent()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Event');
    }
}