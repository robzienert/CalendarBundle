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
    private $class;

    public function setUp()
    {
        parent::setUp();

        $this->class = new Attendee();
    }

    public function tearDown()
    {
        $this->class = null;

        parent::tearDown();
    }

    public function testSetterGetterCreatedAt()
    {
        $this->assertSetterGetter($this->class, "createdAt", $this->getMockDatetime());
    }

    public function testSetterGetterUpdatedAt()
    {
        $this->assertSetterGetter($this->class, "updatedAt", $this->getMockDatetime());
    }

    public function testSetterGetterUser()
    {
        $this->assertSetterGetter($this->class, "user", $this->getMockUser());
    }

    public function testSetterGetterEvent()
    {
        $this->assertSetterGetter($this->class, "event", $this->getMockEvent());
    }

    public function testSetterGetterStatus()
    {
        $this->assertSetterGetter($this->class, "status", uniqid("status-"));
    }
}