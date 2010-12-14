<?php

namespace Bundle\CalendarBundle\Temporal\Expression;

class DayOfTheMonth implements Expression
{
    private $day;

    private $ignoreDay;
    
    public function __construct($day, $ignoreDay = true)
    {
        $this->setDay($day);
        $this->setIgnoreDay($ignoreDay);
    }

    public function contains(\DateTime $dateTime)
    {
        if ($this->ignoreDay) {
            if ($this->day > 0) {
                return $dateTime->format('j') == $this->day;
            } else {
                // @todo Get the calendar days in months; then compare to provided datetime object
                // return ($this->calendar->getDays($year, $month) + 1 + $this->day) == $dateTime->format('j'));
            }
        } else {
            $value = ($this->day < 0) ? -1 : 1;
        }
    }

    public function setDay($day)
    {
        $this->day = (int) $day;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function setIgnoreDay($ignoreDay)
    {
        $this->ignoreDay = (bool) $ignoreDay;
    }

    public function getIgnoreDay()
    {
        return $this->ignoreDay;
    }
}