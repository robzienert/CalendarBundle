<?php

namespace Rizza\CalendarBundle\Tests\DateProcessor;

use Rizza\CalendarBundle\DateProcessor\DayOfTheWeek;

class DayOfTheWeekTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetDay()
    {
        $dotw = new DayOfTheWeek(4);

        $this->assertEquals(4, $dotw->getDay());

        $dotw->setDay(3);

        $this->assertEquals(3, $dotw->getDay());

        $dotw->setDay('tuesday');

        $this->assertEquals(2, $dotw->getDay());
    }

    public function testInvalidStringDayThrowsInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $dotw = new DayOfTheWeek();

        $dotw->setDay('foo');
    }

    public function testInvalidNumericDayThrowsRangeException()
    {
        $this->setExpectedException('RangeException');

        $dotw = new DayOfTheWeek();

        $dotw->setDay(10);
    }

    /**
     * @dataProvider dateTimeProvider
     */
    public function testContains($dateTime, $day, $assert)
    {
        $dotw = new DayOfTheWeek();

        $dotw->setDay($day);

        if ($assert) {
            $this->assertTrue($dotw->contains($dateTime));
        } else {
            $this->assertFalse($dotw->contains($dateTime));
        }
    }

    public function dateTimeProvider()
    {
        // date, dotw index, assertion
        return array(
            array(\DateTime::createFromFormat('Y-m-d H:i:s', '2011-10-01 12:00:00'), 6, true),
            array(\DateTime::createFromFormat('Y-m-d H:i:s', '2011-10-02 17:00:00'), 3, false),
            array(\DateTime::createFromFormat('Y-m-d H:i:s', '2011-03-14 20:30:00'), 2, true)
        );
    }
}