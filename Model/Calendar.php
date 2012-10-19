<?php

namespace Rizza\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Rizza\CalendarBundle\Model\EventInterface;
use Symfony\Component\Validator\Constraints as validation;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class Calendar implements CalendarInterface
{
    /**
     * The calendar's id
     *
     * @var integer
     */
    protected $id;

    /**
     * The calendar's owner
     *
     * @var UserInterface
     */
    protected $owner;

    /**
     * The calendar's name
     *
     * @var string
     * @validation\MaxLength(255)
     * @validation\NotBlank()
     */
    protected $name;

    /**
     * The calendar's events
     *
     * @var Doctrine\Common\Collections\Collection
     */
    protected $events;

    /**
     * The calendar's visibility
     *
     * @var integer
     */
    protected $visibility;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::setOwner()
     */
    public function setOwner(UserInterface $owner)
    {
        $this->owner = $owner;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::getOwner()
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::setName()
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::getName()
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::getEvents()
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::getEventsOnDay()
     */
    public function getEventsOnDay(\DateTime $dateTime)
    {
        /** @var $event Event */
        $p = function ($event) use ($dateTime) {
            return $event->isOnDate($dateTime);
        };

        return $this->getEvents()->filter($p);
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::addEvent()
     */
    public function addEvent(EventInterface $event)
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::removeEvent()
     */
    public function removeEvent(EventInterface $event)
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
        }
    }

    /**
     * Returns the string representation for this object.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::setVisibility()
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::getVisibility()
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::isPublic()
     */
    public function isPublic()
    {
        return $this->visibility === CalendarInterface::VISIBILITY_PUBLIC;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\CalendarInterface::isPrivate()
     */
    public function isPrivate()
    {
        return $this->visibility === CalendarInterface::VISIBILITY_PRIVATE;
    }
}