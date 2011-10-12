<?php

namespace Rizza\CalendarBundle\Entity;

use Rizza\CalendarBundle\Model\CalendarManager as BaseCalendarManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Rizza\CalendarBundle\Model\CalendarInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CalendarManager extends BaseCalendarManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repo;

    /**
     * @var string
     */
    protected $class;

    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repo = $em->getRepository($class);
        $this->class = $class;
    }

    public function addCalendar(CalendarInterface $calendar)
    {
        $this->em->persist($calendar);
        $this->em->flush();

        return true;
    }

    public function updateCalendar(CalendarInterface $calendar)
    {
        $this->em->persist($calendar);
        $this->em->flush();

        return true;
    }

    public function removeCalendar(CalendarInterface $calendar)
    {
        $this->em->remove($calendar);
        $this->em->flush();

        return true;
    }

    public function find($id)
    {
        $calendar = $this->repo->find($id);
        if (null === $calendar) {
            throw new NotFoundHttpException();
        }

        return $calendar;
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    public function getClass()
    {
        return $this->class;
    }

}
