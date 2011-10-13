<?php

namespace Rizza\CalendarBundle\Entity;

use Rizza\CalendarBundle\Model\EventManager as BaseEventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Rizza\CalendarBundle\Model\EventInterface;

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

        return true;
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
            throw new NotFoundHttpException();
        }

        return $event;
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
