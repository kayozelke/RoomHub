<?php

namespace App\Controllers;

use App\Libraries\DateOperator;
use App\Models\BuildingModel;
use App\Models\ReservationModel;
use App\Models\RoomModel;
use App\Models\RoomTypeModel;
use App\Models\SlotModel;
use App\Models\UserModel;

class Reservations extends BaseController
{
    public function index()
    {
        if (session()->get('isModerator')) {
            return $this->moderator_home();
        } else {
            return $this->user_home();
        }
    }

    public function moderator_home(){
        $data = [];
        $reservation_model = new ReservationModel();

        $data['data'] = $reservation_model->findAllJoinFullDataOrdered();
        $data['data'] = $reservation_model -> addColumnReservationStatus($data['data']);
        $data['today'] = date('Y-m-d');

        $active_reservations = $reservation_model -> filterFullReservationsDataByFieldValue($data['data'], 'reservation_status', 1);
        $data['active_reservations_count'] = count($active_reservations);

        $active_paid_reservations = $reservation_model -> filterFullReservationsDataByPayment($active_reservations, 1);
        $data['active_paid_reservations_count'] = count($active_paid_reservations);
        $data['active_unpaid_reservations_count'] = $data['active_reservations_count'] - $data['active_paid_reservations_count'];

        $ended_unpaid_reservations = $reservation_model -> filterFullReservationsDataByPayment($reservation_model -> filterFullReservationsDataByFieldValue($data['data'], 'reservation_status', 0), 0);
        $data['ended_unpaid_reservations'] = count($ended_unpaid_reservations);

        $data['active_and_ended_unpaid_reservations'] = $data['active_unpaid_reservations_count'] + $data['ended_unpaid_reservations'];
        

        unset($data['data']);
        // print_r($data);

        echo view('templates/header');
        echo view('reservations/moderator_home', $data);
        echo view('templates/footer');
    }


    public function user_home(){
        $data = [];
        $todays_date = date('Y-m-d');
        $reservation_model = new ReservationModel();
        
        $data['user_reservations'] = (new ReservationModel())->findAllWhereUserJoinFullDataOrdered(session()->get('id'));
        $data['user_reservations'] = $reservation_model -> addColumnReservationStatus($data['user_reservations']);

        // get current reservation (todays)
        $data['current_reservation'] = $reservation_model->filterFullReservationsDataByFieldValue($data['user_reservations'], 'reservation_status', 1);

        if($data['current_reservation'] ){
            $data['current_reservation'] = $data['current_reservation'][0];
        }

        // get unpaid reservations data
        $data['unpaid_reservations'] = $reservation_model->filterFullReservationsDataByPayment($data['user_reservations'], 0);
        $data['unpaid_reservations'] = $reservation_model->filterFullReservationsDataByDatesRange($data['unpaid_reservations'], f_end_date: $todays_date);

        $data['current_query'] = $this->request->getGet();


        if ($this->request->getGet()) {
            foreach ($this->request->getGet() as $item) {
                if ($item) {
                    $data['filter_year_month'] = $this->request->getGet('year_month');
                    break;
                }
            }
        }

        // If month filter is not set, reload with query of current month filter
        if (!isset($data['filter_year_month']) || !$data['filter_year_month']) {
            $run_query = [
                'year_month' => date('Y-m'),
            ];

            $flash_data = session()->getFlashdata();
            if($flash_data){
                session()->setFlashdata($flash_data);
            }

            return redirect()->to('reservations?'.http_build_query($run_query));

        // If filter is set, get edge date values
        } else {
            // Generating string of YYYY-MM from current month
            //  Input for this date() is format timestamp
            //  Firstly we have to generate any moment of month as timestamp. We are using strtotime()
            $data['start_date'] = date('Y-m-01', strtotime($data['filter_year_month'] . '-01'));
            $data['end_date'] = date('Y-m-t', strtotime($data['filter_year_month'] . '-01'));
        }

        // if month is other than current, set filter as enabled:
        if(date('Y-m', strtotime($data['start_date'])) != date('Y-m'))
            $data['isFilterEnabled'] = true;
        
        // filter by dates
        $data['user_reservations'] = $reservation_model->filterFullReservationsDataByDatesRange($data['user_reservations'], $data['start_date'], $data['end_date']);

        echo view('templates/header');
        echo view('reservations/user_home', $data);
        echo view('templates/footer');
    }

