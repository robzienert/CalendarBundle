<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface EventInterface
{
    /**
     * Get the unqiue ID for the event.
     *
     * @return int
     */
    public function getId();

    /**
     * Set the title of the event
     *
     * @param string $title
     */
    public function setTitle($title);

    /**
     * Get the title of the event
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set the description of the event
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * Get the description of the event
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set the category
     *
     * @param string $category
     */
    public function setCategory($category);

    /**
     * Get the category
     *
     * @return string
     */
    public function getCategory();

    /**
     * Set the calendar the event belongs to
     *
     * @param CalendarInterface $calendar
     */
    public function setCalendar(CalendarInterface $calendar);

    /**
     * Get the calendar
     *
     * @return CalendarInterface
     */
    public function getCalendar();

    /**
     * Sets whether or not the event lasts all day
     *
     * @param bool $allDay
     */
    public function setAllDay($allDay);

    /**
     * Get whether or not the event lasts all day.
     *
     * @return bool
     */
    public function getAllDay();

    /**
     * Alias to {@see getAllDay()}
     *
     * @return bool
     */
    public function isAllDay();

    /**
     * Set the start date/time of the event
     *
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate);

    /**
     * Get the start date/time of the event
     *
     * @return \DateTime
     */
    public function getStartDate();

    /**
     * Set the end date/time of the event
     *
     * @param \DateTime $dateTime
     */
    public function setEndDate(\DateTime $endDate);

    /**
     * Get the end date/time of the event
     *
     * @return \DateTime
     */
    public function getEndDate();

    /**
     * Get the recurrence exceptions
     *
     * @return ArrayCollection
     */
    public function getExceptions();

    /**
     * Add a DateTime to the recurrence exception collection
     *
     * @param \DateTime $exception
     */
    public function addException(\DateTime $exception);

    /**
     * Remove a DateTime from the recurrence exception collection
     *
     * @param \DateTime $exception
     */
    public function removeException(\DateTime $exception);

    /**
     * Set where the event will be / was at.
     *
     * @param string $location
     */
    public function setLocation($location);

    /**
     * Get the location of the event
     *
     * @return string
     */
    public function getLocation();

    /**
     * Set the relevant URL for the event
     *
     * @param string $url
     */
    public function setUrl($url);

    /**
     * Get the relevant URL.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Get a collection of recurrences
     *
     * @return ArrayCollection
     */
    public function getRecurrences();

    /**
     * Add a recurrence date
     *
     * @param RecurrenceInterface $recurrence
     */
    public function addRecurrence(RecurrenceInterface $recurrence);

    /**
     * Remove a recurrence.
     *
     * @param RecurrenceInterface $recurrence
     */
    public function removeRecurrence(RecurrenceInterface $recurrence);

    /**
     * Set the event organizer
     *
     * @param Organizer $organizer
     */
    public function setOrganizer(Organizer $organizer);

    /**
     * Get the event organizer
     *
     * @return Organizer
     */
    public function getOrganizer();

    /**
     * Get a collection of the attendees
     *
     * @return ArrayCollection
     */
    public function getAttendees();

    /**
     * Add an attendee
     *
     * @param AttendeeInterface $attendee
     */
    public function addAttendee(AttendeeInterface $attendee);

    /**
     * Remove an attendee
     *
     * @param AttendeeInterface $attendee
     */
    public function removeAttendee(AttendeeInterface $attendee);

    /**
     * Returns whether or not the event is on a given DateTime
     *
     * @param \DateTime $dateTime
     * @return bool
     */
    public function isOnDate(\DateTime $dateTime);
}