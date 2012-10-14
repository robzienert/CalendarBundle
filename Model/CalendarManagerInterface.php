<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface CalendarManagerInterface
{
    /**
     * Create a calendar
     *
     * @return CalendarInterface
     */
    public function createCalendar();

    /**
     * Add a calendar
     *
     * @param CalendarInterface $calendar The calendar to add
     *
     * @return boolean whether the calendar was successfully persisted
     */
    public function addCalendar(CalendarInterface $calendar);

    /**
     * Update a calendar
     *
     * @param CalendarInterface $calendar The calendar to update
     *
     * @return boolean whether the calendar was successfully updated
     */
    public function updateCalendar(CalendarInterface $calendar);

    /**
     * Remove a calendar
     *
     * @param CalendarInterface $calendar The calendar to remove
     *
     * @return boolean whether the calendar was successfully removed
     */
    public function removeCalendar(CalendarInterface $calendar);

    /**
     * Find a calendar
     *
     * @param integer $id The calendar's id
     *
     * @return CalendarInterface
     * @throws NotFoundHttpException if the calendar cannot be found
     */
    public function find($id);

    /**
     * Find all the calendars
     *
     * @return array
     */
    public function findAll();

    /**
     * Find all visible calendars of the $user.
     *
     * @param unknown_type $user
     *
     * @return array
     */
    public function findVisible($user);

    /**
     * Returns the class
     *
     * @return string
     */
    public function getClass();

    /**
     * Whether the $user is the admin of the $calendar.
     *
     * @param unknown_type $user
     * @param CalendarInterface $calendar
     *
     * @return boolean
     */
    public function isAdmin($user, CalendarInterface $calendar);
}