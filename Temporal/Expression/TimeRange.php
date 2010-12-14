<?php

namespace Bundle\CalendarBundle\Temporal\Expression;

class TimeRange implements Expression
{
    private $firstTime;

    private $lastTime;

    public function __construct(TimeSpan $firstTime, TimeSpan $lastTime)
    {
        $this->firstTime = $firstTime;
        $this->lastTime = $lastTime;
    }

    public function contains(\DateTime $dateTime)
    {
        return $dateTime->format('G-i') >= $this->firstTime && $dateTime->format('G-i') <= $this->secondTime;
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
    }
}