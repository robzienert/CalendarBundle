<?php

namespace Rizza\CalendarBundle\Document;

use Rizza\CalendarBundle\Model\CalendarManager as BaseCalendarManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Rizza\CalendarBundle\Model\CalendarInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Rizza\CalendarBundle\Blamer\CalendarBlamerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CalendarManager extends BaseCalendarManager
{

    /**
     * @var DocumentManager
     */
    protected $em;

    /**
     * @var DocumentRepository
     */
    protected $repo;

    /**
     * @var string
     */
    protected $class;

    public function __construct(DocumentManager $em, $class)
    {
        $this->em = $em;
        $this->repo = $em->getRepository($class);
        $this->class = $class;
    }

    public function addCalendar(CalendarInterface $calendar)
    {
        $this->em->persist($calendar);
        $this->em->flush();
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
            throw new NotFoundHttpException(sprintf("Couldn't find calendar with id '%d'", $id));
        }

        return $calendar;
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    public function findVisible($owner)
    {
        if (!$owner instanceof UserInterface) {
            return array();
        }
        $qb = $this->repo->createQueryBuilder()
          ->field('owner.$id')->equals(new \MongoId($owner->getId()))
          ->field('visibility')->equals(CalendarInterface::VISIBILITY_PUBLIC);

        return $qb->getQuery()->execute();
    }

    public function getClass()
    {
        return $this->class;
    }

    public function isAdmin($user, CalendarInterface $calendar)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        return $user->equals($calendar->getOwner());
    }

}
