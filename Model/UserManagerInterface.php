<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserManagerInterface
{

    public function getClass();

    /**
     * @return UserInterface
     */
    public function find($id);

    public function findAll();

    /**
     * @return UserInterface
     */
    public function findUserByUsername($username);

}
