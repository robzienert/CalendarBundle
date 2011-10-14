<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface CalendarInterface
{

    const VISIBILITY_PUBLIC = 1;
    const VISIBILITY_PRIVATE = 2;

    /**
     * Returns the ID of the calendar.
     *
     * @return int
     */
    public function getId();

    /**
     * Set the owner user of the calendar.
     *
     * @param UserInterface $owner
     */
    public function setOwner(UserInterface $owner);

    /**
     * Get the owner user of the calendar.
     *
     * @return UserInterface
     */
    public function getOwner();

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
     * Get all associated events that fall on a given day.
     *
     * @return ArrayCollection
     */
    public function getEventsOnDay(\DateTime $dateTime);

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

    /**
     * Set the visibility of the calendar.
     *
     * @param integer $visibility
     */
    public function setVisibility($visibility);

    /**
     * Get the visibility of the calendar.
     */
    public function getVisibility();

    /**
     * Whether the calendar is public.
     */
    public function isPublic();

    /**
     * Whether the calendar is private.
     */
    public function isPrivate();
}