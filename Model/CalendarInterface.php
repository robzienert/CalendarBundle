<?php

namespace Rizza\CalendarBundle\Model;

interface CalendarInterface
{
    public function getId();

    public function setName($name);

    public function getName();

    public function getEvents();

    public function addEvent(EventInterface $event);

    public function removeEvent(EventInterface $event);
}