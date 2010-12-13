<?php

namespace Bundle\CalendarBundle\TemporalExpression\Expression;

use Bundle\CalendarBundle\TemporalExpression\TemporalExpression;

class Difference implements TemporalExpression
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
        return $this->firstExpression->contains($dateTime) && !$this->secondExpression->contains($dateTime);
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        $firstNextOccurrnece = $this->firstExpression->getNextOccurrence($dateTime);
        if (!$this->contains($firstNextOccurrnece))
            $firstNextOccurrnece = $this->getNextOccurrence ($firstNextOccurrnece);
        
        return $firstNextOccurrnece;
    }

    public function __toString()
    {
        return sprintf('[%s]D[%s]', $this->firstExpression, $this->secondExpression);
    }
}