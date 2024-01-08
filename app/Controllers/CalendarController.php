<?php

namespace App\Controllers;

use App\Libraries\Calendar;

class CalendarController extends BaseController
{
    public function index()
    {
        $month = $this->request->getGet('month') ?? date('n');
        $year = $this->request->getGet('year') ?? date('Y');

        $calendar = new Calendar($month, $year);
        $data['calendarHTML'] = $calendar->generateCalendar();
        $data['monthYear'] = $calendar->displayMonthYear();
        $data['prevMonthLink'] = $calendar->displayPreviousMonthLink();
        $data['nextMonthLink'] = $calendar->displayNextMonthLink();

        echo view('templates/header');

        print_r(cal_days_in_month(CAL_GREGORIAN, $month, $year));
        echo view('calendar_view', $data);
        echo view('templates/footer');
    }
}