    public function monthly(){
        $data = [];
        $data['start_date'] = "";
        $data['end_date'] = "";
        $reservation_model = new ReservationModel();

        $data['data'] = $reservation_model->findAllJoinFullDataOrdered();
        $data['current_query'] = $this->request->getGet();
        
        $data['isFilterEnabled'] = false;
        
        if ($this->request->getGet()) {
            foreach ($this->request->getGet() as $item) {
                if ($item) {
                    $data['filter_year_month'] = $this->request->getGet('year_month');
                    break;
                }
            }
        }

        // If month filter is not set, reload with query of current month filter
        if (!isset($data['filter_year_month']) || !$data['filter_year_month']) {
            $run_query = [
                'year_month' => date('Y-m'),
            ];

            $flash_data = session()->getFlashdata();
            if($flash_data){
                session()->setFlashdata($flash_data);
            }

            return redirect()->to('reservations/monthly?'.http_build_query($run_query));

        // If filter is set, get edge date values
        } else {
            // Generating string of YYYY-MM from current month
            //  Input for this date() is format timestamp
            //  Firstly we have to generate any moment of month as timestamp. We are using strtotime()
            $data['start_date'] = date('Y-m-01', strtotime($data['filter_year_month'] . '-01'));
            $data['end_date'] = date('Y-m-t', strtotime($data['filter_year_month'] . '-01'));
        }

        // if month is other than current, set filter as enabled:
        if(date('Y-m', strtotime($data['start_date'])) != date('Y-m'))
            $data['isFilterEnabled'] = true;

        // * FILTERING
            // filter by dates
            $data['data'] = $reservation_model->filterFullReservationsDataByDatesRange($data['data'], $data['start_date'], $data['end_date']);
            
        // *
        
        // add new column 'status'
        $data['data'] = $reservation_model->addColumnReservationStatus($data['data']);

        echo view('templates/header');
        echo view('reservations/views/monthly', $data);
        echo view('templates/footer');

    }


    public function by_user(){
        $data = [];
        $reservation_model = new ReservationModel();
        $user_model = new UserModel();

        $data['data'] = [];
        $data['users'] = $user_model->findAll();
        $data['current_query'] = $this->request->getGet();
        
        $data['isFilterEnabled'] = false;
        
        if ($this->request->getGet()) {
            // $data['current_user'] = $user_model->findByEmail($this->request->getGet('user_email'));

            // if(!$data['current_user']){
            //     session()->setFlashdata('failure', 'Nie odnaleziono użytkownika \''.$this->request->getGet('user_email').'\'!');
            //     print_r($data);
            //     return redirect()->back();
                
            // }

            if($this->request->getGet('show_deleted')){
                $data['data'] = $reservation_model->filterFullReservationsDataByFieldValue($reservation_model -> findAllWithDeletedJoinFullDataOrdered(), 'user_id', $data['current_user']['id']);
            } else {
                // $data['data'] = $reservation_model -> findAllWhereUserJoinFullDataOrdered($data['current_user']['id']);
                $data['data'] = $reservation_model -> findAllWhereUserEmailJoinFullDataOrdered($this->request->getGet('user_email'));
            }

            if(!$data['data']){
                session()->setFlashdata('failure', 'Użytkownik \''.$this->request->getGet('user_email').'\' nie ma żadnych rezerwacji!');
                return redirect()->back();
            }
        }

        // add new column 'status'
        $data['data'] = $reservation_model->addColumnReservationStatus($data['data']);

        echo view('templates/header');
        echo view('reservations/views/by_user', $data);
        echo view('templates/footer');

    }

