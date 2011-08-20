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

    protected function getCalendar()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Calendar');
    }

    protected function getEvent()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Event');
    }
}