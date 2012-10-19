<?php
/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */

namespace Rizza\CalendarBundle\Tests\Model;

use \DateTime;
use Rizza\CalendarBundle\Model\Attendee;
use Rizza\CalendarBundle\Tests\CalendarTestCase;

class AttendeeTest extends CalendarTestCase
{
    /**
     * The class to test
     *
     * @var Attendee
     */
    private $attendee;

    public function setUp()
    {
        parent::setUp();

        $this->attendee = new Attendee();
    }

    public function tearDown()
    {
        $this->attendee = null;

        parent::tearDown();
    }

    public function testSetId()
    {
        $this->assertNull($this->attendee->getId(), "Id is null on creation");
    }

    public function testSetterGetterCreatedAt()
    {
        $this->assertSetterGetter($this->attendee, "createdAt", $this->getMockDatetime());
    }

    public function testSetterGetterUpdatedAt()
    {
        $this->assertSetterGetter($this->attendee, "updatedAt", $this->getMockDatetime());
    }

    public function testSetterGetterUser()
    {
        $this->assertSetterGetter($this->attendee, "user", $this->getMockUser());
    }

    public function testSetterGetterEvent()
    {
        $this->assertSetterGetter($this->attendee, "event", $this->getMockEvent());
    }

    public function testSetterGetterStatus()
    {
        $this->assertSetterGetter($this->attendee, "status", uniqid("status-"));
    }
}