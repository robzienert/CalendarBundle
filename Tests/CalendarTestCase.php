<?php
/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */

namespace Rizza\CalendarBundle\Tests;

use Rizza\CalendarBundle\Blamer\AttendeeBlamerInterface;
use Rizza\CalendarBundle\Blamer\CalendarBlamerInterface;
use Rizza\CalendarBundle\Blamer\EventBlamerInterface;
use Rizza\CalendarBundle\Model\AttendeeInterface;
use Rizza\CalendarBundle\Model\AttendeeManagerInterface;
use Rizza\CalendarBundle\Model\CalendarInterface;
use Rizza\CalendarBundle\Model\CalendarManagerInterface;
use Rizza\CalendarBundle\Model\EventInterface;
use Rizza\CalendarBundle\Model\EventManagerInterface;
use Rizza\CalendarBundle\Model\Organizer;
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
     * @param EventInterface    $event    The event
     * @param AttendeeInterface $attendee The attendee
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAttendee_ExpectsGetEvent(EventInterface $event, AttendeeInterface $attendee = null)
    {
        $attendee = $this->getMockAttendee($attendee);
        $attendee->expects($this->once())->method("getEvent")->will($this->returnValue($event));

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
     * Returns a mock object of AttendeeBlamer type.
     *
     * @param AttendeeBlamerInterface $attendeeBlamer The attendee blamer
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAttendeeBlamer(AttendeeBlamerInterface $attendeeBlamer = null)
    {
        if (null === $attendeeBlamer) {
            $attendeeBlamer = $this->getMock("Rizza\CalendarBundle\Blamer\AttendeeBlamerInterface");
        }

        return $attendeeBlamer;
    }

    /**
     * Returns a mock object of AttendeeBlamer type.
     *
     * @param AttendeeInterface       $attendee       The attendee
     * @param AttendeeBlamerInterface $attendeeBlamer The attendee blamer
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAttendeeBlamer_ExpectsBlame(AttendeeInterface $attendee, AttendeeBlamerInterface $attendeeBlamer = null)
    {
        $attendeeBlamer = $this->getMockAttendeeBlamer($attendeeBlamer);
        $attendeeBlamer->expects($this->once())->method("blame")->with($attendee);

        return $attendeeBlamer;
    }

    /**
     * Returns a mock object of AttendeeManager type.
     *
     * @param AttendeeManagerInterface $attendeeManager The attendee manager
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAttendeeManager(AttendeeManagerInterface $attendeeManager = null)
    {
        if (null === $attendeeManager) {
            $attendeeManager = $this->getMock("Rizza\CalendarBundle\Model\AttendeeManagerInterface");
        }

        return $attendeeManager;
    }

    /**
     * Returns a mock object of AttendeeManager type.
     *
     * @param AttendeeInterface        $attendee        The attendee
     * @param AttendeeManagerInterface $attendeeManager The attendee manager
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAttendeeManager_ExpectsAddAttendee(AttendeeInterface $attendee, AttendeeManagerInterface $attendeeManager = null)
    {
        $attendeeManager = $this->getMockAttendeeManager($attendeeManager);
        $attendeeManager->expects($this->once())->method("addAttendee")->with($attendee);

        return $attendeeManager;
    }

    /**
     * Returns a mock object of AttendeeManager type.
     *
     * @param UserInterface            $user            The user
     * @param AttendeeInterface        $attendee        The attendee
     * @param boolean                  $isAdmin         Whether or not the user is expected to be an admin
     * @param AttendeeManagerInterface $attendeeManager The attendee manager
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAttendeeManager_ExpectsIsAdmin(UserInterface $user, AttendeeInterface $attendee, $isAdmin, AttendeeManagerInterface $attendeeManager = null)
    {
        $attendeeManager = $this->getMockAttendeeManager($attendeeManager);
        $attendeeManager->expects($this->once())->method("isAdmin")->with($user, $attendee)->will($this->returnValue($isAdmin));

        return $attendeeManager;
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
     * @param boolean           $isPublic Whether the calendar is public
     * @param CalendarInterface $calendar The calendar
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCalendar_ExpectsIsPublic($isPublic, CalendarInterface $calendar = null)
    {
        $calendar = $this->getMockCalendar($calendar);
        $calendar->expects($this->once())->method("isPublic")->will($this->returnValue($isPublic));

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
     * Returns a mock object of CalendarBlamer type.
     *
     * @param CalendarBlamerInterface $calendarBlamer The calendar blamer
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCalendarBlamer(CalendarBlamerInterface $calendarBlamer = null)
    {
        if (null === $calendarBlamer) {
            $calendarBlamer = $this->getMock("Rizza\CalendarBundle\Blamer\CalendarBlamerInterface");
        }

        return $calendarBlamer;
    }

    /**
     * Returns a mock object of CalendarBlamer type.
     *
     * @param CalendarInterface       $calendar       The calendar
     * @param CalendarBlamerInterface $calendarBlamer The calendar blamer
     *
     * @return Ambigous <\Rizza\CalendarBundle\Tests\PHPUnit_Framework_MockObject_MockObject, CalendarBlamerInterface>
     */
    protected function getMockCalendarBlamer_ExpectsBlame(CalendarInterface $calendar, CalendarBlamerInterface $calendarBlamer = null)
    {
        $calendarBlamer = $this->getMockCalendarBlamer($calendarBlamer);
        $calendarBlamer->expects($this->once())->method("blame")->with($calendar);

        return $calendarBlamer;
    }

    /**
     * Returns a mock object of CalendarManager type.
     *
     * @param CalendarManagerInterface $calendarManager The calendar manager
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCalendarManager(CalendarManagerInterface $calendarManager = null)
    {
        if (null === $calendarManager) {
            $calendarManager = $this->getMock("Rizza\CalendarBundle\Model\CalendarManagerInterface");
        }

        return $calendarManager;
    }

    /**
     * Returns a mock object of CalendarManager type.
     *
     * @param CalendarInterface $calendar
     * @param CalendarManagerInterface $calendarManager
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCalendarManager_ExpectsAddCalendar(CalendarInterface $calendar, CalendarManagerInterface $calendarManager = null)
    {
        $calendarManager = $this->getMockCalendarManager($calendarManager);
        $calendarManager->expects($this->once())->method("addCalendar")->with($calendar);

        return $calendarManager;
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
    protected function getMockEvent(EventInterface $event = null)
    {
        if (null === $event) {
            $event = $this->getMock('Rizza\CalendarBundle\Model\EventInterface');
        }

        return $event;
    }

    /**
     * Returns a mock object of Calendar type.
     *
     * @param CalendarInterface $calendar The calendar
     * @param EventInterface $event       The event
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEvent_ExpectsGetCalendar(CalendarInterface $calendar, EventInterface $event = null)
    {
        $event = $this->getMockEvent($event);
        $event->expects($this->once())->method("getCalendar")->will($this->returnValue($calendar));

        return $event;
    }

    /**
     * Returns a mock object of Calendar type.
     *
     * @param Organizer $organizer  The organizer
     * @param EventInterface $event The event
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEvent_ExpectsGetOrganizer(Organizer $organizer, EventInterface $event = null)
    {
        $event = $this->getMockEvent($event);
        $event->expects($this->once())->method("getOrganizer")->will($this->returnValue($organizer));

        return $event;
    }

    /**
     * Returns a mock object of Calendar type.
     *
     * @param UserInterface  $organizer The mock organizer
     * @param EventInterface $event     The mock event
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEvent_ExpectsSetOrganizer(UserInterface $organizer, EventInterface $event = null)
    {
        $event = $this->getMockEvent($event);
        $event->expects($this->once())->method("setOrganizer")->with($organizer);

        return $event;
    }

    /**
     * Returns a mock object of EventBlamer type.
     *
     * @param EventBlamerInterface $eventBlamer The event blamer
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEventBlamer(EventBlamerInterface $eventBlamer = null)
    {
        if (null === $eventBlamer) {
            $eventBlamer = $this->getMock("Rizza\CalendarBundle\Blamer\EventBlamerInterface");
        }

        return $eventBlamer;
    }

    /**
     * Returns a mock object of EventBlamer type.
     *
     * @param EventInterface       $event       The event
     * @param EventBlamerInterface $eventBlamer The event blamer
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEventBlamer_ExpectsBlame(EventInterface $event, EventBlamerInterface $eventBlamer = null)
    {
        $eventBlamer = $this->getMockEventBlamer($eventBlamer);
        $eventBlamer->expects($this->once())->method("blame")->with($event);

        return $eventBlamer;
    }

    /**
     * Returns a mock object of EventManager type.
     *
     * @param EventManagerInterface $eventManager The event manager
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEventManager(EventManagerInterface $eventManager = null)
    {
        if (null === $eventManager) {
            $eventManager = $this->getMock("Rizza\CalendarBundle\Model\EventManagerInterface");
        }

        return $eventManager;
    }

    /**
     * Returns a mock object of EventManager type.
     *
     * @param EventInterface        $event        The event
     * @param EventManagerInterface $eventManager The event manager
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEventManager_ExpectsAddEvent(EventInterface $event, EventManagerInterface $eventManager = null)
    {
        $eventManager = $this->getMockEventManager($eventManager);
        $eventManager->expects($this->once())->method("addEvent")->with($event);

        return $eventManager;
    }

    /**
     * Returns a MockObject of Organizer type
     *
     * @param Organizer $organizer The organizer
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockOrganizer(Organizer $organizer = null)
    {
        if (null === $organizer) {
            $organizer = $this->getMock("Rizza\CalendarBundle\Model\Organizer");
        }

        return $organizer;
    }

    /**
     * Returns a MockObject of Organizer type
     *
     * @param UserInterface      $userToValidate The argument
     * @param boolean            $isEqual        Whether the users are the same
     * @param OrganizerInterface $user           The mock object to assert
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockOrganizer_ExpectsEquals(UserInterface $userToValidate, $isEqual, Organizer $organizer = null)
    {
        $organizer = $this->getMockOrganizer($organizer);
        $organizer->expects($this->once())->method("equals")->with($userToValidate)->will($this->returnValue($isEqual));

        return $organizer;
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
     * @param UserInterface $user The mock object to assert
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockUser(UserInterface $user = null)
    {
        if (null === $user) {
            $user = $this->getMock('Symfony\Component\Security\Core\User\UserInterface');
        }

        return $user;
    }

    /**
     * Returns a MockObject of User type
     *
     * @param UserInterface $userToValidate The argument
     * @param boolean       $isEqual        Whether the users are the same
     * @param UserInterface $user           The mock object to assert
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockUser_ExpectsEquals(UserInterface $userToValidate, $isEqual, UserInterface $user = null)
    {
        $user = $this->getMockUser($user);
        $user->expects($this->once())->method("equals")->with($userToValidate)->will($this->returnValue($isEqual));

        return $user;
    }

    /**
     * Assert that the setter and getter are setting/returning the same values.
     *
     * @param object $object      The object to test
     * @param string $attribute   The attribute as defined in the class (no "_")
     * @param mixed  $value       The value to assert for
     * @param mixed  $defaulValue The default value to assert for
     */
    protected function assertSetterGetter($object, $attribute, $value, $defaulValue = null)
    {
        $setter = "set" . ucfirst($attribute);
        $getter = "get" . ucfirst($attribute);
        $class  = get_class($object);

        $this->assertEquals($defaulValue, $object->{$getter}(), "{$class}::{$attribute} should set by default");
        $object->{$setter}($value);
        $this->assertEquals($value, $object->{$getter}(), "The setter and getter for attribute '{$attribute}' should have the same value");
    }
}