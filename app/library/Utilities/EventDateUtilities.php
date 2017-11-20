<?php

abstract class EventDateUtilities
{

    static $dayOfWeekOrder = ['sun','mon','tue','wed','thu','fri','sat'];

    public function __construct() {

    }
    static public function getDayOrLastDayOfMonth($date,$dayOfMonth) {
        $month = $date->format('m');
        $year = $date->format('Y');
        $lastDayOfMonth = $date->endOfMonth()->format('d');

        if($dayOfMonth > $lastDayOfMonth) { $dayOfMonth = $lastDayOfMonth; }
        return \Carbon\Carbon::create($year,$month,$dayOfMonth,12,0,0);

    }

    /*
 * Starting with a date in the format MM/DD/YYYY, calculate the start time and end time of the
 *   date based on the start time and duration of the initial event.
 */
    static public function calculateDateTimesOfDate($referenceDateTime,$duration,$startDate) {
        $targetStartDateTime = EventDateUtilities::getDateTimeOfADateBasedOnStartDateTimeOfInitialDate(
            new \Carbon\Carbon($referenceDateTime),
            new \Carbon\Carbon($startDate)
        );
        $targetEndDateTime = EventDateUtilities::getEndDateTimeOfADateBasedOnStartDateTimeAndDuration(
            $targetStartDateTime->copy(),
            $duration
        );

        return array(
            $targetStartDateTime,
            $targetEndDateTime
        );
    }

    /*
     * Given the start date/time of an event, get the end/date time of the event given the duration
     *  in minutes of the event
     */
    static public function getEndDateTimeOfADateBasedOnStartDateTimeAndDuration($startDateTime,$durationInMinutes) {
        return $startDateTime->addMinutes($durationInMinutes);
    }

    /*
     * Given the start date/time of the initial event, this method transfers the time portion
     *  to the target date (which is in the format MM/DD/YYYY) to make it MM/DD/YY HH:MM A.
     */
    static public function getDateTimeOfADateBasedOnStartDateTimeOfInitialDate($startDateTime,$targetDate) {

        // Get the number of minutes from the beginning of the day to the start time of the event.
        $minutesFromBeginningOfDay = $startDateTime->copy()->startOfDay()->diffInMinutes($startDateTime);

        // Make sure the target date is at the beginning of the day
        $targetStartDate = $targetDate->startOfDay();

        // add the minutes from the beginning of the day to the start of the day for the target date.
        return $targetStartDate->addMinutes($minutesFromBeginningOfDay);
    }
    static public function ConvertDaysOfWeekToBinaryString($dows) {
        $order = self::$dayOfWeekOrder;
        $string = '';
        for($i=0; $i<count($order); $i++) {
            if($dows[$order[$i]] === 'true') {
                $string .= "1";
            }
            else {
                $string .= "0";
            }
        }
        return $string;
    }
    static public function ConvertDaysOfWeekToNumericArray($dows) {
        $order = self::$dayOfWeekOrder;
        $arr = array();
        for($i=0; $i<count($order); $i++) {
            if($dows[$order[$i]] === 'true') {
                $arr[] = $i;
            }
        }
        return $arr;
    }
    static public function ConvertDayOfWeekStringToNumber($str) {
        $order = self::$dayOfWeekOrder;
        for($i=0; $i<count($order); $i++) {
            if($order[$i] == $str) { return $i; }
        }
        return false;
    }
    static public function ConvertBinaryDaysOfWeekToObject($string) {
        $bins = str_split($string);
        $order = self::$dayOfWeekOrder;
        $obj = array();
        for($i=0; $i<count($order); $i++) {
                $obj[$order[$i]] = $bins[$i] == 1 ? 'true' : 'false';

        }
        return $obj;
    }

    static public function getAllOccurrencesOfDayOfWeekForMonth($date,$dayOfWeek) {
        $dateIterator= EventDateUtilities::getFirstOccurrenceOfDayOfWeekForMonth($date,self::ConvertDayOfWeekStringToNumber($dayOfWeek));
        $month = $dateIterator->format('m');
        $dates = array();
        while($dateIterator->format('m') === $month) {
            $dates[] = $dateIterator->format('m/d/Y');
            $dateIterator->addWeek(1);
        }
        return $dates;
    }

