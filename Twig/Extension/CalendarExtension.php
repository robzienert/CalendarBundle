<?php

namespace Rizza\CalendarBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Rizza\CalendarBundle\Model\CalendarInterface;

class CalendarExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'calendarMonth' => new \Twig_Filter_Method($this, 'calendarMonth', array('is_safe' => array('html'))),
        );
    }

    public function calendarMonth(CalendarInterface $calendar, $month, $year)
    {
        $time = mktime(0, 0, 0, $month, 1, $year);
        $daysInMonth = date('t', $time);
        $daysInPreviousMonth = $this->getDaysInPreviousMonth($month, $year); 
        $runningDay = date('w', $time);
        $daysInWeek = 1;
        $dayCounter = 0;

        $rows = '<tr>';
        for ($i = 0; $i < $runningDay; $i++) {
            $day = $daysInPreviousMonth - ($runningDay - $i);
            $rows .= '<td class="calendar-day-disabled">' . $day . '</td>';
        }

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $rows .= '<td class="calendar-day">';
            $rows .= '<div class="day-number">' . $day . '</div>';


            // @todo Find events from the given calendar falling on this day.
            $dateTime = \DateTime::createFromFormat('Y-m-d', sprintf('%d-%d-%d', $year, $month, $day));
            foreach ($calendar->getEventsOnDay($dateTime) as $event) {
                $rows .= $event->getTitle() . ' &amp; ';
            }

            $rows .= '</td>';
            if (6 == $runningDay) {
                $rows .= '</tr>';

                if (($dayCounter + 1) != $daysInMonth) {
                    $rows .= '<tr>';
                }

                $runningDay  = -1;
                $daysInWeek = 0;
            }

            $daysInWeek++;
            $runningDay++;
            $dayCounter++;
        }

        if ($daysInWeek < 8) {
            for ($i = 1, $n = (8 - $daysInWeek); $i <= $n; $i++) {
                $rows .= '<td class="calendar-day-disabled">' . $i . '</td>';
            }
        }

        $rows .= '</tr>';

        return sprintf(
            '<table class="calendar">
                <tr class="calendar-header">
                    <th>Sunday</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                </tr>
                %s
            </table>',
            $rows);
    }

    protected function getDaysInPreviousMonth($month, $year)
    {
        if (1 == $month) {
            $month = 12;
            --$year;
        }

        $days = date('t', mktime(0, 0, 0, $month, 1, $year));

        return $days;
    }

    public function getName()
    {
        return 'calendar';
    }
}