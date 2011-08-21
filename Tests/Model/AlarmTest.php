<?php

namespace Rizza\CalendarBundle\Tests\Model;

// @todo Look into using Mockery.
if (!class_exists('Rizza\CalendarBundle\Tests\Model\MockRecipient')) {
    class MockRecipient implements \Rizza\CalendarBundle\Model\Recipient
    {
    }
}

class AlarmTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetEvent()
    {
        $alarm = $this->getAlarm();

        $this->assertType('Rizza\CalendarBundle\Model\Event', $alarm->getEvent());

        $event = $this->getEvent();
        $event->setTitle('foo');

        $alarm->setEvent($event);

        $this->assertEquals($event, $alarm->getEvent());
    }

    public function testAddRemoveRecipient()
    {
        $alarm = $this->getAlarm();

        $recipient1 = new MockRecipient();
        $recipient2 = new MockRecipient();
        $recipient3 = new MockRecipient();

        $alarm->addRecipient($recipient1);
        $alarm->addRecipient($recipient2);
        $alarm->addRecipient($recipient3);

        $this->assertEquals(array($recipient1, $recipient2, $recipient3),
                            $alarm->getRecipients()->getValues());

        $alarm->removeRecipient($recipient2);

        $this->assertEquals(array($recipient1, $recipient3),
                            $alarm->getRecipients()->getValues());
    }

    public function testSetGetTrigger()
    {
        $alarm = $this->getAlarm();

        $this->assertNull($alarm->getTrigger());

        $dateTime = new \DateTime();

        $alarm->setTrigger($dateTime);

        $this->assertEquals($dateTime, $alarm->getTrigger());
    }

    protected function getAlarm($event = null)
    {
        if (null === $event) {
            $event = $this->getEvent();
        }
        
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Alarm', array($event));
    }

    protected function getEvent()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Event');
    }
}