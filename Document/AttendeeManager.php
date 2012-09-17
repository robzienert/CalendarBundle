<?php

namespace Rizza\CalendarBundle\Document;

use Rizza\CalendarBundle\Model\AttendeeManager as BaseAttendeeManager;
use Rizza\CalendarBundle\Model\AttendeeInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;

class AttendeeManager extends BaseAttendeeManager
{

    /**
     * @var DocumentManager
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

    public function __construct(DocumentManager $em, $class)
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
        $event = $attendee->getEvent();
        $event->addAttendee($attendee);

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
