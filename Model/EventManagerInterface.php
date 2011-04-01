<?php

namespace Rizza\CalendarBundle\Model;

interface EventRepositoryInterface
{
    /**
     * Returns all events for a specific date.
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return Doctrine\Common\Collections\Collection
     */
    public function findByDate($year, $month, $day);

    /**
     * Returns all events for a specific month.
     *
     * @param int $month
     * @return Doctrine\Common\Collections\Collection
     */
    public function findByMonth($month);

    /**
     * Returns all events for a specific Calendar.
     *
     * @param CalendarInterface $calendar
     * @return Doctrine\Common\Collections\Collection
     */
    public function findByCalendar(CalendarInterface $calendar);
}