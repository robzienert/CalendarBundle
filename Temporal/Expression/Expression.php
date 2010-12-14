<?php

namespace Bundle\CalendarBundle\Temporal\Expression;

interface Expression
{
    /**
     * Returns whether or not a DateTime object is valid by this expression.
     *
     * @param \DateTime $dateTime
     * @return bool
     */
    public function contains(\DateTime $dateTime);

    /**
     * Returns the next occurrence of a \DateTime object by this expression,
     * returns false if there are no future occurrences.
     *
     * @param \DateTime $dateTime
     * @return \DateTime|false
     */
    public function getNextOccurrence(\DateTime $dateTime);
}