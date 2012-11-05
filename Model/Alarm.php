<?php

namespace Rizza\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Alarm
{
    /**
     * The Id
     *
     * @var integer
     */
    protected $id;

    /**
     * The alarm's event
     *
     * @var EventInterface
     */
    protected $event;

    /**
     * The alarm's recipients
     *
     * @var Doctrine\Common\Collections\Collection
     */
    protected $recipients;

    /**
     * The date and time this alarm will trigger.
     *
     * @var \DateTime
     */
    protected $triggerAt;

    /**
     * The class construct
     *
     * @param EventInterface $event The event linked to the alarm
     */
    public function __construct(EventInterface $event)
    {
        $this->setEvent($event);
    }

    /**
     * Returns the id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the event
     *
     * @param EventInterface $event The event
     */
    public function setEvent(EventInterface $event)
    {
        $this->event = $event;
    }

    /**
     * Return the alarm's event
     *
     * @return EventInterface
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Returns the alarm's recipients
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRecipients()
    {
        return $this->recipients ?: $this->recipients = new ArrayCollection();
    }

    /**
     * Add a recipient
     *
     * @param Recipient $recipient
     */
    public function addRecipient(Recipient $recipient)
    {
        if (!$this->getRecipients()->contains($recipient)) {
            $this->getRecipients()->add($recipient);
        }
    }

    /**
     * Remove a recipient
     *
     * @param Recipient $recipient
     */
    public function removeRecipient(Recipient $recipient)
    {
        if ($this->getRecipients()->contains($recipient)) {
            $this->getRecipients()->removeElement($recipient);
        }
    }

    /**
     * Set the alarm's trigger date
     *
     * @param \DateTime $dateTime
     */
    public function setTrigger(\DateTime $dateTime)
    {
        $this->triggerAt = $dateTime;
    }

    /**
     * Returns the alarm's trigger date
     *
     * @return \DateTime
     */
    public function getTrigger()
    {
        return $this->triggerAt;
    }
}