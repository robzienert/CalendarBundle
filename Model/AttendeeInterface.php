<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface AttendeeInterface
{

    const STATUS_NONE = 0;
    const STATUS_TENTATIVE = 1;
    const STATUS_ACCEPT = 2;
    const STATUS_DECLINE = -1;

    public function getId();

    public function setCreatedAt(\DateTime $createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

    public function setEvent(EventInterface $event);

    /**
     * @return EventInterface
     */
    public function getEvent();

    public function setStatus($status);

    public function getStatus();

}
