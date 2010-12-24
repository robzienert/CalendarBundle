<?php

namespace Bundle\CalendarBundle\Expression;

class Union implements Expression
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
        return $this->firstExpression->contains($dateTime) || $this->secondExpression->contains($dateTime);
    }

    public function getNextOccurrence(\DateTime $dateTime)
    {
        $firstNextOccurrence = $this->firstExpression->getNextOccurrence($dateTime);
        $secondNextOccurrence = $this->secondExpression->getNextOccurrence($dateTime);

        return ($firstNextOccurrence > $secondNextOccurrence) ? $firstNextOccurrence : $secondNextOccurrence;
    }

    public function setFirstExpression(Expression $firstExpression)
    {
        $this->firstExpression = $firstExpression;
    }

    public function getFirstExpression()
    {
        return $this->firstExpression;
    }

    public function setSecondExpression(Expression $secondExpression)
    {
        $this->secondExpression = $secondExpression;
    }

    public function getSecondExpression()
    {
        return $this->secondExpression;
    }

    public function __toString()
    {
        return sprintf('[%s]U[%s]', $this->firstExpression, $this->secondExpression);
    }
}