    public function by_filter(){
        $data = [];
        $data['current_query'] = $this->request->getGet();
        if(!$data['current_query']){
            return $this->filter_settings();
        } else {
            $reservation_id = null;
            $status = null;
            $user_email = null;
            $building_id = null;
            $room_number = null;
            $start_date = null;
            $end_date = null;
            $payment_done = null;

            if(isset($data['current_query']['reservation_id']))    $reservation_id = $data['current_query']['reservation_id'];
            if(isset($data['current_query']['status']))            $status = $data['current_query']['status'];
            if(isset($data['current_query']['user_email']))        $user_email = $data['current_query']['user_email'];
            if(isset($data['current_query']['building_id']))       $building_id = $data['current_query']['building_id'];
            if(isset($data['current_query']['room_number']))       $room_number = $data['current_query']['room_number'];
            if(isset($data['current_query']['start_date']))        $start_date = $data['current_query']['start_date'];
            if(isset($data['current_query']['end_date']))          $end_date = $data['current_query']['end_date'];
            if(isset($data['current_query']['payment_done']))      $payment_done = $data['current_query']['payment_done'];

            if($start_date == "") $start_date = null;
            if($end_date == "") $end_date = null;
            if($start_date != "" && $end_date != ""){
                if (!(new DateOperator)->isDateOrderProper($start_date, $end_date)) {
                    session()->setFlashdata('form_validation_failure', 'Data końcowa nie może poprzedzać daty początkowej!');
                    return redirect()->to('/reservations/filter_settings?'.http_build_query($data['current_query']));
                } 
            }
        }
        
        $reservation_model = new ReservationModel();

        // if(isset($data['current_query']['show_deleted'])){
        //     $data['data'] = $reservation_model -> findAllWithDeletedJoinFullDataOrdered();
        // } else {
        //     $data['data'] = $reservation_model -> findAllJoinFullDataOrdered();
        // }

        // // add new column 'status' to existing data
        // $data['data'] = $reservation_model->addColumnReservationStatus($data['data']);


        // * FILTERING

            // by id
            // if($reservation_id != null){
            //     $data['data'] = $reservation_model -> filterFullReservationsDataByFieldValue($data['data'], 'reservation_id', $reservation_id);
            // }

            // // by status (ended/active/waiting for start)
            // if($status != null){
            //     $data['data'] = $reservation_model->filterFullReservationsDataByFieldValue($data['data'], 'reservation_status', $status);
            // }
        
            // // by email
            // if($user_email != null){
            //     $data['data'] = $reservation_model -> filterFullReservationsDataByFieldValue($data['data'], 'user_email', $user_email);
            // }

            // if($building_id != null){
            //     $data['data'] = $reservation_model -> filterFullReservationsDataByFieldValue($data['data'], 'building_id', $building_id);
            // }

            // // by room_number (part containing)
            // if($room_number != null){
            //         $data['data'] = $reservation_model -> filterFullReservationsDataByFieldValue($data['data'], 'room_number', $room_number, true);
            // }
            
            // // filter by dates
            // $data['data'] = $reservation_model->filterFullReservationsDataByDatesRange($data['data'], $start_date, $end_date);

            // // filter by payment
            // if($payment_done != null){
            //     $data['data'] = $reservation_model->filterFullReservationsDataByFieldValue($data['data'], 'reservation_payment_done', $payment_done);
            // }

            
        // *
        // echo "my payment done = $payment_done";
        // V2
        if(isset($data['current_query']['show_deleted'])){
            $data['data'] = $reservation_model -> findReservationsQuery($reservation_id, $user_email, $building_id, $room_number, $start_date, $end_date, $payment_done, true);
        } else {
            $data['data'] = $reservation_model -> findReservationsQuery($reservation_id, $user_email, $building_id, $room_number, $start_date, $end_date, $payment_done, false);
        }

        // add new column 'status' to existing data
        $data['data'] = $reservation_model->addColumnReservationStatus($data['data']);
        
        // by status (ended/active/waiting for start)
        if($status != null){
            $data['data'] = $reservation_model->filterFullReservationsDataByFieldValue($data['data'], 'reservation_status', $status);
        }


        echo view('templates/header');
        echo view('reservations/views/by_filter', $data);
        echo view('templates/footer');

    }

