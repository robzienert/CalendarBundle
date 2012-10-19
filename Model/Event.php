<?php

namespace Rizza\CalendarBundle\Model;

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Base class for the events
 */
abstract class Event implements EventInterface
{
    /**
     * The none status code
     *
     * @var integer
     */
    const STATUS_NONE = 0;

    /**
     * The tentative status code
     *
     * @var integer
     */
    const STATUS_TENTATIVE = 1;

    /**
     * The confirmed status code
     *
     * @var integer
     */
    const STATUS_CONFIRMED = 2;

    /**
     * The cancelled status code
     *
     * @var integer
     */
    const STATUS_CANCELLED = -1;

    /**
     * The unique id
     *
     * @var integer
     */
    protected $id;

    /**
     * The category
     *
     * @var string
     */
    protected $category;

    /**
     * The event's calendar
     *
     * @var CalendarInterface
     */
    protected $calendar;

    /**
     * The event's title
     *
     * @var string
     */
    protected $title;

    /**
     * The event's description
     *
     * @var string
     */
    protected $description;

    /**
     * The all day event's flag
     *
     * @var boolean
     */
    protected $allDay;

    /**
     * The start date
     *
     * @var DateTime
     */
    protected $startDate;

    /**
     * The end date
     *
     * @var DateTime
     */
    protected $endDate;

    /**
     * The event's exceptions (Collection of DateTime)
     *
     * @var ArrayCollection
     */
    protected $exceptions;

    /**
     * The event's status
     *
     * @var string
     */
    protected $status;

    /**
     * The event's location
     *
     * @var string
     */
    protected $location;

    /**
     * The event's url
     *
     * @var string
     */
    protected $url;

    /**
     * The event's recurences
     *
     * @var RecurrenceInterface
     */
    protected $recurrences;

    /**
     * The event's alarms
     *
     * @var ArrayCollection
     */
    protected $alarms;

    /**
     * The event's organizer
     *
     * @var Organizer
     */
    protected $organizer;

    /**
     * The event's attendees
     *
     * @var ArrayCollection
     */
    protected $attendees;

    public function __construct($title = null)
    {
        $this->title       = $title;
        $this->allDay      = false;
        $this->attendees   = new ArrayCollection();
        $this->recurrences = new ArrayCollection();
        $this->exceptions  = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCalendar(CalendarInterface $calendar)
    {
        $this->calendar = $calendar;
    }

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function setAllDay($allDay)
    {
        $this->allDay = (bool) $allDay;
    }

    public function getAllDay()
    {
        return $this->allDay;
    }

    public function isAllDay()
    {
        return $this->allDay;
    }

    public function setStartDate(DateTime $startDate)
    {
        if ($this->endDate instanceof DateTime
            && $this->endDate->getTimestamp() < $startDate->getTimestamp()
        ) {
            throw new \InvalidArgumentException('The start date must come before the end date');
        }

        $this->startDate = $startDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setEndDate(DateTime $endDate)
    {
        if ($this->startDate instanceof DateTime
            && $this->startDate->getTimestamp() > $endDate->getTimestamp()
        ) {
            throw new \InvalidArgumentException('The end date must come after the start date');
        }

        $this->endDate = $endDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getExceptions()
    {
        return $this->exceptions;
    }

    public function addException(DateTime $exception)
    {
        if (!$this->getExceptions()->contains($exception)) {
            $this->getExceptions()->add($exception);
        }
    }

    public function removeException(DateTime $exception)
    {
        if ($this->getExceptions()->contains($exception)) {
            $this->getExceptions()->removeElement($exception);
        }
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getRecurrences()
    {
        return $this->recurrences;
    }

    public function addRecurrence(RecurrenceInterface $recurrence)
    {
        if (!$this->getRecurrences()->contains($recurrence)) {
            $this->getRecurrences()->add($recurrence);
        }
    }

    public function removeRecurrence(RecurrenceInterface $recurrence)
    {
        if ($this->getRecurrences()->contains($recurrence)) {
            $this->getRecurrences()->removeElement($recurrence);
        }
    }

    public function setOrganizer(Organizer $organizer)
    {
        $this->organizer = $organizer;
    }

    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function getAttendees()
    {
        return $this->attendees;
    }

    public function addAttendee(AttendeeInterface $attendee)
    {
        if (!$this->attendees->contains($attendee)) {
            $this->attendees->add($attendee);
        }
    }

    public function removeAttendee(AttendeeInterface $attendee)
    {
        if ($this->attendees->contains($attendee)) {
            $this->attendees->removeElement($attendee);
        }
    }

    public function isOnDate(DateTime $dateTime)
    {
        if (!$this->startDate instanceof DateTime) {
            throw new \RuntimeException('Event does not have a start date');
        }
        if (!$this->endDate instanceof DateTime) {
            throw new \RunTimeException('Event does not have an end date');
        }

        $isOnDate = $this->isBetween($dateTime);

        // Check event's recurence
        if (!$isOnDate) {
            $recurrences = $this->getRecurrences();
            foreach ($recurrences as $recurrence) {
                if ($recurrence->contains($dateTime)) {
                    $isOnDate = true;
                    break;
                }
            }
        }

        // Check date exceptions
        if ($isOnDate) {
            $dateExceptions = $this->getExceptions();
            // @todo use DatePeriod ?
            foreach ($dateExceptions as $dateException) {
                if ($this->isInRange($dateTime, $dateException)) {
                    $isOnDate = false;
                    break;
                }
            }
        }

        return $isOnDate;
    }

    /**
     * Returns whether the $dateTime is included between the event's dates.
     *
     * @param DateTime $dateTime The datetime to test
     *
     * @return boolean
     */
    private function isBetween(DateTime $dateTime)
    {
        return ($this->startDate <= $dateTime && $this->endDate >= $dateTime);
    }

    /**
     * Returns whether the $dateTime is included between the event's dates.
     *
     * @param DateTime $dateTime1 The datetime to test
     * @param DateTime $dateTime2 The datetime to compare
     *
     * @return boolean
     */
    private function isInRange(DateTime $dateTime1, DateTime $dateTime2)
    {
        $diff = $dateTime1->diff($dateTime2)->format("%r%a%H%I%S");

        // More or less 1 hour
        return ($diff >= -10000 && $diff <= 10000);
    }
}