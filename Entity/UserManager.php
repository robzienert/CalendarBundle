<?php

namespace Rizza\CalendarBundle\Entity;

use Rizza\CalendarBundle\Model\UserManager as BaseUserManager;
use Doctrine\ORM\EntityManager;

class UserManager extends BaseUserManager
{

    protected $em;
    protected $repo;
    protected $class;

    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repo = $em->getRepository($class);
        $this->class = $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    public function findUserByUsername($username)
    {
        return $this->repo->findOneBy(array(
            'username' => $username,
        ));
    }

}
