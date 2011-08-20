<?php

namespace Rizza\CalendarBundle\Model;

interface CalendarInterface
{
    /**
     * Returns the ID of the calendar.
     *
     * @return int
     */
    public function getId();

    /**
     * Set the name of the calendar.
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get the name of the calendar.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the associated events with this calendar.
     *
     * @return ArrayCollection
     */
    public function getEvents();

    /**
     * Add an event to the calendar.
     *
     * @param EventInterface $event
     */
    public function addEvent(EventInterface $event);

    /**
     * Remove an event from the calendar.
     *
     * @param EventInterface $event
     */
    public function removeEvent(EventInterface $event);
}