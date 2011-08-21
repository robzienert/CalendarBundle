<?php

namespace Rizza\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Alarm
{
    protected $id;

    protected $event;

    protected $recipients;

    /**
     * @var DateTime The date and time this alarm will trigger.
     */
    protected $triggerAt;

    public function __construct(EventInterface $event)
    {
        $this->setEvent($event);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEvent(EventInterface $event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getRecipients()
    {
        return $this->recipients ?: $this->recipients = new ArrayCollection();
    }

    public function addRecipient(Recipient $recipient)
    {
        if (!$this->getRecipients()->contains($recipient)) {
            $this->getRecipients()->add($recipient);
        }
    }

    public function removeRecipient(Recipient $recipient)
    {
        if ($this->getRecipients()->contains($recipient)) {
            $this->getRecipients()->removeElement($recipient);
        }
    }

    public function setTrigger(\DateTime $dateTime)
    {
        $this->triggerAt = $dateTime;
    }

    public function getTrigger()
    {
        return $this->triggerAt;
    }
}