    public function filter_settings()
    {
        $data = [];
        $data['current_query'] = $this->request->getGet();
        $data['data'] = (new ReservationModel())->findAllJoinFullDataOrdered();
        $data['buildings'] = (new BuildingModel())->findAllOrdered();
        $data['users'] = (new UserModel())->findAll();

        echo view('templates/header');
        echo view('reservations/filter_settings', $data);
        echo view('templates/footer');
    }

    public function add()
    {
        $data = [];

        $data['buildings'] = (new BuildingModel())->findAllOrdered();
        $data['users'] = (new UserModel())->findAll();


        if ($this->request->getGet()) {
            foreach ($this->request->getGet() as $item) {
                if ($item) {
                    $data['current_building_id'] = $this->request->getGet('building_id');
                    $data['current_room_number'] = $this->request->getGet('room_number');
                    $data['current_slot_id'] = $this->request->getGet('slot_id');
                    $data['current_user_email'] = $this->request->getGet('user_email');
                    break;
                }
            }
        }


        echo view('templates/header');
        echo view("reservations/add/add_welcome", $data);
        echo view('templates/footer');
    }

    public function add_details()
    {
        $data = [];

        $buildings_model = new BuildingModel();
        $room_model = new RoomModel();
        $slot_model = new SlotModel();
        $user_model = new UserModel();
        $reservation_model = new ReservationModel();

        $data['current_query'] = $this->request->getGet();

        // * check if data isset
            if ($data['current_query']) {
                // no key building_id
                if (!array_key_exists('building_id', $data['current_query'])) {
                    session()->setFlashdata('form_validation_failure', 'Niepoprawny obiekt!');
                    return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
                }

                // no key room_number
                if (!array_key_exists('room_number', $data['current_query'])) {
                    session()->setFlashdata('form_validation_failure', 'Niepoprawny pokój!');
                    return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
                } 

                // no key slot_id
                if (!array_key_exists('slot_id', $data['current_query'])) {
                    session()->setFlashdata('form_validation_failure', 'Niepoprawne miejsce w pokoju!');
                    return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
                }

                // no key user_email
                if (!array_key_exists('user_email', $data['current_query'])) {
                    session()->setFlashdata('form_validation_failure', 'Niepoprawny użytkownik!');
                    return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
                }
            } else {
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
            }
        // *

        // * check if data is proper
            // building
                $data['current_building'] = $buildings_model->find($data['current_query']['building_id']);
                // no data
                if (!$data['current_building']) {
                    session()->setFlashdata('form_validation_failure', 'Niepoprawny obiekt!');
                    return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
                }
            // room
                $data['current_room'] = $room_model->findByNumberWhereBuildingId($data['current_query']['room_number'], $data['current_query']['building_id']);
                // no data
                if (!$data['current_room']) {
                    session()->setFlashdata('form_validation_failure', 'Niepoprawny pokój!');
                    return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
                }
            // slot
                $data['current_slot'] = $slot_model->find($data['current_query']['slot_id']);
                // no data
                if (!$data['current_slot']) {
                    session()->setFlashdata('form_validation_failure', 'Niepoprawne miejsce w pokoju!');
                    return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
                }
            // user
                $data['current_user'] = $user_model->findByEmail($data['current_query']['user_email']);
                // no data
                if (!$data['current_user']) {
                    session()->setFlashdata('form_validation_failure', 'Niepoprawny użytkownik!');
                    return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
                }
            // 
        // *


        $data['data'] = $reservation_model->findAllJoinFullDataOrdered();

        // * HANDLE FILTERING OF SIDE VIEW
            if ($this->request->getGet('year_month')) {
                $data['filter_year_month'] = $this->request->getGet('year_month');
            }

            if (!isset($data['filter_year_month']) || !$data['filter_year_month']) {
                $data['start_date'] = date('Y-m-01');
                $data['end_date'] = date('Y-m-t');
                $data['filter_year_month'] = date('Y-m');
            } else {
                $data['start_date'] = date('Y-m-01', strtotime($data['filter_year_month'] . '-01'));
                $data['end_date'] = date('Y-m-t', strtotime($data['filter_year_month'] . '-01'));
            }

            // filter by dates
            $data['data'] = $reservation_model->filterFullReservationsDataByDatesRange($data['data'], $data['start_date'], $data['end_date']);

            // filter by additional data
            $filteredData = [];
            foreach ($data['data'] as $item) {

                // filtering by slot
                if ($data['current_slot']['id'] != $item['slot_id']) {
                    continue;
                }

                array_push($filteredData, $item);
            }
            $data['data'] = $filteredData;
        // *


    
        echo view('templates/header');
        echo view('reservations/add/add_details', $data);
        echo view('templates/footer');
    }

