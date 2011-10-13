<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\CalendarInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityCalendarBlamer implements CalendarBlamerInterface
{

    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function blame(CalendarInterface $calendar)
    {
        if (null === $this->securityContext->getToken()) {
            throw new \RuntimeException('You must configure a firewall for this route');
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $calendar->setOwner($this->securityContext->getToken()->getUser());
        }
    }

}