    static public function getFirstOccurrenceOfDayOfWeekForMonth($date,$dayOfWeek) {

        $startOfMonth = $date->copy()->startOfMonth();
        $startOfMonthDayOfWeek = $startOfMonth->format('w');
        $difference = $startOfMonthDayOfWeek - $dayOfWeek;
        if($difference == 0)
        {
            return $startOfMonth;
        }
        if($difference > 0)
        {
            return $startOfMonth->addDays(7 - $difference);
        }
        else if($difference < 0)
        {
            return $startOfMonth->addDays(-1*$difference);
        }
    }

    static public function orderDatesArray($dates, $order = 'asc')
    {
        // Will sort the array based on dates.  Will fall back to ascending if
        //  user does not give order correctly.
        if($order === 'desc')
        {
            usort($dates, function ($a, $b)
            {
                $d1 = new \Carbon\Carbon($a);
                $d2 = new \Carbon\Carbon($b);
                if ($d1->eq($d2))
                {
                    return 0;
                }
                return $d2->lt($d1) ? -1 : 1;
            });
        }
        else if($order == 'asc')
        {
            usort($dates, function ($a, $b)
            {
                $d1 = new \Carbon\Carbon($a);
                $d2 = new \Carbon\Carbon($b);
                if ($d1->eq($d2))
                {
                    return 0;
                }
                return $d1->lt($d2) ? -1 : 1;
            });
        }
        else {
            throw new Exception('Biz Exception: Do not recognize sort order given');
        }
        return $dates;
    }

    static public function pruneDatesBeforeBeginDate($dates,$beginDate)
    {
        // For this to work (with the break), the dates must be in ascending order.
        $dates = EventDateUtilities::orderDatesArray($dates,'asc');

        for($i=0; $i<count($dates); $i++)
        {
            $checkDate = new \Carbon\Carbon($dates[$i]);


            if($beginDate->startOfDay()->lte( $checkDate->startOfDay() ))
            {
                break;
            }
            else
            {
                unset($dates[$i]);
            }
        }

        return array_values($dates);
    }

    static public function putInDateObject($date) {
        if(is_string($date)) {
            $return_date = new \Carbon\Carbon($date);
        }
        else {
            $return_date = $date->copy();
        }
        if(!$return_date) {
            throw new Exception('date given [' . $date . '] is not valid');
        }
        return $return_date;
    }

    static public function pruneEndDates($dates,$endType,$endValue)
    {
        // For this to work (with the break), the dates must be in ascending order
        $dates = EventDateUtilities::orderDatesArray($dates,'asc');

        // Start from the end and remove anything that is either
        //   1.) greater than the number of occurrences
        //   2.) greater than the end date
        for($i=count($dates)-1; $i>=0; $i--)
        {
            if(
                ($endType === 'occurrences' && count($dates) > $endValue) ||
                ($endType === 'date' && $endValue->endOfDay()->lte(new \Carbon\Carbon($dates[$i])))
            )
            {
                unset($dates[$i]);
            }
            else
            {
                break;
            }

        }
        // Re-index the array and return it.
        return array_values($dates);
    }


    static public function getDatesForTheseDaysOfWeekBegining($beginDate,$daysOfWeek,$dateFormat) {
        $dates = array();
        $dateIterator = new \Carbon\Carbon($beginDate);
        for($i=0; $i<count($daysOfWeek); $i++) {
            // days of week are offsets from 0.  Since the actual date is being updated each time,
            // we only want to update by the difference.
            $dates[] = $dateIterator
                ->addDays($i == 0 ? $daysOfWeek[$i] : $daysOfWeek[$i] - $daysOfWeek[$i-1])
                ->format($dateFormat);
        }

        return $dates;
    }

    static public function getWeekBeginDateOfDate($date)
    {
        // Given a date, this will return the begin date (Sunday)
        //  of the week that the date resides in.

        $dayOfWeek = $date->format('w');
        return $date->subDays($dayOfWeek);
    }



}