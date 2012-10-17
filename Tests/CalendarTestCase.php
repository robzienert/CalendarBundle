<?php
/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */

namespace Rizza\CalendarBundle\Tests;

use Rizza\CalendarBundle\Model\AttendeeInterface;
use Rizza\CalendarBundle\Model\CalendarInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param AttendeeInterface $attendee The mock attendee
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAttendee(AttendeeInterface $attendee = null)
    {
        if (null === $attendee) {
            $attendee = $this->getMock("Rizza\CalendarBundle\Model\AttendeeInterface");
        }

        return $attendee;
    }

    /**
     * Returns a mock object of Attendee type.
     *
     * @param UserInterface     $user     The mock user
     * @param AttendeeInterface $attendee The mock attendee
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAttendee_ExpectsSetUser(UserInterface $user, AttendeeInterface $attendee = null)
    {
        $attendee = $this->getMockAttendee($attendee);
        $attendee->expects($this->once())->method("setUser")->with($user);

        return $attendee;
    }

    /**
     * Returns a mock object of Calendar type.
     *
     * @param CalendarInterface $calendar The mock calendar
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCalendar(CalendarInterface $calendar = null)
    {
        if (null === $calendar) {
            $calendar = $this->getMock('Rizza\CalendarBundle\Model\CalendarInterface');
        }

        return $calendar;
    }

    /**
     * Returns a mock object of Calendar type.
     *
     * @param UserInterface     $owner    The mock owner
     * @param CalendarInterface $calendar The mock calendar
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCalendar_ExpectsSetOwner(UserInterface $owner, CalendarInterface $calendar = null)
    {
        $calendar = $this->getMockCalendar($calendar);
        $calendar->expects($this->once())->method("setOwner")->with($owner);

        return $calendar;
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
     * Returns a MockObject
     *
     * @param PHPUnit_Framework_MockObject_MockObject $securityContext The security context to configure
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockSecurityContext($securityContext = null)
    {
        if (null === $securityContext) {
            $securityContext = $this->getMock("Symfony\Component\Security\Core\SecurityContextInterface");
        }

        return $securityContext;
    }

    /**
     * Returns a MockObject configured to expect a call to a method
     *
     * @param PHPUnit_Framework_MockObject_MockObject $token           The expected returned value
     * @param PHPUnit_Framework_MockObject_MockObject $securityContext The security context to configure
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockSecurityContext_ExpectsGetToken($token, $securityContext = null)
    {
        $securityContext = $this->getMockSecurityContext($securityContext);
        $securityContext->expects($this->once())->method("getToken")->will($this->returnValue($token));

        return $securityContext;
    }

    /**
     * Returns a MockObject configured to expect a call to a method
     *
     * @param boolean                                 $isGranted       The expected returned value
     * @param PHPUnit_Framework_MockObject_MockObject $securityContext The security context to configure
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockSecurityContext_ExpectsIsGranted($isGranted, $securityContext = null)
    {
        $securityContext = $this->getMockSecurityContext($securityContext);
        $securityContext->expects($this->once())->method("isGranted")->with("IS_AUTHENTICATED_REMEMBERED")->will($this->returnValue($isGranted));

        return $securityContext;
    }

    /**
     * Returns a MockObject
     *
     * @param PHPUnit_Framework_MockObject_MockObject $token The token to configure
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockToken($token = null)
    {
        if (null === $token) {
            $token = $this->getMock("Symfony\Component\Security\Core\Authentication\Token\TokenInterface");
        }

        return $token;
    }

    /**
     * Returns a MockObject configured to expect a call to a method
     *
     * @param PHPUnit_Framework_MockObject_MockObject $user  The expected returned value
     * @param PHPUnit_Framework_MockObject_MockObject $token The token to configure
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockToken_ExpectsGetUser($user, $token = null)
    {
        $token = $this->getMockToken($token);
        $token->expects($this->once())->method("getUser")->will($this->returnValue($user));

        return $token;
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