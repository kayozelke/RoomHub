<?php

namespace App\Controllers;

use App\Models\BuildingModel;
use App\Models\ReservationModel;
use App\Models\RoomModel;
use App\Models\RoomTypeModel;
use App\Models\SlotModel;

class Rooms extends BaseController
{
    public function index()
    {
        return redirect()->to('/buildings');
    }

    public function by_building($id)
    {
        
        $data = [];        
        
        $model = new BuildingModel();
        $data['building'] = $model->find($id);

        $model = new RoomModel();
        $data['rooms'] = $model->findWhereBuildingIdJoinRoomTypeOrdered($id);

        echo view('templates/header');
        echo view('rooms/rooms_of_building', $data);
        echo view('templates/footer');

    }

    public function add($building_id = null){
        $room_model = new RoomModel();
        $building_model = new BuildingModel();
        $room_type_model = new RoomTypeModel();
        $slot_model = new SlotModel();
        
        if($this->request->getPost()){
            
            if(!$this->request->getPost('room_type_id')){
                session()->setFlashdata('failure', 'Wystąpił błąd - niepoprawny rodzaj pokoju!');
                return redirect()->back();
            }

            //validations
            $rules = [
                'number' => 'required|is_unique_in_building['.$this->request->getPost('building_id').']',
            ];

            $errors = [
                'number' => [
                    'required' => 'Numer pokoju jest wymagany',
                    'is_unique_in_building' => 'Podany numer pokoju ('.$this->request->getPost('number').') jest już zajęty',
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                // handle validation errors
                $data['validation'] = $this->validator;
            }
            else {
                $data = $this->request->getPost();     
                $room_model->insert($data);
                
                $new_room_id = $room_model->getInsertID();
                
                // * automatically add slots
                    $room_type_data = $room_type_model->find($data['room_type_id']);

                    for($i=1; $i<=$room_type_data['max_residents']; $i++){
                        $newSlotData = [
                            'name' => 'Nr '.$i,
                            'room_id' => $new_room_id,
                            'room_building_id' => $data['building_id']
                        ];
                        $slot_model->save($newSlotData);
                    }
                // *

                session()->setFlashdata('success', 'Dodano pomyślnie!');
                return redirect()->to('/rooms/by_building/'.$data['building_id']);
            }
        }

            
        $data['id'] = $building_id;
        $data['buildings'] = $building_model->findAllOrdered();
        $data['room_types'] = $room_type_model->findAllOrdered();

        echo view('templates/header');
        echo view('rooms/add', $data);
        echo view('templates/footer');
    }

    public function info($id){
        $room_model = new RoomModel();
        $room_data = $room_model->find($id);


        if(!$room_data){
            session()->setFlashdata('failure', 'Pokój o ID #'.$id.' nie istnieje lub został usunięty!');
            return redirect()->to('/buildings');
        } else{
            $rooms_type_model = new RoomTypeModel();
            $building_model = new BuildingModel();
            $reservation_model = new ReservationModel();
            $slot_model = new SlotModel();
            
            $data = [
                'room_data' => $room_data,
                'room_type_data' => $rooms_type_model->find($room_data['room_type_id']),
                'building_data' => $building_model->find($room_data['building_id']),
                
                // 'slots_data' => $room_model -> findJoinSlots($id),
                'slots_data' => [],
            ];
            $slots = $slot_model -> findAllByRoomId($id);

            foreach($slots as $current_slot){
                $current_slot_data = $current_slot;
                $slot_all_reservations = $reservation_model->findAllWhereSlotJoinFullDataOrdered($current_slot['id']);
                $slot_all_reservations = $reservation_model->addColumnReservationStatus($slot_all_reservations);

                if($reservation_model->isSlotFreeAtDay($slot_all_reservations,date('Y-m-d'))){
                    // print_r("FREE TODAY");
                    $current_slot_data['isFree'] = true;
                    $current_slot_data['nextStartDate'] = $reservation_model -> findNextStartDateOfSlotInReservations($slot_all_reservations);

                    // print_r(' .. until '.$current_slot_data['nextStartDate']);
                }
                else {
                    // print_r("BUSY TODAY");
                    $current_slot_data['isFree'] = false;
                    $current_slot_data['nextEndDate'] = $reservation_model -> findNextEndDateOfSlotInReservations($slot_all_reservations);
                }



                
                // if($current_slot_data['nextEndDate'] == null){
                //     $current_slot_data['isFree'] = true;
                // } else{
                //     $current_slot_data['isFree'] = false;
                // }
                
                array_push($data['slots_data'], $current_slot_data);
                // echo '<br>';
                    // print_r($current_slot_data);
                // echo '<br>';


            }

            // print_r($data['slots_data']);

            echo view('templates/header');
            echo view('rooms/info', $data);
            echo view('templates/footer');

        }


    }

    public function edit($id){

        $data = [];
        $room_model = new RoomModel();

        $room_data = $room_model->find($id);
        
        if(!$room_data){
            session()->setFlashdata('failure', 'Pokój o ID #'.$id.' nie istnieje lub został usunięty!');
            return redirect()->to('/buildings');
        }

        // if anything was sent
        if($this->request->getPost()){
            
            if(!$this->request->getPost('room_type_id')){
                session()->setFlashdata('failure', 'Wystąpił błąd - niepoprawny rodzaj pokoju!');
                return redirect()->back();
            }

            $rules = [
                'number' => 'required|is_unique_in_building['.$room_data['building_id'].']',
            ];

            $errors = [
                'number' => [
                    'required' => 'Numer pokoju jest wymagany',
                    'is_unique_in_building' => 'Podany numer pokoju ('.$this->request->getPost('number').') jest już zajęty',
                ]
            ];

           

            // if room number has been changed and it is wrong
            if (($room_data['number'] != $this->request->getPost('number')) && (!$this->validate($rules, $errors))) {
                // handle validation errors
                $data['validation'] = $this->validator;
        
            // if room number has been changed and it is correct or if the number is still the same
            } else {
                $newData = $this->request->getPost();
                $newData['id'] = $id;

                $room_model->save($newData);
    
                session()->setFlashdata('success', 'Zapisano pomyślnie!');
                return redirect()->to('/rooms/info/' . $id);
            }

        }

        $room_type_model = new RoomTypeModel();
        $building_model = new BuildingModel();
        
        $data['room_data'] = $room_data;
        $data['room_types'] = $room_type_model->findAllOrdered();
        $data['building_data'] = $building_model->find($room_data['building_id']);

        echo view('templates/header');
        echo view('rooms/edit', $data);
        echo view('templates/footer');



    }

    public function add_slot($room_id, $slot_id = null){
        $data = [];

        $room_model = new RoomModel();
        $room_data = $room_model->find($room_id);

        if(!$room_data){
            session()->setFlashdata('failure', 'Pokój o ID #'.$room_id.' nie istnieje lub został usunięty!');
            return redirect()->to('/buildings');
        }
        $slot_model = new SlotModel();

        if($slot_id) {
            $old_slot_data = $slot_model->find($slot_id);
            $data['slot_data'] = $old_slot_data;

            if(!$old_slot_data || $old_slot_data['room_id'] != $room_id){
                session()->setFlashdata('failure', 'Miejsce o ID #'.$slot_id.' nie istnieje lub zostało usunięte!');
                return redirect()->to('/buildings');
            } else {
                $data['id'] = $slot_id;
            }
        }

        if($this->request->getPost()){
            
            $data['name'] = $this->request->getPost('name'); 
            $data['room_id'] = $room_data['id'];
            $data['room_building_id'] = $room_data['building_id'];
            
            $slot_model -> save($data);
            session()->setFlashdata('success', 'Zapisano pomyślnie!');
            return redirect()->to('/rooms/info/' . $room_id);
        }

        $data['room_data'] = $room_data;
        echo view('templates/header');
        echo view('rooms/add_slot', $data);
        echo view('templates/footer');
    }


    public function delete_slot_confirm($id){
        $data = [];
        $slot_model = new SlotModel();
        $reservation_model = new ReservationModel();
        $data['slot'] = $slot_model->find($id);
        
        if(!$data['slot']){
            session()->setFlashdata('failure', 'Miejsce o ID #'.$id.' nie istnieje lub zostało usunięte!');
            return redirect()->back();
        }
        // do not delete if reservations data exist
        $data['slot_reservations'] = $reservation_model -> findAllWhereSlotJoinFullDataOrdered($id);
        if($data['slot_reservations']){
            session()->setFlashdata('failure', 'Nie można usunąć miejsca z przydzielonymi rezerwacjami! Liczba rezerwacji: '.count( $data['slot_reservations'] ));
            return redirect()->to('/rooms/info/'.$data['slot']['room_id']);
        }

        if($this->request->getPost('confirm') == 'true'){
            // return "deleting";
            $slot_model->delete($id);
            session()->setFlashdata('success', 'Usunięto pomyślnie!');
            return redirect()->to('/rooms/info/'.$data['slot']['room_id']);
        }

        $data['dest_submit'] = "#";
        $data['dest_cancel'] = '/rooms/info/'.$data['slot']['room_id'];
        $data['title'] = "Potwierdzenie";
        $data['question'] = "Czy na pewno chcesz usunąć miejsce '".$data['slot']['name']."' (ID #$id)?";


        echo view('templates/header');
        echo view("components/delete_confirm", $data);
        echo view('templates/footer');
    }

    public function delete_room_confirm($id){
        $data = [];
        $room_model = new RoomModel();
        $slot_model = new SlotModel();
        $data['room'] = $room_model->find($id);
        
        if(!$data['room']){
            session()->setFlashdata('failure', 'Pokój o ID #'.$id.' nie istnieje lub został usunięty!');
            return redirect()->to('/buildings');
        }
        // do not delete if slot data exist - DISABLED
        // $data['slots'] = $slot_model -> findAllByRoomId($id);

        // if($data['slots']){
        //     session()->setFlashdata('failure', 'Nie można usunąć pokoju z przydzielonymi miejscami! Liczba miejsc: '.count( $data['slots'] ));
        //     return redirect()->to('/rooms/info/'.$id);
        // }

        if($this->request->getPost('confirm') == 'true'){
            // return "deleting";
            if($room_model->deleteWithSlots($id)){
                session()->setFlashdata('success', 'Usunięto pomyślnie!');
                return redirect()->to('/rooms/by_building/'.$data['room']['building_id']);
            } else {
                $reserv_number = (new ReservationModel())->getRoomReservationsNumber($id);
                session()->setFlashdata('failure', 'Nie można usunąć pokoju z przydzielonymi rezerwacjami! Liczba rezerwacji: '.$reserv_number);
                return redirect()->to('/rooms/info/'.$id);
            }
        }

        $data['dest_submit'] = "#";
        $data['dest_cancel'] = '/rooms/info/'.$id;
        $data['title'] = "Potwierdzenie";
        $data['question'] = "Czy na pewno chcesz usunąć pokój nr '".$data['room']['number']."' (ID #$id)?";


        echo view('templates/header');
        echo view("components/delete_confirm", $data);
        echo view('templates/footer');
    }

}
