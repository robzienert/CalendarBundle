<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\AttendeeInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityAttendeeBlamer implements AttendeeBlamerInterface
{

    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function blame(AttendeeInterface $attendee)
    {
        if (null === $this->securityContext->getToken()) {
            throw new \RuntimeException('You must configure a firewall for this route');
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $attendee->setUser($this->securityContext->getToken()->getUser());
        }
    }

}
