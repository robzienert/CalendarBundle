<?php

namespace Rizza\CalendarBundle\Entity;

use Doctrine\ORM\EntityManager;
use Rizza\CalendarBundle\Model\EventManagerInterface;
use Rizza\CalendarBundle\Model\EventInterface;

class EventManager implements EventManagerInterface
{
    protected $em;
    protected $class;
    protected $repository;

    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->name;
    }

    public function createEvent($title)
    {
        $class = $this->getClass();

        return new $class($title);
    }

    public function updateEvent(EventInterface $event, $andFlush = true)
    {
        $this->em->persist($event);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    public function deleteEvent(EventInterface $event)
    {
        $this->em->remove($event);
        $this->em->flush();
    }

    public function findEvents()
    {
        return $this->repository->findAll();
    }

    public function findEventBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function getClass()
    {
        return $this->class;
    }
}