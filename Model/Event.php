<?php

namespace Rizza\CalendarBundle\Model;

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
     * @var \DateTime
     */
    protected $startDate;

    /**
     * The end date
     *
     * @var \DateTime
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
     * @var UserInterface
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
        $this->title = $title;
        $this->allDay = false;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setTitle()
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getTitle()
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setDescription()
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getDescription()
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setCategory()
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getCategory()
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setCalendar()
     */
    public function setCalendar(CalendarInterface $calendar)
    {
        $this->calendar = $calendar;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getCalendar()
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setAllDay()
     */
    public function setAllDay($allDay)
    {
        $this->allDay = (bool) $allDay;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getAllDay()
     */
    public function getAllDay()
    {
        return $this->allDay;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::isAllDay()
     */
    public function isAllDay()
    {
        return $this->allDay;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setStartDate()
     */
    public function setStartDate(\DateTime $startDate)
    {
        if ($this->endDate instanceof \DateTime
            && $this->endDate->getTimestamp() < $startDate->getTimestamp()
        ) {
            throw new \InvalidArgumentException('The start date must come before the end date');
        }

        $this->startDate = $startDate;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getStartDate()
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setEndDate()
     */
    public function setEndDate(\DateTime $endDate)
    {
        if ($this->startDate instanceof \DateTime
            && $this->startDate->getTimestamp() > $endDate->getTimestamp()
        ) {
            throw new \InvalidArgumentException('The end date must come after the start date');
        }

        $this->endDate = $endDate;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getEndDate()
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getExceptions()
     */
    public function getExceptions()
    {
        return $this->exceptions ?: $this->exceptions = new ArrayCollection();
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::addException()
     */
    public function addException(\DateTime $exception)
    {
        if (!$this->getExceptions()->contains($exception)) {
            $this->getExceptions()->add($exception);
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::removeException()
     */
    public function removeException(\DateTime $exception)
    {
        if ($this->getExceptions()->contains($exception)) {
            $this->getExceptions()->removeElement($exception);
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setLocation()
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getLocation()
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setUrl()
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getUrl()
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getRecurrences()
     */
    public function getRecurrences()
    {
        return $this->recurrences ?: $this->recurrences = new ArrayCollection();
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::addRecurrence()
     */
    public function addRecurrence(RecurrenceInterface $recurrence)
    {
        if (!$this->getRecurrences()->contains($recurrence)) {
            $this->getRecurrences()->add($recurrence);
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::removeRecurrence()
     */
    public function removeRecurrence(RecurrenceInterface $recurrence)
    {
        if ($this->getRecurrences()->contains($recurrence)) {
            $this->getRecurrences()->removeElement($recurrence);
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::setOrganizer()
     */
    public function setOrganizer(UserInterface $organizer)
    {
        $this->organizer = $organizer;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getOrganizer()
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::getAttendees()
     */
    public function getAttendees()
    {
        return $this->attendees ?: $this->attendees = new ArrayCollection();
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::addAttendee()
     */
    public function addAttendee(Attendee $attendee)
    {
        if (!$this->getAttendees()->contains($attendee)) {
            $this->getAttendees()->add($attendee);
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::removeAttendee()
     */
    public function removeAttendee(Attendee $attendee)
    {
        if ($this->getAttendees()->contains($attendee)) {
            $this->getAttendees()->removeElement($attendee);
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\EventInterface::isOnDate()
     */
    public function isOnDate(\DateTime $dateTime)
    {
        if (!$this->startDate instanceof \DateTime) {
            throw new \RuntimeException('Event does not have a start date');
        }
        if (!$this->endDate instanceof \DateTime) {
            throw new \RunTimeException('Event does not have an end date');
        }

        $onDate = (($this->startDate->format('Y-m-d') <= $dateTime->format('Y-m-d')
            && $this->endDate->format('Y-m-d') >= $dateTime->format('Y-m-d')));

        if (!$onDate) {
            while ($this->getRecurrences()->next()) {
                if ($this->getRecurrences()->current()->contains($dateTime)) {
                    $onDate = true;
                    break;
                }
            }
        }

        if ($onDate) {
            while ($this->getExceptions()->next()) {
                if ($this->getExceptions()->current()->contains($dateTime)) {
                    $onDate = false;
                    break;
                }
            }
        }

        return $onDate;
    }
}