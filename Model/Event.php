<?php

namespace Bundle\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Event
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

    protected $summary;

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

    public function __construct()
    {
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

    public function setExpression($expression)
    {
        $this->expression = $expression;
    }

    public function getExpression()
    {
        return $this->expression;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCalendar($calendar)
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
        $this->startDate = $startDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setEndDate(DateTime $endDate)
    {
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

    public function addException(DateTime $exception)
    {
        if (!$this->getExceptions()->contains($exception)) {
            $this->getExceptions()->add($exception);
        }
    }

    public function removeException(DateTime $exception)
    {
        if ($this->getExceptions()->contains($exception)) {
            $this->getExceptions()->remove($exception);
        }
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
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

    public function addRecurrence(Recurrence $recurrence)
    {
        if (!$this->getRecurrences()->contains($recurrence)) {
            $this->getRecurrences()->add($recurrence);
        }
    }

    public function removeRecurrence(Recurrence $recurrence)
    {
        if ($this->getRecurrences()->contains($recurrence)) {
            $this->getRecurrences()->remove($recurrence);
        }
    }

    public function isOnDate(\DateTime $dateTime)
    {
        $onDate = false;
        if (!$this->startDate->format('Y-m-d') > $dateTime->format('Y-m-d') || $this->endDate->format('Y-m-d') < $dateTime->format('Y-m-d')) {
            while ($this->getRecurrences()->next()) {
                if ($this->getRecurrences()->current()->contains($dateTime)) {
                    $onDate = true;
                    break;
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
        }

        return $onDate;
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
            $this->getAttendees()->remove($attendee);
        }
    }
}