    public function add_pricing($error_msg = null)
    {
        $data = [];
        $data['error_msg'] = $error_msg;
        $data['current_query'] = $this->request->getGet();
        $dateOperator = new DateOperator();

        // * CHECK IF DATA ISSET
            if ($data['current_query']) {
                // if missing data
                if (!array_key_exists('method', $data['current_query']) || !$data['current_query']['method']) {
                    session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                    return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                }
                // if method is set to 'monthly'
                else if ($data['current_query']['method'] == 'monthly') {
    
                    if (!isset($data['current_query']['m_start_date']) || !$data['current_query']['m_start_date']) {
                        session()->setFlashdata('form_validation_failure', 'Wprowadź datę początkową!');
                        return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                    }
                    if (!isset($data['current_query']['m_end_date']) || !$data['current_query']['m_end_date']) {
                        session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                        return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                    }


                    $data['general_start_date'] = $data['current_query']['m_start_date'];
                    $data['general_end_date'] = $data['current_query']['m_end_date'];
                    
                }
                // if method is set to 'daily'
                else {
                    if (!array_key_exists('start_date', $data['current_query']) || !$data['current_query']['start_date']) {
                        // return $this->add_details("Niepoprawna data rozpoczęcia!");
                        session()->setFlashdata('form_validation_failure', 'Niepoprawna data rozpoczęcia!');
                        return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                    }
                    if (!array_key_exists('end_date', $data['current_query']) || !$data['current_query']['end_date']) {
                        // return $this->add_details("Niepoprawna data zakończenia!");
                        session()->setFlashdata('form_validation_failure', 'Niepoprawna data zakończenia!');
                        return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                    }
                    if (!$dateOperator->isDateOrderProper($data['current_query']['start_date'], $data['current_query']['end_date'])) {
                        // return $this->add_details("Data zakończenia nie może poprzedzać daty początkowej!");
                        session()->setFlashdata('form_validation_failure', 'Data zakończenia nie może poprzedzać daty początkowej!');
                        return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                    }
                    
                    $data['general_start_date'] = $data['current_query']['start_date'];
                    $data['general_end_date'] = $data['current_query']['end_date'];
                }
            } else {
                // return $this->add("Niepoprawne dane!");
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('reservations/add?' . http_build_query($data['current_query']));
            }
        // *

        $buildings_model = new BuildingModel();
        $room_model = new RoomModel();
        $slot_model = new SlotModel();
        $user_model = new UserModel();
        $room_type_model = new RoomTypeModel();
        $reservation_model = new ReservationModel();

        // * DATA VALUES CHECK
            // check if dates are valid
            if(!$dateOperator->isValidDate($data['general_start_date'])){
                session()->setFlashdata('form_validation_failure', 'Data rozpoczęcia ('.$data['general_start_date'].') jest niepoprawna!');
                return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
            }
            if(!$dateOperator->isValidDate($data['general_end_date'])){
                session()->setFlashdata('form_validation_failure', 'Data zakończenia ('.$data['general_end_date'].') jest niepoprawna!');
                return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
            }

            // DISABLED | check if dates are not the same
            // if($data['general_start_date'] == $data['general_end_date']){
            //     session()->setFlashdata('form_validation_failure', 'Wybrane daty są takie same!');
            //     return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
            // }

            // check if date order is proper
            if(!$dateOperator->isDateOrderProper($data['general_start_date'],$data['general_end_date'])){
                session()->setFlashdata('form_validation_failure', 'Data zakończenia nie może poprzedzać daty rozpoczęcia!');
                return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
            }
            // * DAILY-ONLY
                // check if date difference is not more than one month
                if($data['current_query']['method'] == "daily" && $dateOperator->isDifferenceMoreThanMonth($data['general_start_date'],$data['general_end_date'])){
                    session()->setFlashdata('form_validation_failure', 'Maksymalna długość krótkookresowej rezerwacji wynosi 31 dni!');
                    return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                } 
            // 
            
            // * MONTHLY-ONLY
                // check if date difference is not more than one year
                if($data['current_query']['method'] == "monthly" && $dateOperator->isDifferenceMoreThanYear($data['general_start_date'],$data['general_end_date'])){
                    session()->setFlashdata('form_validation_failure', 'Maksymalna długość długookresowej rezerwacji wynosi 1 rok!');
                    return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                }
            // 

            // * check if slot is free
                $all_slot_reservations = $reservation_model->findAllWhereSlotJoinFullDataOrdered($data['current_query']['slot_id']);
                $reservations_at_time_range = $reservation_model->filterFullReservationsDataByDatesRange($all_slot_reservations, $data['general_start_date'], $data['general_end_date']);
                if($reservations_at_time_range){
                    session()->setFlashdata('form_validation_failure', 'Miejsce jest już zajęte ('.$reservations_at_time_range[0]['reservation_start_time'].' / '.$reservations_at_time_range[0]['reservation_end_time'].')!');
                    return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                }
            // *

            // * check if user is free
                // get user data
                $data['current_user'] = $user_model->findByEmail($data['current_query']['user_email']);
                // get user reservations
                $all_user_reservations = $reservation_model->findAllWhereUserJoinFullDataOrdered($data['current_user']['id']);
                
                // filter by dates
                $reservations_at_time_range = $reservation_model->filterFullReservationsDataByDatesRange($all_user_reservations, $data['general_start_date'], $data['general_end_date']);
                // check if any reservations there
                if($reservations_at_time_range){
                    session()->setFlashdata('form_validation_failure', 'Wybrany użytkownik ('.$data['current_user']['email'].') wynajmuje w tym czasie ('.$reservations_at_time_range[0]['reservation_start_time'].' / '.$reservations_at_time_range[0]['reservation_end_time'].') inny pokój!');
                    return redirect()->to('reservations/add_details?' . http_build_query($data['current_query']));
                }
            // *
        // *

        $data['current_slot'] = $slot_model->find($data['current_query']['slot_id']);
        $data['current_room'] = $room_model->findByNumberWhereBuildingId($data['current_query']['room_number'], $data['current_query']['building_id']);
        $data['current_room_type'] = $room_type_model->find($data['current_room']['room_type_id']);
        $data['current_building'] = $buildings_model->find($data['current_query']['building_id']);

        echo view('templates/header');
        echo view("reservations/add/add_pricing", $data);
        echo view('templates/footer');
    }


