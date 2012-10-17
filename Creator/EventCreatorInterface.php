<?php

namespace Rizza\CalendarBundle\Creator;

use Rizza\CalendarBundle\Model\EventInterface;

interface EventCreatorInterface
{
    /**
     * Create an event
     *
     * @param EventInterface $event The event to create
     *
     * @return boolean Whether the creation was a success
     */
    public function create(EventInterface $event);
}