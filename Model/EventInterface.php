<?php

namespace Rizza\CalendarBundle\Model;

interface EventInterface
{
    public function getId();

    public function setTitle($title);

    public function getTitle();

    public function setDescription($description);

    public function getDescription();

    public function setCategory($category);

    public function getCategory();

    public function setCalendar(CalendarInterface $calendar);

    public function getCalendar();

    public function setAllDay($allDay);

    public function getAllDay();

    public function isAllDay();

    public function setStartDate(\DateTime $startDate);

    public function getStartDate();

    public function setEndDate(\DateTime $endDate);

    public function getEndDate();

    public function getExceptions();

    public function addException(\DateTime $exception);

    public function removeException(\DateTime $exception);

    public function setLocation($location);

    public function getLocation();

    public function setUrl($url);

    public function getUrl();

    public function getRecurrences();

    public function addRecurrence(RecurrenceInterface $recurrence);

    public function removeRecurrence(RecurrenceInterface $recurrence);

    public function setOrganizer(Organizer $organizer);

    public function getOrganizer();

    public function getAttendees();

    public function addAttendee(Attendee $attendee);

    public function removeAttendee(Attendee $attendee);

    public function isOnDate(\DateTime $dateTime);
}