    public function add_final(){
        $reservation_model = new ReservationModel();
        $dateOperator = new DateOperator();
        $data = $this->request->getPost();
        
        $user_data = [];
        $slot_data = [];
        
        // * CHECK INPUT
            if(!isset($data['method']) || !$data['method'] ){
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('/reservations/add');
            }

            if(!isset($data['slot_id']) || !$data['slot_id'] ){
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('/reservations/add');
            } else {
                $slot_data = (new SlotModel())->find($data['slot_id']);
                if(!$slot_data){
                    session()->setFlashdata('form_validation_failure', 'Wybrane miejsce nie istnieje!');
                    return redirect()->to('/reservations/add');
                }
            }
            if(!isset($data['user_email']) || !$data['user_email'] ){
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('/reservations/add');
            } else{
                $user_data = (new UserModel())->findByEmail($data['user_email']);
                if(!$user_data){
                    session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                    return redirect()->to('/reservations/add');
                }
            }
            
            if(!isset($data['general_start_date']) || !$data['general_start_date'] ){
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('/reservations/add');
            }
            if(!isset($data['general_end_date']) || !$data['general_end_date'] ){
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('/reservations/add');
            }
            


            if(!isset($data['price']) || $data['price'] < 0 ){
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('/reservations/add');
            }
            
            if(!isset($data['notes'])){
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('/reservations/add');
            }
        // *

        

        // * DATA VALUES CHECK

            // DISABLED | check if dates are not the same
                // if($data['general_start_date'] == $data['general_end_date']){
                //     session()->setFlashdata('form_validation_failure', 'Wybrane daty są takie same!');
                //     return redirect()->to('/reservations/add');
                // }
            // check if date order is proper
                if(!$dateOperator->isDateOrderProper($data['general_start_date'],$data['general_end_date'])){
                    session()->setFlashdata('form_validation_failure', 'Data zakończenia nie może poprzedzać daty rozpoczęcia!');
                    return redirect()->to('/reservations/add');
                }
            // * DAILY-ONLY
                // check if date difference is not more than one month
                if($data['method'] == "daily" && $dateOperator->isDifferenceMoreThanMonth($data['general_start_date'],$data['general_end_date'])){
                    session()->setFlashdata('form_validation_failure', 'Maksymalna długość krótkookresowej rezerwacji wynosi 31 dni!');
                    return redirect()->to('/reservations/add');
                } 
            // 
            
            // * MONTHLY-ONLY
                // check if date difference is not more than one year
                if($data['method'] == "monthly" && $dateOperator->isDifferenceMoreThanYear($data['general_start_date'],$data['general_end_date'])){
                    session()->setFlashdata('form_validation_failure', 'Maksymalna długość długookresowej rezerwacji wynosi 1 rok!');
                    return redirect()->to('/reservations/add');
                }
            // 

            // check if slot is free
                $all_slot_reservations = $reservation_model->findAllWhereSlotJoinFullDataOrdered($slot_data['id']);
                $reservations_at_time_range = $reservation_model->filterFullReservationsDataByDatesRange($all_slot_reservations, $data['general_start_date'], $data['general_end_date']);
                if($reservations_at_time_range){
                    session()->setFlashdata('form_validation_failure', 'Miejsce jest już zajęte ('.$reservations_at_time_range[0]['reservation_start_time'].' / '.$reservations_at_time_range[0]['reservation_end_time'].')!');
                    return redirect()->to('/reservations/add');
                }
            // 
            // check if user is free
                $all_user_reservations = $reservation_model->findAllWhereUserJoinFullDataOrdered($user_data['id']);
                $reservations_at_time_range = $reservation_model->filterFullReservationsDataByDatesRange($all_user_reservations, $data['general_start_date'], $data['general_end_date']);
                if($reservations_at_time_range){
                    session()->setFlashdata('form_validation_failure', 'Wybrany użytkownik ('.$user_data['email'].') wynajmuje w tym czasie ('.$reservations_at_time_range[0]['reservation_start_time'].' / '.$reservations_at_time_range[0]['reservation_end_time'].') inny pokój!');
                    return redirect()->to('/reservations/add');
                }
            // 
        // *
        $newContractNumber = $reservation_model -> getNewContractNumber();
        
            
        // if somebody creates a free reservation (100% discount or another user is paying for room), set "payment done" automatically as true
        if($data['price'] == 0){
            $data['payment_done'] = 1;
        } else {
            $data['payment_done'] = 0;
        }

        $return_link = '/reservations/by_user?'.http_build_query([
            'user_email' => $user_data['email']
        ]);

        if ($data['method'] == "daily"){
            
            $newData = [
                'notes' => $data['notes'],
                'user_id' => $user_data['id'],
                'slot_id' => $slot_data['id'],
                'slot_room_id' => $slot_data['room_id'],
                'slot_room_building_id' => $slot_data['room_building_id'],
                'start_time' => $data['general_start_date'],
                'end_time' => $data['general_end_date'],
                'type' => ($data['method'] == "monthly") ? 0 : 1,
                'price' => $data['price'],
                'payment_done' => $data['payment_done'],
                'contract_number' => $newContractNumber,
            ];
            
            $reservation_model->save($newData);
            session()->setFlashdata('success', 'Zapisano pomyślnie!');
            return redirect()->to($return_link);
        }
        else {
            $newData = [
                'notes' => $data['notes'],
                'user_id' => $user_data['id'],
                'slot_id' => $slot_data['id'],
                'slot_room_id' => $slot_data['room_id'],
                'slot_room_building_id' => $slot_data['room_building_id'],
                'type' => ($data['method'] == "monthly") ? 0 : 1,
                'price' => $data['price'],
                'payment_done' => $data['payment_done'],
                'contract_number' => $newContractNumber,
            ];

            $dividedDatesArray = $dateOperator->getDividedTimeDates($data['general_start_date'],$data['general_end_date']);

            foreach($dividedDatesArray as $monthLikeElement){
                $newData['start_time'] = $monthLikeElement['start'];
                $newData['end_time'] = $monthLikeElement['end'];
                // print_r($newData);
                // echo '<br>';
            
                $reservation_model->save($newData);

            }

            session()->setFlashdata('success', 'Zapisano pomyślnie!');
            return redirect()->to($return_link);
        }


    }

