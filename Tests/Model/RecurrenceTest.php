<?php

namespace Rizza\CalendarBundle\Tests\Model;

class RecurrenceTest extends \PHPUnit_Framework_TestCase
{
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