<?php

namespace Rizza\CalendarBundle\DateProcessor;

class DayOfTheWeek implements Processor
{
    protected $day;

    /**
     * Valid day of week numeric representations by ISO-8601
     *
     * @var array
     */
    protected $validDays = array(
        'monday' => 1,
        'tuesday' => 2,
        'wednesday' => 3,
        'thursday' => 4,
        'friday' => 5,
        'saturday' => 6,
        'sunday' => 7
    );

    public function __construct($day = null)
    {
        if (null !== $day) {
            $this->setDay($day);
        }
    }

    public function getDay()
    {
        return $this->day;
    }

    public function setDay($day)
    {
        if (0 == intval($day)) {
            $day = strtolower($day);

            if (!array_key_exists($day, $this->validDays)) {
                throw new \InvalidArgumentException('The provided day is invalid');
            }

            $day = $this->validDays[$day];
        } else if ($day > 7 || $day < 1) {
            throw new \RangeException('Invalid day numeric provided');
        }
        
        $this->day = (int) $day;
    }

    public function contains(\DateTime $dateTime)
    {
        return ($dateTime->format('N') == $this->day);
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        // @todo $firstDayOfWeek needs to get localized
        $firstDayOfWeek = 1;

        $diff = $firstDayOfWeek - $dateTime->format('N');

        $currentWeekOccurrence = clone $dateTime;
        $currentWeekOccurrence->add(new \DateInterval($diff . 'D'));

        $nextWeekOccurrence = clone $dateTime;
        $nextWeekOccurrence->add(new \DateInterval('1W'));

        return ($dateTime < $currentWeekOccurrence)
            ? $currentWeekOccurrence
            : $nextWeekOccurrence;
    }
}