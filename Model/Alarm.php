<?php

namespace Rizza\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Alarm
{
    protected $id;

    protected $event;

    protected $recipients;

    protected $description;

    /**
     * @var DateTime The date and time this alarm will trigger.
     */
    protected $triggerAt;

    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEvent(EventInterface $event)
    {
        $this->event = $event;
    }

    public function getEvent(EventInterface $event)
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
            $this->getRecipients()->remove($recipient);
        }
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }
}