<?php

namespace Rizza\CalendarBundle\Tests\Model;

use Rizza\CalendarBundle\Model\EventInterface;
use Rizza\CalendarBundle\Tests\CalendarTestCase;

class AlarmTest extends CalendarTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
    }

    public function testSetId()
    {
        $alarm = $this->getAlarm();
        $this->assertNull($alarm->getId(), "Id is null on creation");
    }

    public function testSetGetEvent()
    {
        $event = $this->getMockEvent();
        $alarm = $this->getAlarm($event);
        $this->assertSetterGetter($alarm, "event", $this->getMockEvent(), $event);
    }

    public function testAddRemoveRecipient()
    {
        $alarm      = $this->getAlarm();
        $recipient1 = $this->getMockRecipient();
        $recipient2 = $this->getMockRecipient();
        $recipient3 = $this->getMockRecipient();

        $alarm->addRecipient($recipient1);
        $alarm->addRecipient($recipient2);
        $alarm->addRecipient($recipient3);

        $expected = array($recipient1, $recipient2, $recipient3);
        $this->assertEquals($expected, $alarm->getRecipients()->getValues());

        $alarm->removeRecipient($recipient2);

        $expected = array($recipient1, $recipient3);
        $this->assertEquals($expected, $alarm->getRecipients()->getValues());
    }

    public function testSetGetTrigger()
    {
        $alarm = $this->getAlarm();
        $this->assertSetterGetter($alarm, "trigger", $this->getMockDatetime());
    }

    /**
     * Return the class to test
     *
     * @param EventInterface $event The event for the construct
     *
     * @return Alarm
     */
    protected function getAlarm(EventInterface $event = null)
    {
        $event = $this->getMockEvent($event);

        return $this->getMockForAbstractClass("Rizza\CalendarBundle\Model\Alarm", array($event));
    }
}