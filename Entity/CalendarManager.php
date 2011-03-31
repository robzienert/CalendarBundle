<?php

namespace Rizza\CalendarBundle\Entity;

use Doctrine\ORM\EntityManager;
use Rizza\CalendarBundle\Model\CalendarManagerInterface;

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

    public function updateCalendar(Calendar $calendar, $andFlush = true)
    {
        $this->em->persist($calendar);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    public function deleteCalendar(Calendar $calendar)
    {
        $this->em->remove($calendar);
        $this->em->flush();
    }
}