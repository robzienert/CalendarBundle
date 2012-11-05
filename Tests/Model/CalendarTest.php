<?php

namespace Rizza\CalendarBundle\Tests\Model;

use Rizza\CalendarBundle\Model\CalendarInterface;
use Rizza\CalendarBundle\Tests\CalendarTestCase;

class CalendarTest extends CalendarTestCase
{
    /**
     * The class to test
     *
     * @var Rizza\CalendarBundle\Model\Calendar
     */
    private $calendar;

    public function setUp()
    {
        parent::setUp();

        $this->calendar = $this->getMockForAbstractClass("Rizza\CalendarBundle\Model\Calendar");
    }

    public function tearDown()
    {
        $this->calendar = null;

        parent::tearDown();
    }

    public function testSetId()
    {
        $this->assertNull($this->calendar->getId(), "Id is null on creation");
    }

    public function testName()
    {
        $this->assertNull($this->calendar->getName());

        $this->calendar->setName('Home');
        $this->assertEquals('Home', $this->calendar->getName());
        $this->assertEquals('Home', $this->calendar->__toString());
    }

    public function testAddRemoveEvent()
    {
        $dateToCompare = \DateTime::createFromFormat('Y-m-d', '2011-07-10');
        $event1        = $this->getMockEvent();

        $event2StartDate = \DateTime::createFromFormat('Y-m-d H:i:s', '2011-07-10 17:00:00');
        $event2          = $this->getMockEvent();
        $event2->expects($this->once())->method("isOnDate")->with($dateToCompare)->will($this->returnValue(true));

        $event3StartDate = \DateTime::createFromFormat('Y-m-d H:i:s', '2011-10-10 17:00:00');
        $event3          = $this->getMockEvent();

        $this->calendar->addEvent($event1);
        $this->calendar->addEvent($event2);
        $this->calendar->addEvent($event3);

        $this->assertEquals(array($event1, $event2, $event3), $this->calendar->getEvents()->getValues());

        $this->calendar->removeEvent($event1);

        $this->assertEquals(array($event2, $event3), $this->calendar->getEvents()->getValues());

        $this->assertEquals(array($event2),
                            $this->calendar->getEventsOnDay($dateToCompare)
                                ->getValues());
    }

    public function testSetOwner()
    {
        $this->assertSetterGetter($this->calendar, "owner", $this->getMockUser());
    }

    /**
     * @dataProvider getVisibilityData
     */
    public function testVisibility($visibility, $isPrivate, $isPublic)
    {
        $this->assertSetterGetter($this->calendar, "visibility", $visibility);
        $this->assertEquals($isPrivate, $this->calendar->isPrivate());
        $this->assertEquals($isPublic, $this->calendar->isPublic());
    }

    public function getVisibilityData()
    {
        return array(
            array(CalendarInterface::VISIBILITY_PRIVATE, true, false),
            array(CalendarInterface::VISIBILITY_PUBLIC, false, true),
        );
    }
}