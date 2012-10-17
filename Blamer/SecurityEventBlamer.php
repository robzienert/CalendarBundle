<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\EventInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityEventBlamer implements EventBlamerInterface
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

    public function blame(EventInterface $event)
    {
        $token = $this->securityContext->getToken();
        if (null === $token) {
            throw new \RuntimeException('You must configure a firewall for this route');
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $event->setOrganizer($token->getUser());
        }
    }
}