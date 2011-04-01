<?php

namespace Rizza\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Rizza\CalendarBundle\Model\EventInterface;

abstract class Calendar implements CalendarInterface
{
    protected $id;

    /**
     * @validation:MaxLength(255)
     * @validation:NotBlank()
     */
    protected $name;

    protected $events;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEvents()
    {
        return $this->events ?: $this->events = new ArrayCollection();
    }

    public function addEvent(EventInterface $event)
    {
        if (!$this->getEvents()->contains($event)) {
            $this->getEvents()->add($event);
        }
    }

    public function removeEvent(EventInterface $event)
    {
        if ($this->getEvents()->contains($event)) {
            $this->getEvents()->remove($event);
        }
    }

    public function __toString()
    {
        return $this->getName();
    }
}