<?php

namespace Bundle\CalendarBundle\Expression;

class Difference implements Expression
{
    /**
     * @var Expression
     */
    private $firstExpression;

    /**
     * @var Expression
     */
    private $secondExpression;

    /**
     * Constructor
     *
     * @param Expression $firstExpression
     * @param Expression $secondExpression
     */
    public function __construct(Expression $firstExpression, Expression $secondExpression)
    {
        $this->firstExpression = $firstExpression;
        $this->secondExpression = $secondExpression;
    }

    /**
     * Returns whether or not the provided $dateTime object is contained by this
     * relationship expression.
     *
     * @param DateTime $dateTime
     * @return bool
     */
    public function contains(\DateTime $dateTime)
    {
        return $this->firstExpression->contains($dateTime) && !$this->secondExpression->contains($dateTime);
    }

    /**
     * Returns the next valid date after the provided $dateTime object.
     *
     * @param DateTime $dateTime
     * @return DateTime
     */
    public function getNextOccurrence(\DateTime $dateTime)
    {
        $firstNextOccurrnece = $this->firstExpression->getNextOccurrence($dateTime);
        if (!$this->contains($firstNextOccurrnece))
            $firstNextOccurrnece = $this->getNextOccurrence($firstNextOccurrnece);
        
        return $firstNextOccurrnece;
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

    /**
     * Returns the string representation of the expression.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('[%s]D[%s]', $this->firstExpression, $this->secondExpression);
    }
}