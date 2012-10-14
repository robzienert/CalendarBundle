<?php

namespace Rizza\CalendarBundle\Model;

interface EventManagerInterface
{
    /**
     * Create an event
     *
     * @param CalendarInterface $calendar The event's calendar
     *
     * @return EventInterface
     */
    public function createEvent(CalendarInterface $calendar);

    /**
     * Add an event
     *
     * @param EventInterface $event The event to add
     *
     * @return boolean whether the event was successfully persisted
     */
    public function addEvent(EventInterface $event);

    /**
     * Update an event
     *
     * @param EventInterface $event The event to update
     *
     * @return boolean whether the event was successfully updated
     */
    public function updateEvent(EventInterface $event);

    /**
     * Remove an event
     *
     * @param EventInterface $event The event to remove
     *
     * @return boolean whether the event was successfully removed
     */
    public function removeEvent(EventInterface $event);

    /**
     * Find an event
     *
     * @param integer $id The id to find
     *
     * @return EventInterface
     * @throws NotFoundHttpException if the event cannot be found
     */
    public function find($id);

    /**
     * Find all events
     *
     * @return array
     */
    public function findAll();

    /**
     * Find all visible events for the $organizer
     *
     * @param Organizer $organizer The creator of the event
     *
     * @return array
     */
    public function findVisible($organizer);

    /**
     * Returns the class
     *
     * @return string
     */
    public function getClass();

    /**
     * Whether the $user is the admin of the $event.
     *
     * @param UserInterface  $user  The user
     * @param EventInterface $event The event
     *
     * @return boolean
     */
    public function isAdmin($user, EventInterface $event);
}