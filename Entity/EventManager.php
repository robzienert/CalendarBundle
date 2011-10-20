<?php

namespace Rizza\CalendarBundle\Entity;

use Rizza\CalendarBundle\Model\EventManager as BaseEventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Rizza\CalendarBundle\Model\EventInterface;
use Rizza\CalendarBundle\Blamer\EventBlamerInterface;
use Rizza\CalendarBundle\Model\CalendarInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EventManager extends BaseEventManager
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

    public function addEvent(EventInterface $event)
    {
        $this->em->persist($event);
        $this->em->flush();
    }

    public function updateEvent(EventInterface $event)
    {
        $this->em->persist($event);
        $this->em->flush();

        return true;
    }

    public function removeEvent(EventInterface $event)
    {
        $this->em->remove($event);
        $this->em->flush();

        return true;
    }
    
    public function find($id)
    {
        $event = $this->repo->find($id);
        if (null === $event) {
            throw new NotFoundHttpException(sprintf("Couldn't find event with id '%d'", $id));
        }

        return $event;
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    public function findVisible($organizer)
    {
        if (!$organizer instanceof UserInterface) {
            $organizer = null;
        }
        $qb = $this->repo->createQueryBuilder('e');
        $qb
            ->join('e.calendar', 'c')
            ->andWhere('e.organizer = :organizer')
            ->orWhere('c.visibility = :calendarVisibility')
        ;
        $qb->setParameters(array(
            'organizer' => $organizer,
            'calendarVisibility' => CalendarInterface::VISIBILITY_PUBLIC,
        ));

        return $qb->getQuery()->execute();
    }

    public function getClass()
    {
        return $this->class;
    }

    public function isAdmin($user, EventInterface $event)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        return $user->equals($event->getOrganizer());
    }

}
