<?php

namespace Rizza\CalendarBundle\Creator;

use Rizza\CalendarBundle\Model\EventInterface;

interface EventCreatorInterface
{

    public function create(EventInterface $event);

}
