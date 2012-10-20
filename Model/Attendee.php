<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

class Attendee implements AttendeeInterface
{
    /**
     * The id
     *
     * @var integer
     */
    protected $id;

    /**
     * The created at datetime
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * The updated at datetime
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * The attendee user
     *
     * @var UserInterface
     */
    protected $user;

    /**
     * The attendee event
     *
     * @var EventInterface
     */
    protected $event;

    /**
     * The attendee status code
     *
     * @var integer
     */
    protected $status;

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::setCreatedAt()
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::getCreatedAt()
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::setUpdatedAt()
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::getUpdatedAt()
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::setUser()
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::setEvent()
     */
    public function setEvent(EventInterface $event)
    {
        $this->event = $event;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::getEvent()
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::setStatus()
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * (non-PHPdoc)
     * @see \Rizza\CalendarBundle\Model\AttendeeInterface::getStatus()
     */
    public function getStatus()
    {
        return $this->status;
    }
}