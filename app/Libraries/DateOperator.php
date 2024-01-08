<?php

namespace App\Libraries;

use DateTime;

class DateOperator
{


    // function __construct()
    // {
    //     // print "In BaseClass constructor\n";
    // }

    public function addMonthsSafely(string $date_str, int $number_of_months)
    {

        // the safe way to add months is dedicated for PMS project

        // PHP DateTime->modify() is adding months with unwanted overflow at February and 30-days months, for example:

        // 2001.01.31 + 1 month gives us 2001.03.03. We expected 2001.02.28

        // result like above would cause a serious trouble at integrity of PMS

        [$start_year, $start_month, $start_day] = (explode('-', $date_str));

        $first_day_of_start_month = date('Y-m-1', strtotime($date_str));
        // handle substracting
        if ($number_of_months < 0) {
            $operator = '-';
            $number_of_months *= -1;
        } else $operator = '+';

        // adding with modify() when using first day is always safe for use
        $first_day_of_end_month = (new \DateTime($first_day_of_start_month))->modify($operator . ' ' . $number_of_months . ' months')->format('Y-m-d');

        $number_of_days_in_start_month = date('t', strtotime($date_str));
        $number_of_days_in_end_month = date('t', strtotime($first_day_of_end_month));

        // when we are starting at day which is also the last day of this month 
        //  ->  then we always return last day of end month
        if ($number_of_days_in_start_month == $start_day) {
            return date('Y-m-t', strtotime($first_day_of_end_month));
        }

        if ($start_day == '31') {
            // always return last day of this month (February, February at leap years, 30-day months)
            return date('Y-m-t', strtotime($first_day_of_end_month));
        } else if ($start_day == '30') {
            // return proper day if February (leap years and not leap years)
            if ($number_of_days_in_end_month < 30) {
                return date('Y-m-t', strtotime($first_day_of_end_month));
            } else {
                return date('Y-m-' . $start_day, strtotime($first_day_of_end_month));
            }
        } else if ($start_day == '29') {
            // return proper day if February (not leap years)
            if ($number_of_days_in_end_month < 29) {
                return date('Y-m-t', strtotime($first_day_of_end_month));
            } else {
                return date('Y-m-' . $start_day, strtotime($first_day_of_end_month));
            }
        } else {
            return date('Y-m-' . $start_day, strtotime($first_day_of_end_month));
        }
    }

    public function calculateEndDate(string $date_str, int $number_of_months)
    {
        // this function does almost the same thing as addMonthsSafely()
        // we are substracting one day from result, to keep one reservation being less or equal than month

        // if start date would be 2024-07-01 (the first night at dormitory would be 1th/2th July) and reservation is for 1 month
        //  then end date would be 2024-07-31 (the last night would be 31th July/1th August) instead of 2024-08-01 (which would cause the last night to be 1th/2th August )
        $date = (new DateTime($this->addMonthsSafely($date_str, $number_of_months)))->modify('-1 day');
        return $date->format('Y-m-d');
    }

    public function isValidDate($date_str)
    {
        // check if string is a valid date
        list($year, $month, $day) = explode('-', $date_str);
        return checkdate($month, $day, $year);
    }

    public function isDateOrderProper(string $first_date_str, string $second_date_str): bool
    {
        // check if two dates (strings) are properly ordered
        if (strtotime($first_date_str) > strtotime($second_date_str))
            return false;
        else return true;
    }

    public function isDifferenceMoreThanMonth(string $first_date_str, string $second_date_str): bool
    {
        // simple check if difference between two days is more than one month (31 * 24 hours)

        if (strtotime($first_date_str) + 31 * 24 * 3600 > strtotime($second_date_str))
            return false;
        else return true;
    }

    public function isDifferenceMoreThanYear(string $first_date_str, string $second_date_str): bool
    {
        // check if difference between two days is more than 364 or 365 days

        // usefull only for PSM checks

        // 2024-01-01 - 2023-01-01 = 365 days which is equal a full year but returning TRUE because 1st January appeared TWICE
        // 2023-12-31 - 2023-01-01 = 364 days, returning FALSE
        // 2025-01-01 - 2024-01-01 = 366 days which is equal a full year (leap) but returning TRUE because 1st January appeared TWICE
        // 2024-12-31 - 2024-01-01 = 365 days, but it is leap year, so returning FALSE

        $start = new DateTime($first_date_str);
        $end = new DateTime($second_date_str);

        $interval = $start->diff($end);

        if ($interval->y >= 1) {
            return true;
        }

        return false;
    }


