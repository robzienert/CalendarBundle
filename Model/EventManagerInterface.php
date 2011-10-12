<?php

namespace Rizza\CalendarBundle\Model;

interface EventManagerInterface
{

    /**
     * @return EventInterface
     */
    function createEvent();

    /**
     * @return boolean whether the event was successfully persisted
     */
    function addEvent(EventInterface $event);

    /**
     * @return boolean whether the event was successfully updated
     */
    function updateEvent(EventInterface $event);

    /**
     * @return boolean whether the event was successfully removed
     */
    function removeEvent(EventInterface $event);

    /**
     * @return EventInterface
     * @throws NotFoundHttpException if the event cannot be found
     */
    function find($id);

    function findAll();

    function getClass();

}
