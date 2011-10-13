<?php

namespace Rizza\CalendarBundle\Blamer;

class EventNoopBlamer implements EventBlamerInterface
{

    public function blame(EventInterface $event)
    {
        // do nothing
    }

}
