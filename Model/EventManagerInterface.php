<?php

namespace Rizza\CalendarBundle\Model;

interface EventManagerInterface
{
    public function createEvent($title);

    public function updateEvent(EventInterface $event, $andFlush = true);

    public function deleteEvent(EventInterface $event);

    public function findEvents();

    public function findEventBy(array $criteria);

    public function getClass();
}