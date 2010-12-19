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
                $calendarDays = cal_days_in_month(CAL_GREGORIAN, $dateTime->format('Y'), $dateTime->format('m'));
                return ($calendarDays + 1 + $this->day) === $dateTime->format('j');
            }
        } else {
            $value = ($this->day < 0) ? -1 : 1;

            $compare = clone $dateTime();

            $dayOfWeek = jddayofweek(cal_to_jd(CAL_GREGORIAN, $dateTime->format('m'), $dateTime->format('j'), $dateTime->format('Y')));
            return ($this->day == $dayOfWeek) &&
                ($compare->add((-1 * $this->day) . ' days')->format('m') != $dateTime->format('m')) &&
                ($compare->setDate($dateTime->getTimestamp())->add((-1 * $this->day) + $value)->format('m') == $dateTime->format('m'));
        }
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        $currentMonthOccurrence = new DateTime();
        $nextMonthOccurrence = new DateTime();

        if ($this->ignoreDay) {
            if ($this->day > 0) {
                $clone = clone $dateTime;

                $currentMonthOccurrence = new DateTime($clone->getTimestamp());

                $clone->setDate($dateTime->getTimestamp())->add('1 month');
                $nextMonthOccurrence = new DateTime($clone->format('Y'), $clone->format('m'), $dateTime->format('j'));
            } else {
                $calendarDays = cal_days_in_month(CAL_GREGORIAN, $dateTime->format('Y'), $dateTime->format('m')) + ($dateTime->format('j') + 1 + $this->day);
                $currentMonthOccurrence = new DateTime($dateTime->format('Y'), $dateTime->format('m'), $calendarDays);

                $clone = clone $dateTime;
                $clone->add('1 months');

                $calendarDays = cal_days_in_month(CAL_GREGORIAN, $clone->format('Y'), $clone->format('m'), ($clone->format('j')));
            }
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

    public function __toString()
    {
        return sprintf('DOTM(%s)', $this->day);
    }
}