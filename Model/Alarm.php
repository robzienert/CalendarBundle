<?php

namespace Bundle\CalendarBundle\Model;

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
}