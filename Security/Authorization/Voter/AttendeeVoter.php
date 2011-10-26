<?php

namespace Rizza\CalendarBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Rizza\CalendarBundle\Model\AttendeeInterface;
use Rizza\CalendarBundle\Model\AttendeeManagerInterface;

class AttendeeVoter implements VoterInterface
{

    protected $attendeeManager;
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
        if (!$this->supportsClass(get_class($object))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
        if (null === $token->getUser()) {
            return VoterInterface::ACCESS_DENIED;
        }

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                return VoterInterface::ACCESS_ABSTAIN;
            }
            if (!$this->{"can".$attribute}($token, $object)) {
                return VoterInterface::ACCESS_DENIED;
            }
        }

        return VoterInterface::ACCESS_GRANTED;
    }

    protected function canCreate(TokenInterface $token, AttendeeInterface $attendee)
    {
        return is_object($token->getUser()) && ($attendee->getEvent()->getCalendar()->isPublic() || $attendee->getEvent()->getOrganizer()->equals($token->getUser()));
    }

    protected function canEdit(TokenInterface $token, AttendeeInterface $attendee)
    {
        return $this->attendeeManager->isAdmin($token->getUser(), $attendee);
    }

    protected function canDelete(TokenInterface $token, AttendeeInterface $attendee)
    {
        return $this->attendeeManager->isAdmin($token->getUser(), $attendee);
    }

    protected function canView(TokenInterface $token, AttendeeInterface $attendee)
    {
        return $this->attendeeManager->isAdmin($token->getUser(), $attendee);
    }

}
