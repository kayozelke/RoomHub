<?php

namespace App\Controllers;

use App\Models\RoomTypeModel;
use App\Libraries\PrivilegesManager;
use App\Models\RoomModel;
use Config\CustomConfig;

class Roomtypes extends BaseController
{
    public function index()
    {
        
        $data = [];
        $model = new RoomTypeModel();
        
        $data['data'] = $model->findAllOrdered();
       


        echo view('templates/header');
        echo view('room_types/room_types', $data);
        echo view('templates/footer');
        
        
        // print_r (session()->get());
        // return view('welcome_message');
    }


    public function add(){

        if(session()->get('id')){
            $PrivilegesManagerObject = new PrivilegesManager();
            // check if current user is at least moderator (priveleges level >= 1)
            if(!$PrivilegesManagerObject->isUserModerator(session()->get('id'))){
                session()->setFlashdata('failure', 'Brak uprawnień!');
                return redirect()->back();
            }
        }

        $model = new RoomTypeModel();
        
        $data = [];
        $data = $this->request->getPost(); 

        if($data){    
            $rules = [
                'name' => 'required',
                'price_month' => 'required|greater_than_equal_to[0]',
                'max_residents' => 'required|greater_than_equal_to[0]',
            ];

            if(! $this->validate($rules, (new CustomConfig())->room_type_validation_errors())){
                // handle validation erros
                $data ['validation'] = $this->validator;
                // print_r('errors'); return null;
                
            } else {              
                $model -> save($data);

                // CodeIgniter supports “flashdata”, or session data that will only be available for the next request, and is then automatically cleared.
                session()->setFlashdata('success', 'Dodano pomyślnie!');
                return redirect()->to('/roomtypes');
            }

        }
        
        

        
        echo view('templates/header');
        echo view('room_types/add', $data);
        echo view('templates/footer');
        
        return null;
    }

    public function edit($id){
        if(session()->get('id')){
            $PrivilegesManagerObject = new PrivilegesManager();
            // check if current user is at least moderator (priveleges level >= 1)
            if(!$PrivilegesManagerObject->isUserModerator(session()->get('id'))){
                session()->setFlashdata('failure', 'Brak uprawnień!');
                return redirect()->back();
            }
        }
        
        
        $data = [];
        
        $model = new RoomTypeModel();

        if($this->request->getPost()){
            $data = $this->request->getPost();  
            $data['id'] = $id;

            $rules = [
                'name' => 'required',
                'price_month' => 'required|greater_than_equal_to[0]',
                'max_residents' => 'required|greater_than_equal_to[0]',
            ];

            if(! $this->validate($rules, (new CustomConfig())->room_type_validation_errors())){
                // handle validation erros
                $data ['validation'] = $this->validator;
                
            } else {

                $model -> save($data);

                // // CodeIgniter supports “flashdata”, or session data that will only be available for the next request, and is then automatically cleared.
                session()->setFlashdata('success', 'Zapisano pomyślnie!');
                return redirect()->to('/roomtypes');
            }

        }
        $data['data'] = $model->find($id);
        
        
        echo view('templates/header');
        echo view('room_types/edit', $data);
        echo view('templates/footer');
        
        return null;
    }

    public function delete_confirm($id){
        $data = [];
        $room_type_model = new RoomTypeModel();
        $room_model = new RoomModel();
        $data['room_type'] = $room_type_model->find($id);
        
        if(!$data['room_type']){
            session()->setFlashdata('failure', 'Rodzaj pokoju o ID #'.$id.' nie istnieje lub został usunięty!');
            return redirect()->to('/roomtypes');
        }
        // do not delete if room data exist
        $data['rooms'] = $room_model -> findAllWhereRoomType($id);
        if($data['rooms']){
            session()->setFlashdata('failure', "Nie można usunąć rodzaju pokoju, jeśli istnieje pokój tego typu! Liczba pokoi z przypisanym typem '".$data['room_type']['name']."': ".count( $data['rooms'] ));
            return redirect()->to('/roomtypes');
        }
        // return null;

        if($this->request->getPost('confirm') == 'true'){
            // return "deleting";
            $room_type_model->delete($id);
            session()->setFlashdata('success', 'Usunięto pomyślnie!');
            return redirect()->to('/roomtypes');
        }

        $data['dest_submit'] = "#";
        $data['dest_cancel'] = '/roomtypes';
        $data['title'] = "Potwierdzenie";
        $data['question'] = "Czy na pewno chcesz rodzaj pokoju nazwany '".$data['room_type']['name']."' (ID #$id)?";


        echo view('templates/header');
        echo view("components/delete_confirm", $data);
        echo view('templates/footer');
    }
}
