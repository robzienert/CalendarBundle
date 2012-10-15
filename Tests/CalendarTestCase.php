<?php
/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */

namespace Rizza\CalendarBundle\Tests;

/**
 * Common test case class for all the tests of this bundles.
 * It encapsulates all the commonly used methods for testing.
 */
class CalendarTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns a mock object of Alarm type.
     *
     * @param PHPUnit_Framework_MockObject_MockObject $event The alarm's event
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAbstractMockAlarm($event = null)
    {
        if (null === $event) {
            $event = $this->getEvent();
        }

        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Alarm', array($event));
    }

    /**
     * Returns a MockObject of Attendee type
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAttendee()
    {
        return $this->getMock("Rizza\CalendarBundle\Model\Attendee");
    }

    /**
     * Returns a mock object of Calendar type.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCalendar()
    {
        return $this->getMock('Rizza\CalendarBundle\Model\CalendarInterface');
    }

    /**
     * Returns a MockObject of Attendee type
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockDatetime()
    {
        return $this->getMock("\DateTime");
    }

    /**
     * Returns a mock object of Event type.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEvent()
    {
        return $this->getMock('Rizza\CalendarBundle\Model\EventInterface');
    }

    /**
     * Returns a MockObject of Organizer type
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockOrganizer()
    {
        return $this->getMock("Rizza\CalendarBundle\Model\Organizer");
    }

    /**
     * Returns a MockObject of Recipient type
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockRecipient()
    {
        return $this->getMock('Rizza\CalendarBundle\Model\Recipient');
    }

    /**
     * Returns a MockObject of Recurrence type
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockRecurrence()
    {
        return $this->getMock('Rizza\CalendarBundle\Model\RecurrenceInterface');
    }

    /**
     * Returns a MockObject of User type
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockUser()
    {
        return $this->getMock('Symfony\Component\Security\Core\User\UserInterface');
    }

    /**
     * Assert that the setter and getter are setting/returning the same values.
     *
     * @param object $object    The object to test
     * @param string $attribute The attribute as defined in the class (no "_")
     * @param mixed  $value     The value to assert for
     */
    protected function assertSetterGetter($object, $attribute, $value)
    {
        $setter = "set" . ucfirst($attribute);
        $getter = "get" . ucfirst($attribute);

        $object->{$setter}($value);
        $this->assertEquals($value, $object->{$getter}(), "The setter and getter for attribute '{$attribute}' should have the same value");
    }
}