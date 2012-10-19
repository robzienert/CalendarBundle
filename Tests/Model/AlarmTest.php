<?php

namespace Rizza\CalendarBundle\Tests\Model;

use Rizza\CalendarBundle\Tests\CalendarTestCase;

class AlarmTest extends CalendarTestCase
{
    /**
     * The class to test
     *
     * @var Rizza\CalendarBundle\Model\Alarm
     */
    private $alarm;

    public function setUp()
    {
        parent::setUp();

        $this->alarm = $this->getMockForAbstractClass("Rizza\CalendarBundle\Model\Alarm", array(), "", false);
    }

    public function tearDown()
    {
        $this->alarm = null;

        parent::tearDown();
    }

    public function testSetId()
    {
        $this->assertNull($this->alarm->getId(), "Id is null on creation");
    }

    public function testSetGetEvent()
    {
        $this->alarm = $this->getMockForAbstractClass("Rizza\CalendarBundle\Model\Alarm", array($this->getMockEvent()));
        $this->assertInstanceOf('Rizza\CalendarBundle\Model\EventInterface', $this->alarm->getEvent());

        $this->assertSetterGetter($this->alarm, "event", $this->getMockEvent());
    }

    public function testAddRemoveRecipient()
    {
        $recipient1 = $this->getMockRecipient();
        $recipient2 = $this->getMockRecipient();
        $recipient3 = $this->getMockRecipient();

        $this->alarm->addRecipient($recipient1);
        $this->alarm->addRecipient($recipient2);
        $this->alarm->addRecipient($recipient3);

        $this->assertEquals(array($recipient1, $recipient2, $recipient3),
                            $this->alarm->getRecipients()->getValues());

        $this->alarm->removeRecipient($recipient2);

        $this->assertEquals(array($recipient1, $recipient3),
                            $this->alarm->getRecipients()->getValues());
    }

    public function testSetGetTrigger()
    {
        $this->assertSetterGetter($this->alarm, "trigger", $this->getMockDatetime());
    }
}