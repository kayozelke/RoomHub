<?php

namespace App\Controllers;

use App\Models\BuildingModel;
use App\Libraries\PrivilegesManager;
use App\Models\ReservationModel;
use App\Models\RoomModel;

class Buildings extends BaseController
{
    public function index()
    {
        // TODO make it handled in routes
        // if(!(session()->get('isLoggedIn')))
        //     return redirect()->to('/');
        
        $data = [];
        $model = new BuildingModel();
        
        $data['data'] = $model->findAllOrdered();
       


        echo view('templates/header', $data);
        echo view('buildings/buildings', $data);
        echo view('templates/footer');
        
        
        // print_r (session()->get());
        // return view('welcome_message');
    }
    
    public function info($id){
        
        $data = [];        
        $building_model = new BuildingModel();
        $room_model = new RoomModel();
        $reservation_model = new ReservationModel();

        // $data['data'] = $model->findAllByBuildingId($id);
        
        $data['current_building_info'] = $building_model->find($id);

        $data['current_building_rooms_count'] = $room_model->countRoomsInBuilding($id);

        $slots_data = $room_model->findAllWhereBuildingJoinSlots($id, 'slot.id as id, room.id as room_id');

        // * reservations calculation
            $reservation_data = $reservation_model -> findAllJoinFullDataOrdered();
            // only this building
            $reservation_data = $reservation_model -> filterFullReservationsDataByFieldValue($reservation_data, 'building_id', $id);
            // only today
            $today_str = date('Y-m-d');
            $today_reservation_data = $reservation_model -> filterFullReservationsDataByDatesRange($reservation_data, $today_str, $today_str);
        // *

        $data['current_building_slots_count'] = count($slots_data);
        $data['current_building_reservations_today_count'] = count($today_reservation_data);

        // print_r($slots_data);
        // print_r($data);
        

        echo view('templates/header');
        echo view('buildings/info', $data);
        echo view('templates/footer');
        
        // return null;
    }

    public function add(){

        // not used since we have CI filters => app/Config/Routes.php + Filters.php

        // if(session()->get('id')){
        //     $PrivilegesManagerObject = new PrivilegesManager();
        //     // check if current user is at least moderator (priveleges level >= 1)
        //     if(!$PrivilegesManagerObject->isUserModerator(session()->get('id'))){
        //         session()->setFlashdata('failure', 'Brak uprawnień!');
        //         return redirect()->back();
        //     }
        // }

        $model = new BuildingModel();

        if($this->request->getMethod() == 'post'){

            $newData = [
                'address' => esc($this->request->getVar('address')),
                'name' => esc($this->request->getVar('name')),
                'description' => nl2br(esc($this->request->getVar('description'))),
            ];
       
            
            $model -> save($newData);

            $session = session();
            // CodeIgniter supports “flashdata”, or session data that will only be available for the next request, and is then automatically cleared.
            $session->setFlashdata('success', 'Obiekt został dodany pomyślnie!');
            return redirect()->to('/buildings');

            // echo view('templates/header');
            // echo "<br>";
            // print_r($newData);
            // echo "<br>";
            // echo view('templates/footer');
            // return null;
        }
        
        $data = [];
        

        
        echo view('templates/header');
        echo view('buildings/add');
        echo view('templates/footer');
        
        return null;
    }


    public function edit($id){

        // not used since we have CI filters => app/Config/Routes.php + Filters.php
        
        // if(session()->get('id')){
        //     $PrivilegesManagerObject = new PrivilegesManager();
        //     // check if current user is at least moderator (priveleges level >= 1)
        //     if(!$PrivilegesManagerObject->isUserModerator(session()->get('id'))){
        //         session()->setFlashdata('failure', 'Brak uprawnień!');
        //         return redirect()->back();
        //     }
        // }

        $model = new BuildingModel();

        $data = [];
        $data['data'] = $model->find($id);

        if($this->request->getMethod() == 'post'){
            
            $newData = [
                'address' => esc($this->request->getVar('address')),
                'name' => esc($this->request->getVar('name')),
                'description' => nl2br(esc($this->request->getVar('description'))),
            ];

            $newData['id'] = $id;

            print_r($newData);
            
       
            
            $model -> save($newData);

            $session = session();
            // // CodeIgniter supports “flashdata”, or session data that will only be available for the next request, and is then automatically cleared.
            $session->setFlashdata('success', 'Zapisano pomyślnie!');
            return redirect()->to('/buildings/info/'.$id);

        
        }
        
        // print_r($data);
        
        
        echo view('templates/header');
        echo view('buildings/edit', $data);
        echo view('templates/footer');
        
        return null;
    }

    public function delete_confirm($id){
        $data = [];
        $room_model = new RoomModel();
        $building_model = new BuildingModel();
        $data['building'] = $building_model->find($id);
        
        if(!$data['building']){
            session()->setFlashdata('failure', 'Obiekt o ID #'.$id.' nie istnieje lub został usunięty!');
            return redirect()->to('/buildings');
        }
        // do not delete if room data exist
        $data['rooms'] = $room_model->findWhereBuildingIdOrdered($id);

        if($data['rooms']){
            session()->setFlashdata('failure', 'Nie można usunąć obiektu z przydzielonymi pokojami! Liczba pokoi: '.count( $data['rooms'] ));
            return redirect()->to('/buildings/info/'.$id);
        }

        if($this->request->getPost('confirm') == 'true'){
            // return "deleting";
            $building_model->delete($id);
            session()->setFlashdata('success', 'Usunięto pomyślnie!');
            return redirect()->to('/buildings');
        }

        $data['dest_submit'] = "#";
        $data['dest_cancel'] = '/buildings/info/'.$id;
        $data['title'] = "Potwierdzenie";
        $data['question'] = "Czy na pewno chcesz obiekt '".$data['building']['name']."' (ID #$id)?";


        echo view('templates/header');
        echo view("components/delete_confirm", $data);
        echo view('templates/footer');
    }
}
