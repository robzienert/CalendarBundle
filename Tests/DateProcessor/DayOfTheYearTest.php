<?php

namespace Rizza\CalendarBundle\Tests\DateProcessor;

use Rizza\CalendarBundle\DateProcessor\DayOfTheYear;

class DayOfTheYearTest extends \PHPUnit_Framework_TestCase
{
    public function testSetDay()
    {
        $doty = new DayOfTheYear(100);

        $this->assertEquals(100, $doty->getDay());

        $doty->setDay(50);

        $this->assertEquals(50, $doty->getDay());
    }

    /**
     * @dataProvider containsProvider
     */
    public function testContains($date, $day, $valid)
    {
        $doty = new DayOfTheYear($day);

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);

        if ($valid) {
            $this->assertTrue($doty->contains($date));
        } else {
            $this->assertFalse($doty->contains($date));
        }
    }

    public function testGetNextOccurrence()
    {
        $this->markTestIncomplete('Test has not been implemented');
    }

    public function containsProvider()
    {
        // date (Y-m-d H:i:s), day, valid?
        return array(
            array('2011-04-03 15:02:00', 93, true),
            array('2011-07-03 15:02:00', 184, true),
            array('2011-07-03 15:02:00', 14, false),
            array('1986-11-21 06:32:00', 325, true),
            array('1986-11-21 06:32:00', 100, false),
            array('1986-12-22 12:32:00', 356, true),
            array('1986-12-22 12:32:00', -356, false),
        );
    }
}