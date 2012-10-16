<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\AttendeeInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityAttendeeBlamer implements AttendeeBlamerInterface
{
    /**
     * The security context
     *
     * @var SecurityContextInterface
     */
    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Blamer\AttendeeBlamerInterface::blame()
     */
    public function blame(AttendeeInterface $attendee)
    {
        $token = $this->securityContext->getToken();
        if (null === $token) {
            throw new \RuntimeException('You must configure a firewall for this route');
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $attendee->setUser($token->getUser());
        }
    }
}