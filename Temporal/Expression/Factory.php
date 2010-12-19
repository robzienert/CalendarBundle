<?php

namespace Bundle\CalendarBundle\Temporal\Expression;

class Factory
{
    public static function createFromString($expression)
    {
        if (preg_match_all("([A-Za-z0-9,: \[\]\(\) ]*\])([UID]{1})(\[[A-Za-z0-9,: \[\]\(\) ]*)", $expression, $matches)) {
            $temporalExpression = self::createFromRelationship(
                $matches[0][1],
                $matches[0][0],
                $matches[0][2]);
        } else {
            preg_match_all("([A-Z]{1,4})?\(([A-Za-z0-9.,:\-/ ]*)?\)", $expression, $matches);

            $temporalExpressionType = $matches[0][1];
            $temporalExpressionParameters = $matches[0][2];

            // @todo Check a dependency list of expressions; if it doesn't exist,
            // blow up the world; otherwise instantiate a new instance of the
            // expression and pass in the constructor parameters.
            throw new \Exception('Not implemented');
        }

        return $temporalExpression;
    }

    public static function createFromRelationship($relationship, $expression1, $expression2)
    {
        switch ($relationship) {
            case 'U':
                $temporalExpression = new Union(self::createFromString($expression1), self::createFromString($expression2));
                break;

            case 'I':
                $temporalExpression = new Intersect(self::createFromString($expression1), self::createFromString($expression2));
                break;

            case 'D':
                $temporalExpression = new Difference(self::createFromString($expression1), self::createFromString($expression2));
                break;

            default:
                throw new \InvalidArgumentException("Provided relationship `$relationship` is not valid");
        }

        return $temporalExpression;
    }
}