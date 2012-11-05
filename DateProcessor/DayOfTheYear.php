<?php

namespace Rizza\CalendarBundle\DateProcessor;

use \DateInterval;
use \DateTime;
use \InvalidArgumentException;

/**
 * This class represents a day from the year ranging from 1 to 366
 * or -366 to -1. The number indicate the days within a year that this
 * recurrence occurs. Negative values indicate the number of days from
 * the last day of the year.
 */
class DayOfTheYear implements Processor
{
    /**
     * The day of the year.
     *
     * @var integer
     */
    protected $day;

    /**
     * The construct
     *
     * @param integer|DateTime $day The day of the year
     */
    public function __construct($day)
    {
        $this->setDay($day);
    }

    public function contains(DateTime $dateTime)
    {
        return $this->day == $dateTime->format('z') + 1;
    }

    public function getNextOccurrence(DateTime $dateTime)
    {
        $substractedDateTime = clone $dateTime;
        $substractedDateTime->sub(DateInterval::createFromDateString($this->day . ' days'));


        if ($this->day > 0) {
            if ($substractedDateTime->format('Y') < $dateTime->format('Y')) {
                $nextOccurrence = DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $dateTime->format('Y'), '01', '01'));
            } else {
                $nextOccurrence = DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $dateTime->format('Y') + 1, '01', '01'));
            }
        } else {
            if ($substractedDateTime->format('Y') > $dateTime->format('Y')) {
                $nextOccurrence = DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $dateTime->format('Y'), 12, 31));
            } else {
                $nextOccurrence = DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $dateTime->format('Y') + 1, 12, 31));
            }
        }

        $value = ($this->day < 0) ? -1 : 1;

        return $nextOccurrence->add(DateInterval::createFromDateString($this->day - $value . ' days'));
    }

    /**
     * Set the day
     *
     * @param integer $day The day of the year
     *
     * @throws InvalidArgumentException
     *
     * @return \Rizza\CalendarBundle\DateProcessor\DayOfTheYear
     */
    public function setDay($day)
    {
        $day = (int) $day;

        if ($day > 366 || $day < -366 || $day === 0) {
            throw new InvalidArgumentException("The day '{$day}' is not a suported format");
        }

        $this->day = $day;

        return $this;
    }

    /**
     * Returns the day of the year
     *
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }
}