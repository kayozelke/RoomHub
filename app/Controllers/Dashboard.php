<?php

namespace App\Controllers;

use App\Models\BuildingModel;
use App\Models\ReservationModel;
use App\Models\RoomModel;
use App\Models\SlotModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [];
        $today = date('Y-m-d');

        echo view('templates/header');

        if (session()->get('isModerator')) {
            $reservation_model = new ReservationModel();
            $slot_model = new SlotModel();

            // $data['slots_count_total'] = count($slot_model->findAll());
            $data['slots_count_total'] = $slot_model->countAllResults();

            // $reservations_data = $reservation_model->findAllJoinFullDataOrdered();
            // $reservations_data = $reservation_model->addColumnReservationStatus($reservations_data);
            
            // $data['today_residents_count'] = count($reservation_model->filterFullReservationsDataByFieldValue($reservations_data, 'reservation_status', 1));
            $data['today_residents_count'] = $reservation_model->countReservationsQuery(start_date:"<= '".$today."'", end_date:">= '".$today."'");

            // $data['buildings_count'] = count((new BuildingModel())->findAll());
            $data['buildings_count'] = (new BuildingModel())->countAllResults();
            // $data['rooms_count_total'] = count((new RoomModel())->findAll());
            $data['rooms_count_total'] = (new RoomModel())->countAllResults();

            
            // $paid_reservations_general = $reservation_model->filterFullReservationsDataByPayment($reservations_data, true);
            // $paid_reservations_active = $reservation_model->filterFullReservationsDataByFieldValue($paid_reservations_general, 'reservation_status', 1);

            // $data['paid_reservations_active'] = count($paid_reservations_active);
            $data['paid_reservations_active'] = $reservation_model->countReservationsQuery(start_date:"<= '".$today."'", end_date:">= '".$today."'", payment_done:1);

            echo view('dashboard/moderator_dashboard', $data);
            
        } else {
            $reservation_model = new ReservationModel();
            // $current_user_reservations = $reservation_model->findAllWhereUserJoinFullDataOrdered(session()->get('id'));
            // $current_user_unpaid_reservations_general = $reservation_model->filterFullReservationsDataByPayment($current_user_reservations,false);
            // $current_user_unpaid_reservations_to_today = $reservation_model->filterFullReservationsDataByDatesRange($current_user_unpaid_reservations_general, f_end_date:$today);
            // $data['unpaid_reservations_count'] = count($current_user_unpaid_reservations_to_today);
            
            $data['unpaid_reservations_count'] = $reservation_model->countReservationsQuery(user_email:session()->get('email'), start_date:"<= '".$today."'", payment_done:0);
            print_r($data['unpaid_reservations_count']);
            echo view('dashboard/user_dashboard', $data);
        }
        echo view('templates/footer');
    }
}
