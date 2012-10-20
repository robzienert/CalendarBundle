<?php

namespace Rizza\CalendarBundle\Tests\DateProcessor;

use \DateTime;
use Rizza\CalendarBundle\DateProcessor\DayOfTheYear;

class DayOfTheYearTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSupportedDaysOfTheYear
     */
    public function testSetterGetterDay($isSupported, $day)
    {
        if (!$isSupported) {
            $this->setExpectedException("\InvalidArgumentException");
        }

        $doty = new DayOfTheYear($day);
        $this->assertEquals($day, $doty->getDay());
        $this->assertEquals($doty, $doty->setDay($day), "Setter should return self");
    }

    public function getSupportedDaysOfTheYear()
    {
        $day  = 368;
        $days = array();

        // From -366 to -1 or 1 to 366 (Excluding 0)
        while ($day !== -368) {
            $isSupported = false;
            if ($day <= 366 && $day >= -366 && $day !== 0) {
                $isSupported = true;
            }

            $days[] = array($isSupported, $day);
            $day --;
        }

        return $days;
    }

    public function testGetNextOccurrence()
    {
        $this->markTestIncomplete('Test has not been implemented');
    }

    /**
     * @dataProvider getContainsData
     *
     * @param boolean $isValid Whether it is expected to be valid
     * @param string  $date    The date to test
     * @param integer $day     The day to test
     */
    public function testDayOfTheYearContains($isValid, $date, $day)
    {
        $doty = new DayOfTheYear($day);
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);

        $this->assertEquals($isValid, $doty->contains($date));
    }

    public function getContainsData()
    {
        return array(
            // First day of the year
            array(true, '2012-01-01 00:00:00', 1),
            // Last day of the year
            array(true, '2012-12-31 23:59:59', 366),
            // Day not contained
            array(false, '2012-01-02 00:00:00', 1),
        );
    }
}