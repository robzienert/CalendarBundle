<?php

namespace Rizza\CalendarBundle\Model;

interface RecurrenceInterface
{
    /**
     * Returns the recurence's id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set the recurrence's $event
     *
     * @param EventInterface $event
     */
    public function setEvent(EventInterface $event);

    /**
     * Returns the recurence's event
     *
     * @return EventInterface
     */
    public function getEvent();

    /**
     * Returns an array of strings representing the days of the week on which this
     * recurrence occurs. Possible integer values are sunday, monday, tuesday,
     * wednesday, thursday, friday and saturday. If you set $days, you must also
     * set $dayFrequency. For example, if $days is 1 and $dayFrequency is 0,
     * then the recurrence is every Monday.
     *
     * @return array
     */
    public function getDays();

    /**
     * Add a day
     *
     * @param string $day The day to add (DAY_SUNDAY, DAY_MONDAY, DAY_TUESDAY, DAY_WEDNESDAY, DAY_THURSDAY, DAY_FRIDAY, DAY_SATURDAY)
     */
    public function addDay($day);

    /**
     * Remove a day
     *
     * @param string $day The day to remove (DAY_SUNDAY, DAY_MONDAY, DAY_TUESDAY, DAY_WEDNESDAY, DAY_THURSDAY, DAY_FRIDAY, DAY_SATURDAY)
     */
    public function removeDay($day);

    /**
     * Returns an array of integers used in combination with $days to specify which week
     * within a month or year this recurrence occurs. For example, if $frequency
     * is monthly, $days is 0 and $dayFrequency contains 2, then the recurrence
     * will occur the second Monday of every month.
     *
     * @return integer
     */
    public function getDayFrequency();

    /**
     * Add a frequency
     *
     * @param integer $frequency The frequency to add (FREQUENCY_DAILY, FREQUENCY_WEEKLY, FREQUENCY_MONTHLY, FREQUENCY_YEARLY)
     */
    public function addDayFrequency($frequency);

    /**
     * Remove a frequency
     *
     * @param integer $frequency The frequency to remove (FREQUENCY_DAILY, FREQUENCY_WEEKLY, FREQUENCY_MONTHLY, FREQUENCY_YEARLY)
     */
    public function removeDayFrequency($frequency);

    /**
     * Returns an array of numbers, with integer values ranging from 1 to 12, that
     * indicate the months within a year that this recurrence occurs.
     *
     * @return array
     */
    public function getMonths();

    /**
     * Add a month to the recurence
     *
     * @param integer $month An integer ranging from 1-12
     */
    public function addMonth($month);

    /**
     * Remove a month from the recurence
     *
     * @param integer $month An integer ranging from 1-12
     */
    public function removeMonth($month);

    /**
     * Returns an array of numbers, with integer values ranging from 1 to 31 or -31 to
     * -1, that indicate the days within a month that this recurrence occurs.
     * Negative values indicate the number of days from the last day of the month.
     *
     * @return array
     */
    public function getMonthDays();

    /**
     * Add a month day ranging from 1 to 31 or -31 to -1.
     *
     * @param integer $day The month day to add
     */
    public function addMonthDay($day);

    /**
     * Remove a month day ranging from 1 to 31 or -31 to -1.
     *
     * @param integer $day The month day to remove
     */
    public function removeMonthDay($day);

    /**
     * Returns an array of numbers, with integer values ranging from 1 to 53 or -53 to -1,
     * that indicate the weeks within a year that this recurrence occurs.
     * Negative values indicate the number of weeks from the last week of the year.
     *
     * @return array
     */
    public function getWeekNumbers();

    /**
     * Add a month number ranging from 1 to 53 or -53 to -1.
     *
     * @param integer $week The week number to add
     */
    public function addWeekNumber($week);

    /**
     * Remove a month number ranging from 1 to 53 or -53 to -1.
     *
     * @param integer $week The week number to remove
     */
    public function removeWeekNumber($week);

    /**
     * Returns an array of numbers, with integer values ranging from 1 to 366 or -366
     * to -1, that indicate the days within a year that this recurrence occurs.
     * Negative values indicate the number of days from the last day of the year.
     *
     * @return array
     */
    public function getYearDays();

    /**
     * Add a year $day ranging from 1 to 366 or -366 to -1
     *
     * @param unknown_type $day The day to add
     */
    public function addYearDay($day);

    /**
     * Remove a year $day ranging from 1 to 366 or -366 to -1
     *
     * @param unknown_type $day The day to remove
     */
    public function removeYearDay($day);

    /**
     * Set the frequency.
     * Possible values are 0 (daily), 1 (weekly), 2 (monthly), or 3 (yearly).
     *
     * @param integer $frequency
     */
    public function setFrequency($frequency);

    /**
     * Returns the recurence's frequency
     *
     * @return integer
     */
    public function getFrequency();

    /**
     * Set the interval
     *
     * @param integer $interval A positive integer indicating how often the specified frequency repeats.
     */
    public function setInterval($interval);

    /**
     * Returns the recurence's interval
     *
     * @return integer
     */
    public function getInterval();

    /**
     * Set the end date of this recurrence.
     *
     * @param \DateTime $until The end date
     */
    public function setUntil(\DateTime $until);

    /**
     * Returns the recurence's end date of this recurrence.
     *
     * @return \DateTime
     */
    public function getUntil();

    /**
     * Set the start day of the week.
     *
     * @param integer $day A string that indicates the start day of the week.
     */
    public function setWeekStartDay($day);

    /**
     * Returns the recurence's start day of the week.
     *
     * @return integer
     */
    public function getWeekStartDay();

    /**
     *Whether a $datetime is contained in the recurence.
     *
     * @param \DateTime $dateTime The datetime to check
     */
    public function contains(\DateTime $dateTime);

    /**
     * Returns the recurence's occurences
     *
     * @return integer
     */
    public function getOccurrences(\DateTime $betweenStart = null, \DateTime $betweenEnd = null);
}
