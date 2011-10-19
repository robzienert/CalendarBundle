<?php

namespace Rizza\CalendarBundle\Model;

interface EventManagerInterface
{

    /**
     * @return EventInterface
     */
    public function createEvent(CalendarInterface $calendar);

    /**
     * @return boolean whether the event was successfully persisted
     */
    public function addEvent(EventInterface $event);

    /**
     * @return boolean whether the event was successfully updated
     */
    public function updateEvent(EventInterface $event);

    /**
     * @return boolean whether the event was successfully removed
     */
    public function removeEvent(EventInterface $event);

    /**
     * @return EventInterface
     * @throws NotFoundHttpException if the event cannot be found
     */
    public function find($id);

    public function findAll();

    public function findVisible($organizer);

    public function getClass();

}
