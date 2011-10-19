<?php

namespace Rizza\CalendarBundle\Creator;

use Rizza\CalendarBundle\Model\EventInterface;
use Rizza\CalendarBundle\Model\EventManagerInterface;
use Rizza\CalendarBundle\Blamer\EventBlamerInterface;

class EventCreator implements EventCreatorInterface
{

    protected $eventManager;
    protected $eventBlamer;

    public function __construct(EventManagerInterface $eventManager, EventBlamerInterface $eventBlamer)
    {
        $this->eventManager = $eventManager;
        $this->eventBlamer = $eventBlamer;
    }

    public function create(EventInterface $event)
    {
        $this->eventBlamer->blame($event);
        $this->eventManager->addEvent($event);

        return true;
    }

}
