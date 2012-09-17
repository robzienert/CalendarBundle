<?php

namespace Rizza\CalendarBundle\Document;

use Rizza\CalendarBundle\Model\UserManager as BaseUserManager;
use Doctrine\ODM\MongoDB\DocumentManager;

class UserManager extends BaseUserManager
{

    protected $em;
    protected $repo;
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
