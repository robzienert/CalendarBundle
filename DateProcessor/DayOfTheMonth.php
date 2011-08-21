<?php

namespace Rizza\CalendarBundle\DateProcessor;

class DayOfTheMonth implements Processor
{
    protected $day;
    
    public function __construct($day = 0)
    {
        $this->setDay($day);
    }

    public function contains(\DateTime $dateTime)
    {
        return ($this->day == $dateTime->format('j'));
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        throw new Exception('Not implemented yet.');
    }

    public function setDay($day)
    {
        $this->day = (int) $day;

        return $this;
    }

    public function getDay()
    {
        return $this->day;
    }
}