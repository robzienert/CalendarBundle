<?php

namespace Rizza\CalendarBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Rizza\CalendarBundle\Model\EventInterface;
use Rizza\CalendarBundle\Model\Organizer;

class EventVoter implements VoterInterface
{

    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function supportsAttribute($attribute)
    {
        return in_array(strtolower($attribute), array(
            'create',
            'view',
            'edit',
            'delete',
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

    protected function canCreate(TokenInterface $token, EventInterface $event)
    {
        // todo: need to be able to check calendar permissions here
        return $token->getUser() instanceof Organizer;
    }

    protected function canEdit(TokenInterface $token, EventInterface $event)
    {
        return $this->isOwner($token, $event);
    }

    protected function canDelete(TokenInterface $token, EventInterface $event)
    {
        return $this->isOwner($token, $event);
    }

    protected function canView(TokenInterface $token, EventInterface $event)
    {
        return $event->getCalendar()->isPublic() || $this->isOwner($token, $event);
    }

    private function isOwner(TokenInterface $token, EventInterface $event)
    {
        return $token->getUser() === $event->getOrganizer();
    }

}
