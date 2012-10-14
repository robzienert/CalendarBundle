<?php

namespace Rizza\CalendarBundle\Model;

interface AttendeeManagerInterface
{
    /**
     * Returns the class
     *
     * @return string
     */
    public function getClass();

    /**
     * Create an attendee
     *
     * @param EventInterface $event The event
     *
     * @return AttendeeInterface
     */
    public function createAttendee(EventInterface $event);

    /**
     * Find the attendee
     *
     * @return AttendeeInterface
     */
    public function find($id);

    /**
     * Add an attendee
     *
     * @param AttendeeInterface $attendee
     */
    public function addAttendee(AttendeeInterface $attendee);

    /**
     * Update the attendee
     *
     * @param AttendeeInterface $attendee
     */
    public function updateAttendee(AttendeeInterface $attendee);

    /**
     * Remove the attendee
     *
     * @param AttendeeInterface $attendee
     */
    public function removeAttendee(AttendeeInterface $attendee);

    /**
     * Whether the $user is the event admin
     *
     * @param UserInterface     $user
     * @param AttendeeInterface $attendee
     *
     * @return boolean
     */
    public function isAdmin($user, AttendeeInterface $attendee);
}