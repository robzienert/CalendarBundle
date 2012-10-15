<?php

namespace Rizza\CalendarBundle\Tests\Model;

use Rizza\CalendarBundle\Tests\CalendarTestCase;

class RecurrenceTest extends CalendarTestCase
{
    /**
     * The class to test
     *
     * @var Rizza\CalendarBundle\Model\Recurrence
     */
    private $recurrence;

    public function setUp()
    {
        parent::setUp();

        $this->recurrence = $this->getMockForAbstractClass("Rizza\CalendarBundle\Model\Recurrence");
    }

    public function tearDown()
    {
        $this->recurrence = null;

        parent::tearDown();
    }

    public function testAddRemoveDay()
    {
        $this->recurrence->addDay(1);
        $this->recurrence->addDay(5);
        $this->recurrence->addDay(20);
        $this->recurrence->addDay(20);

        $this->assertEquals(array(1, 5, 20), $this->recurrence->getDays()->getValues());

        $this->recurrence->removeDay(13);
        $this->recurrence->removeDay(5);

        $this->assertEquals(array(1, 20), $this->recurrence->getDays()->getValues());
    }

    public function testSetGetDayFrequency()
    {
        $this->recurrence->addDayFrequency(2);
        $this->recurrence->addDayFrequency(3);

        $this->assertEquals(array(2, 3), $this->recurrence->getDayFrequency()->getValues());

        $this->recurrence->removeDayFrequency(3);

        $this->assertEquals(array(2), $this->recurrence->getDayFrequency()->getValues());
    }

    public function testInvalidDayFrequencyThrowsRangeException()
    {
        $this->setExpectedException('RangeException');

        $this->recurrence->addDayFrequency(8);
    }

    public function testAddRemoveMonth()
    {
        $this->recurrence->addMonth(1);
        $this->recurrence->addMonth(3);
        $this->recurrence->addMonth(7);
        $this->recurrence->addMonth(7);

        $this->assertEquals(array(1, 3, 7), $this->recurrence->getMonths()->getValues());

        $this->recurrence->removeMonth(1);

        $this->assertEquals(array(3, 7), $this->recurrence->getMonths()->getValues());
    }

    public function testAddRemoveMonthDay()
    {
        $this->recurrence->addMonthDay(1);
        $this->recurrence->addMonthDay(15);
        $this->recurrence->addMonthDay(30);
        $this->recurrence->addMonthDay(30);

        $this->assertEquals(array(1, 15, 30), $this->recurrence->getMonthDays()->getValues());

        $this->recurrence->removeMonthDay(15);

        $this->assertEquals(array(1, 30), $this->recurrence->getMonthDays()->getValues());
    }

    public function testAddRemoveWeekNumber()
    {
        $this->recurrence->addWeekNumber(1);
        $this->recurrence->addWeekNumber(2);
        $this->recurrence->addWeekNumber(3);
        $this->recurrence->addWeekNumber(3);

        $this->assertEquals(array(1, 2, 3), $this->recurrence->getWeekNumbers()->getValues());

        $this->recurrence->removeWeekNumber(2);

        $this->assertEquals(array(1, 3), $this->recurrence->getWeekNumbers()->getValues());
    }

    public function testAddRemoveYearDay()
    {
        $this->recurrence->addYearDay(2);
        $this->recurrence->addYearDay(150);
        $this->recurrence->addYearDay(200);
        $this->recurrence->addYearDay(200);

        $this->assertEquals(array(2, 150, 200), $this->recurrence->getYearDays()->getValues());

        $this->recurrence->removeYearDay(2);

        $this->assertEquals(array(150, 200), $this->recurrence->getYearDays()->getValues());
    }

    public function testInvalidFrequencyThrowsInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->recurrence->setFrequency(9000);
    }

    public function testSetGetFrequency()
    {
        $frequency = \Rizza\CalendarBundle\Model\Recurrence::FREQUENCY_DAILY;
        $this->recurrence->setFrequency($frequency);

        $this->assertEquals($frequency, $this->recurrence->getFrequency());
    }

    public function testSetGetInterval()
    {
        $this->recurrence->setInterval(2);

        $this->assertEquals(2, $this->recurrence->getInterval());

        $this->recurrence->setInterval(-3);

        $this->assertEquals(3, $this->recurrence->getInterval());
    }

    public function testSetGetWeekStartDay()
    {
        $this->recurrence->setWeekStartDay(0);

        $this->assertEquals(0, $this->recurrence->getWeekStartDay());
    }

    public function testInvalidWeekStartDayThrowsInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->recurrence->setWeekStartDay(8);
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsUsingUntil($dateTime)
    {
        $this->recurrence->setUntil(\DateTime::createFromFormat('Y-m-d', '2011-11-01'));

        if ($this->recurrence->getUntil()->format('Y') >= $dateTime->format('Y')) {
            $this->assertTrue($this->recurrence->contains($dateTime));
        } else {
            $this->assertFalse($this->recurrence->contains($dateTime));
        }
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsMonths($dateTime)
    {
        $this->recurrence->addMonth(1);
        $this->recurrence->addMonth(9);

        if ($dateTime->format('n') == 1 || $dateTime->format('n') == 9) {
            $this->assertTrue($this->recurrence->contains($dateTime));
        } else {
            $this->assertFalse($this->recurrence->contains($dateTime));
        }
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsWeekNumbers($dateTime)
    {
        $this->recurrence->addWeekNumber(1);

        // Simple check: jan 1 is week 1.
        if (1 == $dateTime->format('j') && 1 == $dateTime->format('n')) {
            $this->assertTrue($this->recurrence->contains($dateTime));
        } else {
            $this->assertFalse($this->recurrence->contains($dateTime));
        }
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsDays($dateTime)
    {
        $this->recurrence->addDay(1);
        $this->recurrence->addDay(14);

        if (1 == $dateTime->format('j') || 14 == $dateTime->format('j')) {
            $this->assertTrue($this->recurrence->contains($dateTime));
        } else {
            $this->assertFalse($this->recurrence->contains($dateTime));
        }
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsMonthDays($dateTime)
    {
        $this->recurrence->addMonthDay(1);
        $this->recurrence->addMonthDay(14);

        if (1 == $dateTime->format('j') || 14 == $dateTime->format('j')) {
            $this->assertTrue($this->recurrence->contains($dateTime));
        } else {
            $this->assertFalse($this->recurrence->contains($dateTime));
        }
    }

    public function testInvalidMonthDayRangeThrowsRangeException()
    {
        $this->setExpectedException('RangeException');

        $this->recurrence->addMonthDay(40);
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsYearDays($dateTime)
    {
        $this->recurrence->addYearDay(1);
        $this->recurrence->addYearDay(274);

        if (0 == $dateTime->format('z') || 273 == $dateTime->format('z')) {
            $this->assertTrue($this->recurrence->contains($dateTime));
        } else {
            $this->assertFalse($this->recurrence->contains($dateTime));
        }
    }

    public function containsDateProvider()
    {
        // date, assertion
        $format = 'Y-m-d';
        return array(
            array(\DateTime::createFromFormat($format, '2011-10-01')),
            array(\DateTime::createFromFormat($format, '2011-10-14')),
            array(\DateTime::createFromFormat($format, '2011-09-10')),
            array(\DateTime::createFromFormat($format, '2010-09-28')),
            array(\DateTime::createFromFormat($format, '2020-01-01')),
            array(\DateTime::createFromFormat($format, '2020-06-30'))
        );
    }
}