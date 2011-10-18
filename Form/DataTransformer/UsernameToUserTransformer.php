<?php

namespace Rizza\CalendarBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Rizza\CalendarBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class UsernameToUserTransformer implements DataTransformerInterface
{

    protected $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function transform($value)
    {
        if (null === $value) {
            return null;
        }
        if (!$value instanceof UserInterface) {
            throw new UnexpectedTypeException($value, 'Symfony\Component\Security\Core\User\UserInterface');
        }

        return $value->getUsername();
    }

    /**
     * @return UserInterface
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return null;
        }
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        return $this->userManager->findUserByUsername($value);
    }

}
