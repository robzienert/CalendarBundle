<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\CalendarInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityCalendarBlamer implements CalendarBlamerInterface
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

    public function blame(CalendarInterface $calendar)
    {
        $token = $this->securityContext->getToken();
        if (null === $token) {
            throw new \RuntimeException('You must configure a firewall for this route');
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $calendar->setOwner($token->getUser());
        }
    }
}