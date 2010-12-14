<?php

namespace Bundle\CalendarBundle\Expression\Expression;

use Bundle\CalendarBundle\Expression\Expression;

class DayOfTheYear implements Expression
{
    private $day;
    
    public function __construct($day)
    {
        $this->day = $day;
    }

    public function contains(\DateTime $dateTime)
    {
        return $this->day == $dateTime->format('z');
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        if ($this->day > 0) {
            if ($dateTime->sub($this->day . ' days')->format('Y') < $dateTime->format('Y')) {
                $nextOccurrence = \DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $dateTime->format('Y'), '01', '01'));
            } else {
                $nextOccurrence = \DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $dateTime->format('Y') + 1, '01', '01'));
            }
        } else {
            if ($dateTime->sub($this->day . ' days')->format('Y') > $dateTime->format('Y')) {
                $nextOccurrence = \DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $dateTime->format('Y'), 12, 31));
            } else {
                $nextOccurrence = \DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $dateTime->format('Y') + 1, 12, 31));
            }
        }

        $value = ($this->day < 0) ? -1 : 1;

        return $nextOccurrence->add($this->day - $value . ' days');
    }

    public function __toString()
    {
        return sprintf('DOTY(%s)', $this->day);
    }
}