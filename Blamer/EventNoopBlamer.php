<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\EventInterface;

class EventNoopBlamer implements EventBlamerInterface
{

    public function blame(EventInterface $event)
    {
        // do nothing
    }

}
