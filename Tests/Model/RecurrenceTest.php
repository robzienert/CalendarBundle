<?php

namespace Rizza\CalendarBundle\Tests\Model;

class RecurrenceTest extends \PHPUnit_Framework_TestCase
{
    public function testAddRemoveDay()
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addDay(1);
        $recurrence->addDay(5);
        $recurrence->addDay(20);
        $recurrence->addDay(20);

        $this->assertEquals(array(1, 5, 20), $recurrence->getDays()->getValues());

        $recurrence->removeDay(13);
        $recurrence->removeDay(5);

        $this->assertEquals(array(1, 20), $recurrence->getDays()->getValues());
    }

    public function testSetGetDayFrequency()
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addDayFrequency(2);
        $recurrence->addDayFrequency(3);

        $this->assertEquals(array(2, 3), $recurrence->getDayFrequency()->getValues());

        $recurrence->removeDayFrequency(3);

        $this->assertEquals(array(2), $recurrence->getDayFrequency()->getValues());
    }

    public function testInvalidDayFrequencyThrowsRangeException()
    {
        $this->setExpectedException('RangeException');

        $recurrence = $this->getRecurrence();
        $recurrence->addDayFrequency(8);
    }

    public function testAddRemoveMonth()
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addMonth(1);
        $recurrence->addMonth(3);
        $recurrence->addMonth(7);
        $recurrence->addMonth(7);

        $this->assertEquals(array(1, 3, 7), $recurrence->getMonths()->getValues());

        $recurrence->removeMonth(1);

        $this->assertEquals(array(3, 7), $recurrence->getMonths()->getValues());
    }

    public function testAddRemoveMonthDay()
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addMonthDay(1);
        $recurrence->addMonthDay(15);
        $recurrence->addMonthDay(30);
        $recurrence->addMonthDay(30);

        $this->assertEquals(array(1, 15, 30), $recurrence->getMonthDays()->getValues());

        $recurrence->removeMonthDay(15);

        $this->assertEquals(array(1, 30), $recurrence->getMonthDays()->getValues());
    }

    public function testAddRemoveWeekNumber()
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addWeekNumber(1);
        $recurrence->addWeekNumber(2);
        $recurrence->addWeekNumber(3);
        $recurrence->addWeekNumber(3);

        $this->assertEquals(array(1, 2, 3), $recurrence->getWeekNumbers()->getValues());

        $recurrence->removeWeekNumber(2);

        $this->assertEquals(array(1, 3), $recurrence->getWeekNumbers()->getValues());
    }

    public function testAddRemoveYearDay()
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addYearDay(2);
        $recurrence->addYearDay(150);
        $recurrence->addYearDay(200);
        $recurrence->addYearDay(200);

        $this->assertEquals(array(2, 150, 200), $recurrence->getYearDays()->getValues());

        $recurrence->removeYearDay(2);

        $this->assertEquals(array(150, 200), $recurrence->getYearDays()->getValues());
    }

    public function testInvalidFrequencyThrowsInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        $recurrence = $this->getRecurrence();
        $recurrence->setFrequency(9000);
    }

    public function testSetGetFrequency()
    {
        $recurrence = $this->getRecurrence();

        $frequency = \Rizza\CalendarBundle\Model\Recurrence::FREQUENCY_DAILY;
        $recurrence->setFrequency($frequency);

        $this->assertEquals($frequency, $recurrence->getFrequency());
    }

    public function testSetGetInterval()
    {
        $recurrence = $this->getRecurrence();
        $recurrence->setInterval(2);

        $this->assertEquals(2, $recurrence->getInterval());

        $recurrence->setInterval(-3);

        $this->assertEquals(3, $recurrence->getInterval());
    }

    public function testSetGetWeekStartDay()
    {
        $recurrence = $this->getRecurrence();
        $recurrence->setWeekStartDay(0);

        $this->assertEquals(0, $recurrence->getWeekStartDay());
    }

    public function testInvalidWeekStartDayThrowsInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->getRecurrence()->setWeekStartDay(8);
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsUsingUntil($dateTime)
    {
        $recurrence = $this->getRecurrence();
        $recurrence->setUntil(\DateTime::createFromFormat('Y-m-d', '2011-11-01'));

        if ($recurrence->getUntil()->format('Y') >= $dateTime->format('Y')) {
            $this->assertTrue($recurrence->contains($dateTime));
        } else {
            $this->assertFalse($recurrence->contains($dateTime));
        }
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsMonths($dateTime)
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addMonth(1);
        $recurrence->addMonth(9);

        if ($dateTime->format('n') == 1 || $dateTime->format('n') == 9) {
            $this->assertTrue($recurrence->contains($dateTime));
        } else {
            $this->assertFalse($recurrence->contains($dateTime));
        }
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsWeekNumbers($dateTime)
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addWeekNumber(1);

        // Simple check: jan 1 is week 1.
        if (1 == $dateTime->format('j') && 1 == $dateTime->format('n')) {
            $this->assertTrue($recurrence->contains($dateTime));
        } else {
            $this->assertFalse($recurrence->contains($dateTime));
        }
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsDays($dateTime)
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addDay(1);
        $recurrence->addDay(14);

        if (1 == $dateTime->format('j') || 14 == $dateTime->format('j')) {
            $this->assertTrue($recurrence->contains($dateTime));
        } else {
            $this->assertFalse($recurrence->contains($dateTime));
        }
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsMonthDays($dateTime)
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addMonthDay(1);
        $recurrence->addMonthDay(14);

        if (1 == $dateTime->format('j') || 14 == $dateTime->format('j')) {
            $this->assertTrue($recurrence->contains($dateTime));
        } else {
            $this->assertFalse($recurrence->contains($dateTime));
        }
    }

    public function testInvalidMonthDayRangeThrowsRangeException()
    {
        $this->setExpectedException('RangeException');
        
        $recurrence = $this->getRecurrence();
        $recurrence->addMonthDay(40);
    }

    /**
     * @dataProvider containsDateProvider
     */
    public function testContainsYearDays($dateTime)
    {
        $recurrence = $this->getRecurrence();
        $recurrence->addYearDay(1);
        $recurrence->addYearDay(274);

        if (0 == $dateTime->format('z') || 273 == $dateTime->format('z')) {
            $this->assertTrue($recurrence->contains($dateTime));
        } else {
            $this->assertFalse($recurrence->contains($dateTime));
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

    protected function getRecurrence()
    {
        return $this->getMockForAbstractClass('Rizza\CalendarBundle\Model\Recurrence');
    }
}