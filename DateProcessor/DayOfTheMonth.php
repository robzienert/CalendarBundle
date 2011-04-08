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
        $value = ($this->day < 0) ? -1 : 1;

        $compare = clone $dateTime();

        $dayOfWeek = jddayofweek(cal_to_jd(CAL_GREGORIAN,
                                           $dateTime->format('m'),
                                           $dateTime->format('j'),
                                           $dateTime->format('Y')));

        return ($this->day == $dayOfWeek) &&
            ($compare->add((-1 * $this->day) . ' days')->format('m') != $dateTime->format('m')) &&
            ($compare->setDate($dateTime->getTimestamp())->add((-1 * $this->day) + $value)->format('m') == $dateTime->format('m'));
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        throw new Exception('Not implemented yet.');
    }

    public function setDay($day)
    {
        $this->day = (int) $day;
    }

    public function getDay()
    {
        return $this->day;
    }
}