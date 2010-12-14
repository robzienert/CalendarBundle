<?php

namespace Bundle\CalendarBundle\Temporal\Expression;

class MonthOfTheYear implements Expression
{
    private $month;

    public function __construct($month)
    {
        $this->month = (int) $month;
    }

    public function contains(\DateTime $dateTime)
    {
        if ($this->month > 0) {
            return $dateTime->format('n') == $this->month;
        } else {
            return $dateTime->format('n') == (13 - $this->month);
        }
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        $currentYearOccurrence = \DateTime::createFromFormat('Y-m-d', $dateTime->format('Y'), $dateTime->format('m'), $dateTime->format('d'));
        $nextYearOccurrence = \DateTime::createFromFormat('Y-m-d', $dateTime->format('Y') + 1, $dateTime->format('m'), $dateTime->format('d'));

        if ($dateTime < $currentYearOccurrence) {
            return $currentYearOccurrence;
        } else if ($dateTime > $currentYearOccurrence && $this->contains($dateTime->add('1 days'))) {
            return $dateTime->add('1 days');
        } else {
            return $nextYearOccurrence;
        }
    }

    public function __toString()
    {
        return sprintf('MOTY(%d)', $this->month);
    }
}