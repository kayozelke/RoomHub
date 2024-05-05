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
        // simple check if difference between two days is more than one rent-month (31 * 24 hours)

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

        // loop through added months
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

        // DEBUG ONLY
        // if(!$this->checkStartEndDateArrayContinuity($returnData)){
        //     throw new \Exception('PLEASE DEBUG checkStartEndDateArrayContinuity()');
        // };

        return $returnData;
    }

    // public function checkStartEndDateArrayContinuity($data){
    //     // This function was used for for testing getDividedTimeDates()

    //     if ($data){
    //         if(count($data) == 1){
    //             return true;
    //         }
    //         $previous_end_date = (new DateTime($data[0]['start']))->modify('-1 day')->format('Y-m-d');

    //         foreach($data as $element){
    
    //             // print_r('previous_end_date: '.$previous_end_date.'<br>');
    //             // print_r('element start: '.$element['start'].'<br>');
    //             // print_r('element end: '.$element['end'].'<br>');
                
    //             if ($this->checkIfTwoDaysAreNeighbours($previous_end_date,$element['start'])){
    //                 // print_r("OK <br>");
    //                 $previous_end_date = $element['end'];
    //             } else {
    //                 return false;                    
    //             }
                
    //         }
    //         return true;
    //     } else return false;
    // }

    public function checkIfTwoDaysAreNeighbours($first_date_str, $second_date_str){
        if ((new DateTime($first_date_str))->modify('+1 day')->format('Y-m-d') == $second_date_str){
            return True;
        } else {
            return false;                    
        }
    }


}
