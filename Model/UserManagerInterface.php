<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserManagerInterface
{
    /**
     * Returns the class
     *
     * @return string
     */
    public function getClass();

    /**
     * Find a user
     *
     * @param integer $id The id of the user
     *
     * @return UserInterface
     */
    public function find($id);

    /**
     * Find all users
     *
     * @return array
     */
    public function findAll();

    /**
     * Find a user by $username
     *
     * @param string $username The username
     *
     * @return UserInterface
     */
    public function findUserByUsername($username);
}