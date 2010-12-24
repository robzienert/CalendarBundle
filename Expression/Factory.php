<?php

namespace Bundle\CalendarBundle\Expression;

class Factory
{
    public static function createFromString($expression)
    {
        $expressionObject = false;
        
        if (preg_match_all("#([A-Za-z0-9,: \[\]\(\) ]*\])([UID]{1})(\[[A-Za-z0-9,: \[\]\(\) ]*)#", $expression, $matches)) {
            $expressionObject = self::createFromRelationship(
                $matches[1][0],
                $matches[3][0],
                $matches[2][0]);
        } else {
            preg_match_all("#([A-Z]{1,4})?\(([A-Za-z0-9.,:\-/ ]*)?\)#", $expression, $matches);
            if (3 != count($matches)) {
                throw new \InvalidArgumentException("The provided expression `$expression` does not appear to be valid");
            }

            $expressionType = $matches[1][0];
            $expressionParameters = $matches[2][0];

            // @todo Refactor to use Symfony's container.
            $expressionClasses = simplexml_load_file(__DIR__ . '/../../Resources/config/expression.xml');

            foreach ($expressionClasses as $expressionClass) {
                if ((string) $expressionClass['acronym'] == $expressionType) {
                    $className = (string) $expressionClass['class'];
                    switch (count($expressionParameters)) {
                        case 0:
                            $expressionObject = new $className();
                            break;

                        case 1:
                            $expressionObject = new $className($expressionParameters[0]);
                            break;

                        case 2:
                            $expressionObject = new $className(
                                $expressionParameters[0],
                                $expressionParameters[1]);
                            break;

                        case 3:
                            $expressionObject = new $className(
                                $expressionParameters[0],
                                $expressionParameters[1],
                                $expressionParameters[2]);
                            break;

                        default:
                            throw new \Exception('Not yet implemented');
                            break;
                    }
                }
            }

            if (!$expressionObject) {
                throw new \InvalidArgumentException("Provided expression type `$expressionType` is not valid");
            }
        }

        return $expressionObject;
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