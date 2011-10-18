<?php

namespace Rizza\CalendarBundle\Creator;

use Rizza\CalendarBundle\Model\CalendarManagerInterface;
use Rizza\CalendarBundle\Blamer\CalendarBlamerInterface;
use Rizza\CalendarBundle\Model\CalendarInterface;

class CalendarCreator implements CalendarCreatorInterface
{

    protected $calendarManager;
    protected $calendarBlamer;

    public function __construct(CalendarManagerInterface $calendarManager, CalendarBlamerInterface $calendarBlamer)
    {
        $this->calendarManager = $calendarManager;
        $this->calendarBlamer = $calendarBlamer;
    }

    public function create(CalendarInterface $calendar)
    {
        $this->calendarBlamer->blame($calendar);
        $this->calendarManager->addCalendar($calendar);

        return true;
    }

}
