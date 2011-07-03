<?php

namespace Rizza\CalendarBundle\Tests\DateProcessor;

use Rizza\CalendarBundle\DateProcessor\DayOfTheMonth;

class DayOfTheMonthTest extends \PHPUnit_Framework_TestCase
{
    public function testSetDay()
    {
        $dotm = new DayOfTheMonth(20);

        $this->assertEquals(20, $dotm->getDay());

        $dotm->setDay(21);

        $this->assertEquals(21, $dotm->getDay());
    }

    /**
     * @dataProvider provider
     */
    public function testContains($date, $day, $assert)
    {
        $dotm = new DayOfTheMonth($day);

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);

        if ($assert) {
            $this->assertTrue($dotm->contains($date));
        } else {
            $this->assertFalse($dotm->contains($date));
        }
    }

    public function testGetNextOccurrence()
    {
        $this->markTestIncomplete('DayOfTheMonth::getNextOccurrence() has not been implemented');
    }

    public function provider()
    {
        // date (Y-m-d H:i:s), check day, valid?
        return array(
            array('2011-04-03 15:02:00', 3, true),
            array('2011-07-03 15:02:00', 7, false),
            array('1986-11-21 06:32:00', 21, true),
            array('1986-12-22 12:32:00', 21, false)
        );
    }
}