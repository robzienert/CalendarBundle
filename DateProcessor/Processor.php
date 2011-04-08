<?php

namespace Rizza\CalendarBundle\DateProcessor;

interface Processor
{
    /**
     * Checks whether or not a provided DateTime object matches with the rules
     * of the specific Processor.
     *
     * @param DateTime $dateTime
     * @return bool
     */
    public function contains(\DateTime $dateTime);

    /**
     * Returns the next occurrence after the provided DateTime object using the
     * specific Processor's rules.
     *
     * @param DateTime $dateTime
     * @return DateTime
     */
    public function getNextOccurrence(\DateTime $dateTime);
}