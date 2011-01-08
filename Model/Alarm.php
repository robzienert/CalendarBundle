<?php

namespace Bundle\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Alarm
{
    protected $id;

    protected $event;

    protected $recipients;

    protected $description;

    /**
     * The date and time this alarm will trigger.
     *
     * @var DateTime
     */
    protected $triggerAt;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEvent(Event $event)
    {
        $this->event = $event;
    }

    public function getEvent(Event $event)
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