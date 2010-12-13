<?php

namespace Bundle\CalendarBundle\TemporalExpression\Expression;

use Bundle\CalendarBundle\TemporalExpression\TemporalExpression;

class Union implements TemporalExpression
{
    private $firstExpression;

    private $secondExpression;

    public function __construct(TemporalExpression $firstExpression, TemporalExpression $secondExpression)
    {
        $this->firstExpression = $firstExpression;
        $this->secondExpression = $secondExpression;
    }

    public function contains(\DateTime $dateTime)
    {
        return $this->firstExpression->contains($dateTime) || $this->secondExpression->contains($dateTime);
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        $firstNextOccurrence = $this->firstExpression->getNextOccurrence($dateTime);
        $secondNextOccurrence = $this->secondExpression->getNextOccurrence($dateTime);

        return ($firstNextOccurrence > $secondNextOccurrence) ? $firstNextOccurrence : $secondNextOccurrence;
    }

    public function __toString()
    {
        return sprintf('[%s]U[%s]', $this->firstExpression, $this->secondExpression);
    }
}