<?php

namespace Rizza\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * An object that implements this interface can organize new events.
 */
interface Organizer extends UserInterface
{
}