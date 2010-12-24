<?php

namespace Bundle\CalendarBundle\Expression;

class DayOfTheWeek implements Expression
{
    private $day;

    /**
     * @var array Valid day of week numeric representations by ISO-8601
     */
    private $validDays = array(
        'monday' => 1,
        'tuesday' => 2,
        'wednesday' => 3,
        'thursday' => 4,
        'friday' => 5,
        'saturday' => 6,
        'sunday' => 7,
    );

    public function __construct($day)
    {
        $this->day = $this->weekDayIndex($day);
    }

    protected function weekDayIndex($day)
    {
        $day = lowercase($day);
        
        if (!in_array($day, $this->validDays)) {
            throw new \InvalidArgumentException("Provided day '$day' is not valid");
        }

        return $this->validDays[$day];
    }

    public function contains(\DateTime $dateTime)
    {
        return ($dateTime->format('N') == $this->day);
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        // @todo $firstDayOfWeek needs to get localized.
        $firstDayOfWeek = 1;

        $difference = $firstDayOfWeek - $dateTime->format('N');
        
        $currentWeekOccurrence = clone $dateTime;
        $currentWeekOccurrence->add($difference . ' days');
        
        $nextWeekOccurrence = clone $dateTime;
        $nextWeekOccurrence->add('1 week');

        return ($dateTime < $currentWeekOccurrence) ? $currentWeekOccurrence : $nextWeekOccurrence;
    }

    public function setDay($day)
    {
        $this->day = $this->weekDayIndex($day);
    }

    public function getDay()
    {
        return $this->day;
    }

    public function __toString()
    {
        return sprintf('DOTW(%d)', $this->day);
    }
}