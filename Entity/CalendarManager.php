<?php

namespace Rizza\CalendarBundle\Entity;

use Doctrine\ORM\EntityManager;
use Rizza\CalendarBundle\Model\CalendarManagerInterface;
use Rizza\CalendarBundle\Model\CalendarInterface;

class CalendarManager implements CalendarManagerInterface
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

    public function createCalendar($name)
    {
        $class = $this->getClass();

        return new $class($name);
    }

    public function updateCalendar(CalendarInterface $calendar, $andFlush = true)
    {
        $this->em->persist($calendar);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    public function deleteCalendar(CalendarInterface $calendar)
    {
        $this->em->remove($calendar);
        $this->em->flush();
    }

    public function findCalendars()
    {
        return $this->repository->findAll();
    }

    public function findCalendarBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function getClass()
    {
        return $this->class;
    }
}