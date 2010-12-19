<?php

namespace Bundle\CalendarBundle\Tests\Temporal\Expression;

use Bundle\CalendarBundle\Temporal\Expression\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public static function expressionProvider()
    {
        return array(
            // $expression, $expressionClass, $expressionValue
            array('DOTM(3)', 'DayOfTheMonth', 3),
            array('DOTW(3)', 'DayOfTheWeek', 3),
            array('DOTY(45)', 'DayOfTheYear', 45),
            array('MOTY(11)', 'MonthOfTheYear', 11),
        );
    }

    public static function relationshipProvider()
    {
        return array(
            // $relationship, $expression1Class, $expression2Class, $expression1Value, $expression2Value
            array('[DOTM(1)]I[DOTM(3)]', 'DayOfTheMonth', 'DayOfTheMonth', 1, 3),
        );
    }

    /**
     * @dataProvider expressionProvider
     */
    public function testCreateExpression($expression, $expressionClass, $expressionValue)
    {

    }
}