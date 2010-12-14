<?php

namespace Bundle\CalendarBundle\Tests\Temporal\Expression;

use Bundle\CalendarBundle\Temporal\Expression\DayOfTheMonth;

class DayOfTheMonthTest extends \PHPUnit_Framework_TestCase
{
    public function testDay()
    {
        $dotm = new DayOfTheMonth(1);

        $this->assertEquals(1, $dotm->getDay());
        $dotm->setDay(9);

        $this->assertEquals(9, $dotm->getDay());
    }

    public function testIgnoreDay()
    {
        $dotm = new DayOfTheMonth(1);

        $this->assertTrue($dotm->getIgnoreDay());
        $dotm->setIgnoreDay(false);

        $this->assertFalse($dotm->getIgnoreDay());

        unset($dotm);
        $dotm = new DayOfTheMonth(1, false);

        $this->assertFalse($dotm->getIgnoreDay());
    }

    public function testIgnoreDayWitNumberOverZero()
    {
        $dotm = new DayOfTheMonth(1, true);

        $date = new DateTime();
        $date->setDate(2010, 1, 1);

        $this->assertEquals(1, $dotm->contains($date));
    }

    public function testIgnoreDayWithNumberEqualingZero()
    {
        $dotm = new DayOfTheMonth(0, true);

        $date = new DateTime();
        $date->setDate(2010, 1, 1);

        $ths->markTestIncomplete('This test has not been completed yet.');
    }
}