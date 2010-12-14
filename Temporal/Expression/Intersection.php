<?php

namespace Bundle\CalendarBundle\Expression\Expression;

use Bundle\CalendarBundle\Expression\Expression;

class Intersection implements Expression
{
    private $firstExpression;

    private $secondExpression;

    public function __construct(Expression $firstExpression, Expression $secondExpression)
    {
        $this->firstExpression = $firstExpression;
        $this->secondExpression = $secondExpression;
    }

    public function contains(\DateTime $dateTime)
    {
        return $this->firstExpression->contains($dateTime) && $this->secondExpression->contains($dateTime);
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        $firstNextOccurrence = $this->firstExpression->getNextOccurrence($dateTime);
        $secondNextOccurrence = $this->secondExpression->getNextOccurrence($dateTime);

        if ($this->contains($firstNextOccurrence) && $this->contains($secondNextOccurrence)) {
            return ($firstNextOccurrence > $secondNextOccurrence) ? $secondNextOccurrence : $firstNextOccurrence;
        } else if ($this->contains($firstNextOccurrence) && !$this->contains($secondNextOccurrence)) {
            return $firstNextOccurrence;
        } else if (!$this->contains($firstNextOccurrence) && $this->contains($secondNextOccurrence)) {
            return $secondNextOccurrence;
        } else {
            return $this->getNextOccurrence(
                ($firstNextOccurrence < $secondNextOccurrence) ? $firstNextOccurrence : $secondNextOccurrence);
        }
    }

    public function __toString()
    {
        return sprintf('[%s]I[%s]', $this->firstExpression, $this->secondExpression);
    }
}