    public function getDividedTimeDates(string $start_date_str, string $end_date_str)
    {
        // returns array of unindexed objects
        // these objects are arrays of indexed (by strings) strings of start and end dates
        
        // Function is dividing the time between given days by the number of months.
        // Returns every element's (month-like length) start and end dates.


        $returnData = [];

        // echo 'start: ' . $start_date_str . ' | end: ' . $end_date_str . '<br>';

        $startDateTime = new DateTime($start_date_str);
        $endDateTime = new DateTime($end_date_str);

        $firstDay = date('d', strtotime($start_date_str));
        // print_r('firstDay: ' . $firstDay . '<br>');
        $lastDay = date('d', strtotime($end_date_str));
        // print_r('lastDay: ' . $lastDay . '<br>');

        $interval = $startDateTime->diff($endDateTime);
        // print_r($interval);
        // echo '<br>';

        $monthDifference = $interval->m + $interval->y*12;

        // first month setup
        $nextStartDate = $start_date_str;

        // loop through months
        for ($i = 0; $i <= $monthDifference; $i++) {
            // echo $i . '. <br>';
            $currentMonthData = [];


            $currentStartDate = $nextStartDate;
            $nextStartDate = $this->addMonthsSafely($currentStartDate, 1);
            $currentEndDate = (new DateTime($nextStartDate))->modify('-1 day')->format('Y-m-d');



            // If start offset is more than 28 days, then month-like element will stick its end-date to real-month end date
            //  Next month-like element will start with 1st of real month
            if($firstDay > 28){
                while( date('d', strtotime($currentEndDate)) < date('t', strtotime($currentEndDate)) ){
                    // print_r(" + + + alternative plus 1 day <br>");
                    $currentEndDate = (new DateTime($currentEndDate))->modify('+1 day')->format('Y-m-d');
                    // + 1 day than end date
                    $nextStartDate = (new DateTime($currentEndDate))->modify('+1 day')->format('Y-m-d');
                }
            }

                // * NOT USED ANYMORE
                    // These two loops below help the divider when first-day is more than 28:
                    // - to avoid 32-day elements
                    // - to keep the day of start date of every element as much close to the day number of first beginning date (as much as possible).

                    // Stick to the same end-day as at the final date. Used when previous month had less than 31 days
                    // * Example 
                        // Assume that start date is 2024-01-30 and end date is 2024-04-29 (full 3 elements in our system - it is 3 months with unusual offset of 30th day as start day).
                        // Also let us assume that second while-loop (the one right below this one) is disabled.
                        // When the general start date is 2024-01-30, then first addMonthsSafely($startdate, 1) will return 2024-02-28 (1 day less than full 29-days month).
                        //   2024-01-30 -> 2024-02-28 (30 days total)
                        // Let us use addMonthsSafely() few more times:
                        //   2024-02-29 -> 2024-03-30 (as end-date does NOT returning 28th BUT 30th, because start date(29th) was the last day of previous month) (31 days total) 
                        //   2024-03-31 -> 2024-04-29 (we can see that start date is 31, but our general start date was 30. This behaviour is unwanted. )(30 days total)
                        // Using this loop causes end-date day to stick more to the day of final last month. Let us see how divider will act with substracting enabled:
                        //   2024-01-31 -> 2024-02-28
                        //   2024-02-29 -> 2024-03-29 (end date day is 29th instead of 30th. one day was substracted)
                        //   2024-03-30 -> 2024-04-29 (start date is the same as at the beginning. it is success!)
                        // Substracting is allowed only when:
                        // - start offset reached 29th, 30th or 31th day
                        // - current element's end-date day is > than final end-date day
                        // - final end-date-day is not equal end-date-month last day (???????????????)
                    // *
                    // while(date('d', strtotime($currentEndDate)) > $lastDay && date('d', strtotime($end_date_str)) != date('t', strtotime($end_date_str)) && $firstDay > 28 ){
                    //     print_r(" - - - minus 1 day <br>");
                    //     $currentEndDate = (new DateTime($currentEndDate))->modify('-1 day')->format('Y-m-d');
                    //     // + 1 day than end date
                    //     $nextStartDate = (new DateTime($currentEndDate))->modify('+1 day')->format('Y-m-d');
                    // }
                    
                    // Try to add a few days when it is possible, so we are sticking with end-day as close at it is possible to the day from the final date
                    // * Example 
                    // ????????? not working with new substracter
                        // Assume that start date is 2024-01-31 and end date is 2024-05-30 (full 4 elements in our system - it is 4 months with unusual offset of 31th day as start day)
                        // Also let us assume that the first while-loop (the one above) is enabled.
                        // When the general start date is 2024-01-31, then first addMonthsSafely($startdate, 1) will return 2024-02-28 (1 day less than full 29-days month).
                        // Not using the loop below we would cause the date 2024-02-28 to be the end date of current element and 2024-02-29 to be the the first date of next element.
                        // Right now it might be looking fine but when we look at the next month ...
                        //   2024-01-31 -> 2024-02-28
                        //   2024-02-29 -> 2024-03-30
                        //   2024-03-31 -> 2024-04-29 (... we can see that we are loosing ONE day - it actually should be 30th not 29th)
                        //   2024-04-30 -> 2024-05-30 (31 days total at this element)
                        // Numbers of days in both last dates are equal. Beaware that month nr 4 (April) is 30-day month.
                        // If it happens on 31-day month (January,March,May, etc...) then days count at this element will reach 32 which is unwanted!!! Maximum count should be 31.
                        // 
                        // To fix this small offset we are adding 1 day to current end day when all conditions are matched:
                        // - start offset reached 29th, 30th or 31th day
                        // - current end day is smaller than the number of day from final date
                        // - it is possible to increase number of days at current month
                        // Finally, with the input data like above we have:
                        //   2024-01-31 -> 2024-02-29 (instead of 28th at end date, 30 days total) 
                        //   2024-03-01 -> 2024-03-30 (start date is changed, 30 days total)
                        //   2024-03-31 -> 2024-04-30 (end-date changed again, 31 days total)
                        //   2024-05-01 -> 2024-04-30 (start date is changed, 30 days total)
                    // *

                    // while(date('d', strtotime($currentEndDate)) < $lastDay && date('d', strtotime($currentEndDate)) < date('t', strtotime($currentEndDate)) && $firstDay > 28 ){
                    //     print_r(" + + + plus 1 day <br>");
                    //     $currentEndDate = (new DateTime($currentEndDate))->modify('+1 day')->format('Y-m-d');
                    //     // + 1 day than end date
                    //     $nextStartDate = (new DateTime($currentEndDate))->modify('+1 day')->format('Y-m-d');
                    // }
                // *


            $currentMonthData['start'] = $currentStartDate;

            // Adjust last date if overflow 
            if(strtotime($currentEndDate) > strtotime($end_date_str)) {
                $currentMonthData['end'] = $end_date_str;
                
                // echo ' - currentStartDate: '.$currentStartDate.'<br>';
                // echo ' - currentEndDate: '.$currentEndDate.'<br>';
                array_push($returnData, $currentMonthData);
                break;
            }

            // }

            $currentMonthData['end'] = $currentEndDate;

            // echo ' - currentStartDate: '.$currentMonthData['start'].'<br>';
            // echo ' - currentEndDate: '.$currentMonthData['end'].'<br>';
            // echo ' - nextStartDate: '.$nextStartDate.'<br>';

            array_push($returnData, $currentMonthData);
        }

        // print_r("returnData: ");
        // print_r($returnData);
        // echo '<br>';

        // DEBUG ONLY - TODO
        if(!$this->checkStartEndDateArrayContinuity($returnData)){
            throw new \Exception('PLEASE DEBUG checkStartEndDateArrayContinuity()');
        };

        return $returnData;
    }

    public function checkStartEndDateArrayContinuity($data){
        // This function was used for for testing getDividedTimeDates()

        if ($data){
            if(count($data) == 1){
                return true;
            }
            $previous_end_date = (new DateTime($data[0]['start']))->modify('-1 day')->format('Y-m-d');

            foreach($data as $element){
    
                // print_r('previous_end_date: '.$previous_end_date.'<br>');
                // print_r('element start: '.$element['start'].'<br>');
                // print_r('element end: '.$element['end'].'<br>');
                
                if ($this->checkIfTwoDaysAreNeighbours($previous_end_date,$element['start'])){
                    // print_r("OK <br>");
                    $previous_end_date = $element['end'];
                } else {
                    return false;                    
                }
                
            }
            return true;
        } else return false;
    }

    public function checkIfTwoDaysAreNeighbours($first_date_str, $second_date_str){
        if ((new DateTime($first_date_str))->modify('+1 day')->format('Y-m-d') == $second_date_str){
            return True;
        } else {
            return false;                    
        }
    }


}
