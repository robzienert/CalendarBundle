<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

class Attendee implements AttendeeInterface
{

    protected $id;
    protected $createdAt;
    protected $updatedAt;
    protected $user;
    protected $event;
    protected $status;

    public function getId()
    {
        return $this->id;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setEvent(EventInterface $event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

}