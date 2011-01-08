<?php

namespace Bundle\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Calendar
{
    protected $id;

    protected $title;

    protected $events;

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

    public function getEvents()
    {
        return $this->events ?: $this->events = new ArrayCollection();
    }

    public function addEvent(Event $event)
    {
        if (!$this->getEvents()->contains($event)) {
            $this->getEvents()->add($event);
        }
    }

    public function removeEvent(Event $event)
    {
        if ($this->getEvents()->contains($event)) {
            $this->getEvents()->remove($event);
        }
    }
}