<?php

namespace Bundle\CalendarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

class CalendarBundle extends BaseBundle
{
    /**
     * Get an object repository.
     *
     * @param DocumentManager|EntityManager $objectManager
     * @param string $objectClass
     * @return DocumentRepository|EntityRepository
     */
    public static function getRepository($objectManager, $objectClass)
    {
        return $objectManager->getRepository($objectClass);
    }
}