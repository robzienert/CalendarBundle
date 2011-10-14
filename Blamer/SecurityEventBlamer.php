<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\EventInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityEventBlamer implements EventBlamerInterface
{

    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function blame(EventInterface $event)
    {
        if (null === $this->securityContext->getToken()) {
            throw new \RuntimeException('You must configure a firewall for this route');
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $event->setOrganizer($this->securityContext->getToken()->getUser());
        }
    }

}
