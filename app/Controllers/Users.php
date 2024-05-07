<?php

namespace App\Controllers;

use App\Libraries\PrivilegesManager;
use App\Models\ReservationModel;
use App\Models\UserModel;
use Config\CustomConfig;

class Users extends BaseController
{
    // whole users controller is only for moderators. rule is specified by filters

    public function index()
    {
        $preData = [];
        $model = new UserModel();
        $preData['data'] = $model->findAll();

        $PrivilegesManagerObject = new PrivilegesManager();
        $fullData = [];
        $fullData['data'] = [];

        foreach ($preData['data'] as $row) {
            
            $modified_row = $row;
            $modified_row['privileges_level_name'] = $PrivilegesManagerObject->levelToNameStr($row['privileges_level']);
            array_push($fullData['data'], $modified_row);
        }


        echo view('templates/header');
        echo view('users/users', $fullData);
        echo view('templates/footer');
    }

    public function info($id)
    {

        $data = [];
        $user_model = new UserModel();
        $data['data'] = $user_model->find($id);
        
        $PrivilegesManagerObject = new PrivilegesManager();
        $data['data']['privileges_level_name'] = $PrivilegesManagerObject->levelToNameStr($data['data']['privileges_level']);


        echo view('templates/header');
        echo view('users/info', $data);
        // print_r($data);
        echo view('templates/footer');

    }

    public function increase_privileges($id)
    {

        $data = [];
        $user_model = new UserModel();
        $userData = $user_model->find($id);

        $next_level = $userData['privileges_level'] + 1;

        $PrivilegesManagerObject = new PrivilegesManager();
        $PrivilegesManagerObject->setPrivilegesLevel($id, $next_level);


        return redirect()->to('/users/info/'.$id);
    }

    public function decrease_privileges($id)
    {

        $data = [];
        $user_model = new UserModel();
        $userData = $user_model->find($id);

        $next_level = $userData['privileges_level'] - 1;

        $PrivilegesManagerObject = new PrivilegesManager();
        $PrivilegesManagerObject->setPrivilegesLevel($id, $next_level);


        return redirect()->to('/users/info/'.$id);
    }

    public function edit($id)
    {
        $data = [];
        $user_model = new UserModel();
        helper(['form']);

        $customConfig = new CustomConfig();


        if ($this->request->getPost()) {

            //validations
            $rules = [
                'firstname' => 'required|min_length[' . $customConfig->firstname_min_length . ']|max_length[' . $customConfig->firstname_max_length . ']',
                'lastname' => 'required|min_length[' . $customConfig->lastname_min_length . ']|max_length[' . $customConfig->lastname_max_length . ']',
            ];

            // moderators can change emails
            if ($this->request->getPost('email') != '') {
                $rules['email'] = 'required|min_length[' . $customConfig->email_min_length . ']|max_length[' . $customConfig->email_max_length . ']|valid_email|is_unique[user.email]';
            }

            if ($this->request->getPost('password') != '' || $this->request->getPost('password_confirm') != '') {
                $rules['password'] = 'required|min_length[' . $customConfig->password_min_length . ']|max_length[' . $customConfig->password_max_length . ']';
                $rules['password_confirm'] = 'matches[password]';
            }

            if (!$this->validate($rules, $customConfig->user_validation_errors())) {
                // handle validation errors
                $data['validation'] = $this->validator;
            } else {
                // update user in database

                $newData = [
                    'id' => $id,
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                ];

                if ($this->request->getPost('email') != '') {
                    $newData['email'] = $this->request->getPost('email');
                }

                if ($this->request->getPost('password') != '') {
                    $newData['password'] = $this->request->getPost('password');
                }

                $user_model->save($newData);

                if ($id == session()->get('id')) {

                    session()->destroy();
                    // echo "WYLOGOWANO!";
                    // return null;
                    session()->setFlashdata('success', 'Wylogowano pomyślnie!');
                    return redirect()->to('/');
                }



                // $session = session();
                session()->setFlashdata('success', 'Zapisano pomyślnie!');

                return redirect()->to('users/info/' . $id);
            }
        }
        $data['data'] = $user_model->find($id);

        echo view('templates/header');
        echo view('users/edit', $data);
        // print_r($data);
        echo view('templates/footer');
    }


    public function delete_confirm($id){
        $data = [];
        $user_model = new UserModel();
        $reservation_model = new ReservationModel();
        $data['user'] = $user_model->find($id);
        
        if(!$data['user']){
            session()->setFlashdata('failure', 'Użytkownik o ID #'.$id.' nie istnieje lub został usunięty!');
            return redirect()->to('/users');
        }
        // do not delete if reservations data exist
        $data['user_reservations'] = $reservation_model -> findAllWhereUserJoinFullDataOrdered($id);
        if($data['user_reservations']){
            session()->setFlashdata('failure', 'Nie można usunąć użytkownika z przydzielonymi rezerwacjami! Liczba rezerwacji: '.count( $data['user_reservations'] ));
            return redirect()->to('/users/info/'.$id);
        }

        if($this->request->getPost('confirm') == 'true'){
            // return "deleting";
            $user_model->delete($id);
            session()->setFlashdata('success', 'Usunięto pomyślnie!');
            return redirect()->to('/users');
        }

        $data['dest_submit'] = "#";
        $data['dest_cancel'] = "/users/info/".$id;
        $data['title'] = "Potwierdzenie";
        $data['question'] = "Czy na pewno chcesz usunąć użytkownika '".$data['user']['email']."' (ID #$id)?";


        echo view('templates/header');
        echo view("components/delete_confirm", $data);
        echo view('templates/footer');

    }
}
