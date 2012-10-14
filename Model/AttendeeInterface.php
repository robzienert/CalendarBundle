<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface AttendeeInterface
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
     * The accept status code
     *
     * @var integer
     */
    const STATUS_ACCEPT = 2;

    /**
     * The decline status code
     *
     * @var integer
     */
    const STATUS_DECLINE = -1;

    /**
     * Returns the id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set the createdAt datetime
     *
     * @param \DateTime $createdAt The created at datetime
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Returns the created at datetime
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set the updatedAt datetime
     *
     * @param \DateTime $updatedAt The updated at datetime
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Returns the updated at datetime
     *
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * Set the user
     *
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user);

    /**
     * Returns the user
     *
     * @return UserInterface
     */
    public function getUser();

    /**
     * Set the event
     *
     * @param EventInterface $event
     */
    public function setEvent(EventInterface $event);

    /**
     * Returns the event
     *
     * @return EventInterface
     */
    public function getEvent();

    /**
     * Set the status
     *
     * @param integer $status
     */
    public function setStatus($status);

    /**
     * Returns the status
     *
     * @return integer
     */
    public function getStatus();
}