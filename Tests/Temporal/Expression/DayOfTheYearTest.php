<?php

namespace Bundle\CalendarBundle\Tests\Temporal\Expression;

use Bundle\CalendarBundle\Temporal\Expression\DayOfTheYear;

class DayOfTheYearTest extends \PHPUnit_Framework_TestCase
{
    public function testDay()
    {
        $doty = new DayOfTheYear(1);

        $this->assertEquals(1, $doty->getDay());
        $doty->setDay(45);
    }
}