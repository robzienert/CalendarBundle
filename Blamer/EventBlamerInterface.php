<?php

namespace Rizza\CalendarBundle\Blamer;

use Rizza\CalendarBundle\Model\EventInterface;

interface EventBlamerInterface
{

    public function blame(EventInterface $event);

}
