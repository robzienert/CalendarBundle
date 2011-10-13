<?php

namespace Rizza\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Rizza\CalendarBundle\Model\EventInterface;

use Symfony\Component\Validator\Constraints as validation;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class Calendar implements CalendarInterface
{
    protected $id;

    protected $owner;

    /**
     * @validation\MaxLength(255)
     * @validation\NotBlank()
     */
    protected $name;

    protected $events;

    protected $visibility;

    public function getId()
    {
        return $this->id;
    }

    public function setOwner(UserInterface $owner)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
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

    public function getEventsOnDay(\DateTime $dateTime)
    {
        /** @var $event Event */
        $p = function ($event) use ($dateTime) {
            return $event->isOnDate($dateTime);
        };

        return $this->getEvents()->filter($p);
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
            $this->getEvents()->removeElement($event);
        }
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function isPublic()
    {
        return $this->visibility === CalendarInterface::VISIBILITY_PUBLIC;
    }

    public function isPrivate()
    {
        return $this->visibility === CalendarInterface::VISIBILITY_PRIVATE;
    }
}