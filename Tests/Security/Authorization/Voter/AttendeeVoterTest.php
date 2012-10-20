<?php

namespace Rizza\CalendarBundle\Tests\Security\Authorization\Voter;

use Rizza\CalendarBundle\Model\AttendeeManagerInterface;
use Rizza\CalendarBundle\Security\Authorization\Voter\AttendeeVoter;
use Rizza\CalendarBundle\Tests\CalendarTestCase;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */
class AttendeeVoterTest extends CalendarTestCase
{
    /**
     * @dataProvider getSupportsAttributesData
     *
     * @param string  $attribute The attribute to test
     * @param boolean $expected  Whether it is expected to be supported
     */
    public function testSupportsAttribute($attribute, $expected)
    {
        $voter = $this->getVoter($this->getMockAttendeeManager(), "");
        $this->assertEquals($expected, $voter->supportsAttribute($attribute));
    }

    public static function getSupportsAttributesData()
    {
        return array(
            array("not-supporter", false),
            array("create", true),
            array("edit", true),
            array("delete", true),
            array("view", true),
        );
    }

    /**
     * @dataProvider getSupportsClassData
     *
     * @param string  $constructClass The name of the class to build the voter with
     * @param string  $class          The name of the class to test
     * @param boolean $expected       Whether it is expected to be supported
     */
    public function testSupportsClass($constructClass, $class, $expected)
    {
        $voter = $this->getVoter($this->getMockAttendeeManager(), $constructClass);
        $this->assertEquals($expected, $voter->supportsClass($class));
    }

    public static function getSupportsClassData()
    {
        return array(
            array("GoodClassName", "GoodClassName", true),
            array("GoodClassName", "BadClassName", false),
        );
    }

    /**
     * @dataProvider getVoteData
     * @depends testSupportsClass
     * @depends testSupportsAttribute
     *
     * @param string  $class    The name of the class
     * @param boolean $expected Whether it is expected to be supported
     */
    public function testVote($expected, $suportsClass, $isValidToken, $isAdmin, $supportedAttribute, $userIsAnonymous, $calendarIsPublic, $userIsOrganizer)
    {
        $class           = "I\Am\An\Invalid\Class\Name";
        $attendeeManager = $this->getMockAttendeeManager();
        $attendee        = $this->getMockAttendee();
        $token           = $this->getMockToken();
        $user            = $this->getMockUser();
        $attributes      = array();

        if ($suportsClass) {
            $class = "Rizza\CalendarBundle\Model\AttendeeInterface";

            if (!$isValidToken) {
                $token = $this->getMockToken_ExpectsGetUser(null, $token);
            } else {
                // @todo All supported attributes
                if ($supportedAttribute) {
                    $attributes[] = $supportedAttribute;

                    if ("create" != $supportedAttribute) {
                        $attendeeManager = $this->getMockAttendeeManager_ExpectsIsAdmin($user, $attendee, $isAdmin, $attendeeManager);
                    } else {
                        // Anonymous user
                        if ($userIsAnonymous) {
                            $user = "anonymous";
                        } else {
                            // Public calendar
                            $calendar = $this->getMockCalendar_ExpectsIsPublic($calendarIsPublic);
                            $event    = $this->getMockEvent_ExpectsGetCalendar($calendar);

                            $organizer = $this->getMockOrganizer();
                            if ($userIsOrganizer) {
                                // User is organizer
                                $organizer = $this->getMockOrganizer_ExpectsEquals($user, $userIsOrganizer, $organizer);
                            }
                            $event    = $this->getMockEvent_ExpectsGetOrganizer($organizer, $event);
                            $attendee = $this->getMockAttendee_ExpectsGetEvent($event, $attendee);
                        }
                    }
                } else {
                    $attributes[] = "invalid-attribute";
                }

                $token = $this->getMockToken_ExpectsGetUser($user, $token);
            }
        }

        $voter = $this->getVoter($attendeeManager, $class);
        $this->assertEquals($expected, $voter->vote($token, $attendee, $attributes));
    }

    public static function getVoteData()
    {
        return array(
            //    $expectedReturn               , $suportsClass, $isValidToken, $isAdmin     , $suportedAttribute, $userIsAnonymous, $calendarIsPublic, $userIsOrganizer
            // Do not supports the class
            array(VoterInterface::ACCESS_ABSTAIN, false        , false        , false        , false             , false           , false            , false),
            // User is not in token
            array(VoterInterface::ACCESS_DENIED , true         , false        , false        , false             , false           , false            , false),
            // Do not support any attributes
            array(VoterInterface::ACCESS_ABSTAIN, true         , true         , false        , false             , false           , false            , false),
            // User is not permitted to view
            array(VoterInterface::ACCESS_DENIED , true         , true         , false        , "view"            , false           , false            , false),
            // Admin is permitted to view
            array(VoterInterface::ACCESS_GRANTED, true         , true         , true         , "view"            , false           , false            , false),
            // User is not permitted to edit
            array(VoterInterface::ACCESS_DENIED , true         , true         , false        , "edit"            , false           , false            , false),
            // Admin is permitted to edit
            array(VoterInterface::ACCESS_GRANTED, true         , true         , true         , "edit"            , false           , false            , false),
            // User is not permitted to delete
            array(VoterInterface::ACCESS_DENIED , true         , true         , false        , "delete"          , false           , false            , false),
            // Admin is permitted to delete
            array(VoterInterface::ACCESS_GRANTED, true         , true         , true         , "delete"          , false           , false            , false),
            // Anonymous is not permitted to create
            array(VoterInterface::ACCESS_DENIED , true         , true         , false        , "create"          , true            , false            , false),
            // User can create attendee if calendar is public
            array(VoterInterface::ACCESS_GRANTED, true         , true         , false        , "create"          , false           , true             , false),
            // Organizer can create an attendee
            array(VoterInterface::ACCESS_GRANTED, true         , true         , false        , "create"          , false           , false            , true),
            // The voter is granting access
            array(VoterInterface::ACCESS_DENIED , true         , true         , false        , "create"          , false           , false            , false),
        );
    }

    /**
     * Returns the voter to test
     *
     * @param AttendeeManagerInterface $attendeeManager The attendeeManager
     * @param string                   $class           The class to support
     *
     * @return \Rizza\CalendarBundle\Security\Authorization\Voter\AttendeeVoter
     */
    protected function getVoter(AttendeeManagerInterface $attendeeManager, $class)
    {
        return new AttendeeVoter($attendeeManager, $class);
    }
}