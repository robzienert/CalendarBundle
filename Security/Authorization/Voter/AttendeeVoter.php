<?php

namespace Rizza\CalendarBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Rizza\CalendarBundle\Model\AttendeeInterface;
use Rizza\CalendarBundle\Model\AttendeeManagerInterface;

class AttendeeVoter implements VoterInterface
{
    /**
     * The attendeeManager
     *
     * @var AttendeeManagerInterface
     */
    protected $attendeeManager;

    /**
     * The class that the voter supports
     *
     * @var string
     */
    protected $class;

    public function __construct(AttendeeManagerInterface $attendeeManager, $class)
    {
        $this->attendeeManager = $attendeeManager;
        $this->class = $class;
    }

    public function supportsAttribute($attribute)
    {
        return in_array(strtolower($attribute), array(
            'create',
            'edit',
            'delete',
            'view',
        ));
    }

    public function supportsClass($class)
    {
        return $class === $this->class;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $classIsSupported = false;
        foreach (class_implements($object) as $class) {
            if ($this->supportsClass($class)) {
                $classIsSupported = true;
            }
        }

        if (!$classIsSupported) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();
        if (null === $user) {
            return VoterInterface::ACCESS_DENIED;
        }

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                return VoterInterface::ACCESS_ABSTAIN;
            }

            if (!$this->{"can".$attribute}($user, $object)) {
                return VoterInterface::ACCESS_DENIED;
            }
        }

        return VoterInterface::ACCESS_GRANTED;
    }

    /**
     * Returns whether the $user can create the $attendee
     *
     * @param mixed             $user The user
     * @param AttendeeInterface $attendee The attendee
     *
     * @return boolean
     */
    protected function canCreate($user, AttendeeInterface $attendee)
    {
        $canCreate    = false;

        $loggedInUser = is_object($user);
        if ($loggedInUser) {
            $event     = $attendee->getEvent();
            $calendar  = $event->getCalendar();
            $organizer = $event->getOrganizer();

            if ($calendar->isPublic() || $organizer->equals($user)) {
                $canCreate = true;
            }
        }

        return $canCreate;
    }

    /**
     * Returns whether the $user can edit the $attendee
     *
     * @param UserInterface     $user     The user
     * @param AttendeeInterface $attendee The attendee
     *
     * @return boolean
     */
    protected function canEdit(UserInterface $user, AttendeeInterface $attendee)
    {
        return $this->attendeeManager->isAdmin($user, $attendee);
    }

    /**
     * Returns whether the $user can delete the $attendee
     *
     * @param UserInterface     $user     The user
     * @param AttendeeInterface $attendee The attendee
     *
     * @return boolean
     */
    protected function canDelete(UserInterface $user, AttendeeInterface $attendee)
    {
        return $this->attendeeManager->isAdmin($user, $attendee);
    }

    /**
     * Returns whether the $user can view the $attendee
     *
     * @param UserInterface     $user     The user
     * @param AttendeeInterface $attendee The attendee
     *
     * @return boolean
     */
    protected function canView(UserInterface $user, AttendeeInterface $attendee)
    {
        return $this->attendeeManager->isAdmin($user, $attendee);
    }
}