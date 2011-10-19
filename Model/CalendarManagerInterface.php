<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface CalendarManagerInterface
{

    /**
     * @return CalendarInterface
     */
    public function createCalendar();

    /**
     * @return boolean whether the calendar was successfully persisted
     */
    public function addCalendar(CalendarInterface $calendar);

    /**
     * @return boolean whether the calendar was successfully updated
     */
    public function updateCalendar(CalendarInterface $calendar);

    /**
     * @return boolean whether the calendar was successfully removed
     */
    public function removeCalendar(CalendarInterface $calendar);

    /**
     * @return CalendarInterface
     * @throws NotFoundHttpException if the calendar cannot be found
     */
    public function find($id);

    public function findAll();

    public function findVisible($user);

    public function getClass();

    public function isAdmin($user, CalendarInterface $calendar);

}
