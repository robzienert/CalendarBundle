<?php

namespace Rizza\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class Event implements EventInterface
{
    const STATUS_NONE = 0;
    const STATUS_TENTATIVE = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_CANCELLED = -1;
    
    protected $id;

    protected $category;

    protected $calendar;

    protected $title;

    protected $description;

    protected $allDay;

    protected $startDate;
    
    protected $endDate;

    protected $exceptions;

    protected $status;

    protected $location;

    protected $url;

    protected $recurrences;

    protected $alarms;

    protected $organizer;

    protected $attendees;

    public function __construct($title = null)
    {
        $this->title = $title;
        $this->allDay = false;
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

    public function setStartDate(\DateTime $startDate)
    {
        if ($this->endDate instanceof \DateTime
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

    public function setEndDate(\DateTime $endDate)
    {
        if ($this->startDate instanceof \DateTime 
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
        return $this->exceptions ?: $this->exceptions = new ArrayCollection();
    }

    public function addException(\DateTime $exception)
    {
        if (!$this->getExceptions()->contains($exception)) {
            $this->getExceptions()->add($exception);
        }
    }

    public function removeException(\DateTime $exception)
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
        return $this->recurrences ?: $this->recurrences = new ArrayCollection();
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

    public function setOrganizer(UserInterface $organizer)
    {
        $this->organizer = $organizer;
    }

    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function getAttendees()
    {
        return $this->attendees ?: $this->attendees = new ArrayCollection();
    }

    public function addAttendee(Attendee $attendee)
    {
        if (!$this->getAttendees()->contains($attendee)) {
            $this->getAttendees()->add($attendee);
        }
    }

    public function removeAttendee(Attendee $attendee)
    {
        if ($this->getAttendees()->contains($attendee)) {
            $this->getAttendees()->removeElement($attendee);
        }
    }

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