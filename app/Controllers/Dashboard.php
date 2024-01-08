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

            $data['slots_count_total'] = count($slot_model->findAll());

            $reservations_data = $reservation_model->findAllJoinFullDataOrdered();
            $reservations_data = $reservation_model->addColumnReservationStatus($reservations_data);
            
            $data['today_residents_count'] = count($reservation_model->filterFullReservationsDataByFieldValue($reservations_data, 'reservation_status', 1));

            $data['buildings_count'] = count((new BuildingModel())->findAll());
            $data['rooms_count_total'] = count((new RoomModel())->findAll());

            
            $paid_reservations_general = $reservation_model->filterFullReservationsDataByPayment($reservations_data, true);
            $paid_reservations_active = $reservation_model->filterFullReservationsDataByFieldValue($paid_reservations_general, 'reservation_status', 1);

            $data['paid_reservations_active'] = count($paid_reservations_active);

            echo view('dashboard/moderator_dashboard', $data);
            
        } else {
            $reservation_model = new ReservationModel();
            $current_user_reservations = $reservation_model->findAllWhereUserJoinFullDataOrdered(session()->get('id'));
            $current_user_unpaid_reservations_general = $reservation_model->filterFullReservationsDataByPayment($current_user_reservations,false);
            $current_user_unpaid_reservations_to_today = $reservation_model->filterFullReservationsDataByDatesRange($current_user_unpaid_reservations_general, f_end_date:$today);

            $data['unpaid_reservations_count'] = count($current_user_unpaid_reservations_to_today);
            echo view('dashboard/user_dashboard', $data);
        }
        echo view('templates/footer');
    }
}
