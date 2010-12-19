<?php

namespace Bundle\CalendarBundle\Tests\Temporal\Expression;

use Bundle\CalendarBundle\Temporal\Expression\DayOfTheWeek;

class DayOfTheWeekTest extends \PHPUnit_Framework_TestCase
{
    public function testDay()
    {
        $dotw = new DayOfTheWeek(1);

        $this->assertEquals(1, $dotw->getDay());
        $dotw->setDay(3);

        $this->assertEquals(3, $this->getDay());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidDayThrowsInvalidArgumentException()
    {
        $dotw = new DayOfTheWeek(9);
    }
}