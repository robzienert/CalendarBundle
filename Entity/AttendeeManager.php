<?php

namespace Rizza\CalendarBundle\Entity;

use Rizza\CalendarBundle\Model\AttendeeManager as BaseAttendeeManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Rizza\CalendarBundle\Model\AttendeeInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AttendeeManager extends BaseAttendeeManager
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

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function addAttendee(AttendeeInterface $attendee)
    {
        $attendee->setCreatedAt(new \DateTime());
        $attendee->setUpdatedAt(new \DateTime());

        $this->em->persist($attendee);
        $this->em->flush();

        return true;
    }

    public function updateAttendee(AttendeeInterface $attendee)
    {
        $attendee->setUpdatedAt(new \DateTime());

        $this->em->persist($attendee);
        $this->em->flush();

        return true;
    }

    public function removeAttendee(AttendeeInterface $attendee)
    {
        $this->em->remove($attendee);
        $this->em->flush();

        return true;
    }

    public function isAdmin($user, AttendeeInterface $attendee)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        return $user->equals($attendee->getUser()) || $user->equals($attendee->getEvent()->getOrganizer());
    }

    public function getClass()
    {
        return $this->class;
    }

}