    public function info($id){
        $data = [];
        $reservation_model = new ReservationModel();
        $data['current_reservation'] = $reservation_model->findJoinFullDataOrdered($id);

        
        if(!$data['current_reservation']){
            session()->setFlashdata('failure', 'Rezerwacja o nr #'.$id.' nie istnieje lub została usunięta!');
            return redirect()->to('/reservations');
        }

        // add status column - active / ended / awaiting for start

        // In the function addColumnReservationStatus the data input is unindexed array (list) of indexed arrays (single reservations)
        // Because $data['current_reservation'] is the single reservation (indexed array), we are putting it to the list (it is going to contain only one element)
        // after retrieving result list, we are taking its first element using ()[0]
        $data['current_reservation'] = ($reservation_model->addColumnReservationStatus([
            0 => $data['current_reservation']
        ]))[0];
        

        echo view('templates/header');
        echo view("reservations/info", $data);
        echo view('templates/footer');
    }

    public function edit($id){
        $data = [];
        $reservation_model = new ReservationModel();
        $data['current_reservation'] = $reservation_model->findJoinFullDataOrdered($id);
        
        if(!$data['current_reservation']){
            session()->setFlashdata('failure', 'Rezerwacja o nr #'.$id.' nie istnieje lub została usunięta!');
            return redirect()->to('/reservations');
        }


        $post_data = $this->request->getPost();
        if($post_data){
            // print_r($post_data);

            if(!isset($post_data['payment_done']) || !isset($post_data['notes'])){
                session()->setFlashdata('form_validation_failure', 'Niepoprawne dane!');
                return redirect()->to('/reservations/edit/'.$id);
            }

            $newData = [
                'id' => $id,
                'payment_done' => ($post_data['payment_done'] == 'payment_realised') ? 1 : 0,
                'notes' => $post_data['notes']
            ];

            $reservation_model->save($newData);

            
            session()->setFlashdata('success', 'Zapisano pomyślnie!');
            return redirect()->to('/reservations/info/'.$id);

        }

        // print_r($data);


        echo view('templates/header');
        echo view("reservations/edit", $data);
        echo view('templates/footer');
    }

    public function delete_confirm($id){
        $data = [];
        $reservation_model = new ReservationModel();
        $data['current_reservation'] = $reservation_model->findJoinFullDataOrdered($id);
        
        if(!$data['current_reservation']){
            session()->setFlashdata('failure', 'Rezerwacja o nr #'.$id.' nie istnieje lub została usunięta!');
            return redirect()->to('/reservations');
        }

        if($this->request->getPost('confirm') == 'true'){
            // return "deleting";
            $reservation_model->delete($id);
            session()->setFlashdata('success', 'Usunięto pomyślnie!');
            return redirect()->to('/reservations');
        }

        $data['dest_submit'] = "#";
        $data['dest_cancel'] = "/reservations/info/".$id;
        $data['title'] = "Potwierdzenie";
        $data['question'] = "Czy na pewno chcesz usunąć rezerwację nr #".$id."?";


        echo view('templates/header');
        echo view("components/delete_confirm", $data);
        echo view('templates/footer');

    }


}
