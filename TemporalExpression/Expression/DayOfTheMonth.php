<?php

namespace Bundle\CalendarBundle\TemporalExpression\Expression;

use Bundle\CalendarBundle\TemporalExpression\TemporalExpression;

class DayOfTheMonth implements TemporalExpression
{
    private $day;

    private $ignoreDay;
    
    public function __construct($day, $ignoreDay = true)
    {
        $this->day = (int) $day;
        $this->ignoreDay = (bool) $ignoreDay;
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
}