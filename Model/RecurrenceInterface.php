<?php

namespace Rizza\CalendarBundle\Model;

interface RecurrenceInterface
{
    public function getId();

    public function setEvent(EventInterface $event);

    public function getEvent();

    public function getDays();

    public function addDay($day);

    public function removeDay($day);

    public function getDayFrequency();

    public function addDayFrequence($frequency);

    public function removeDayFrequency($frequency);

    public function getMonths();

    public function addMonth($month);

    public function removeMonth($month);

    public function getMonthDays();

    public function addMonthDay($day);

    public function removeMonthDay($day);

    public function getWeekNumbers();

    public function addWeekNumber($week);

    public function removeWeekNumber($week);

    public function getYearDays();

    public function addYearDay($day);

    public function removeYearDay($day);

    public function setFrequency($frequency);

    public function getFrequency();

    public function setInterval($interval);

    public function getInterval();

    public function setUntil(\DateTime $until);

    public function getUntil();

    public function setWeekStartDay($day);

    public function getWeekStartDay();

    public function contains(\DateTime $dateTime);

    public function getOccurrences(\DateTime $betweenStart = null, \DateTime $betweenEnd = null);
}