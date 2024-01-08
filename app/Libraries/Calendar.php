<?php

namespace App\Libraries;

class Calendar
{
    private $month;
    private $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function generateCalendar()
    {
        $calendarHTML = '<table class="table table-bordered">';
        $calendarHTML .= <<<EOD
            <thead>
                <tr>
                    <th scope="col" class="col-1">Pon</th>
                    <th scope="col" class="col-1">Wt</th>
                    <th scope="col" class="col-1">Śr</th>
                    <th scope="col" class="col-1">Czw</th>
                    <th scope="col" class="col-1">Pt</th>
                    <th scope="col" class="col-1">Sob</th>
                    <th scope="col" class="col-1">Nd</th>
                </tr>
            </thead>
        EOD;
        $calendarHTML .= '<tbody>';

        // Oblicz poprawny pierwszy dzień miesiąca
        $firstDay = date("N", mktime(0, 0, 0, $this->month, 1, $this->year));

        // Popraw pierwszy dzień, jeśli zaczyna się od poniedziałku (obecnie od 1 do 7)
        $firstDay = ($firstDay == 1) ? 0 : $firstDay - 1;

        $totalDays = date("t", mktime(0, 0, 0, $this->month, 1, $this->year));

        $dayCounter = 0;

        $numRows = ceil(($totalDays + $firstDay) / 7);
        
        for ($i = 0; $i < $numRows; $i++) {
            $calendarHTML .= '<tr>';
    
            // Pętla generująca dni w danym wierszu
            for ($j = 0; $j < 7; $j++) {
                $currentDay = $i * 7 + $j - $firstDay + 1;
    
                if ($dayCounter >= $firstDay && $dayCounter - $firstDay < $totalDays) {
                    $calendarHTML .= '<td>' . ($currentDay > 0 ? $currentDay : '') . '</td>';
                } else {
                    $calendarHTML .= '<td></td>';
                }
    
                $dayCounter++;
            }
    
            $calendarHTML .= '</tr>';
        }

        $calendarHTML .= '</tbody>';
        $calendarHTML .= '</table>';

        return $calendarHTML;
    }

    public function displayMonthYear()
    {
        return date('F Y', mktime(0, 0, 0, $this->month, 1, $this->year));
    }

    public function displayPreviousMonthLink()
    {
        $prevMonth = $this->month - 1;
        $prevYear = $this->year;
        if ($prevMonth == 0) {
            $prevMonth = 12;
            $prevYear--;
        }
        return base_url("calendar?month=$prevMonth&year=$prevYear");
    }

    public function displayNextMonthLink()
    {
        $nextMonth = $this->month + 1;
        $nextYear = $this->year;
        if ($nextMonth == 13) {
            $nextMonth = 1;
            $nextYear++;
        }
        return base_url("calendar?month=$nextMonth&year=$nextYear");
    }
}
