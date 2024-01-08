<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\PrivilegesManager;
use App\Models\ReservationModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AuthController extends BaseController
{
    // not using these fields since created the CustomConfig class in App\Config\CustomConfig.php
    // private $firstname_name = "imię" ;
    //     private $firstname_min_length = 3;
    //     private $firstname_max_length = 20;

    // private $lastname_name = "nazwisko" ;
    //     private $lastname_min_length = 3;
    //     private $lastname_max_length = 30;
    
    // private $email_name = "email" ;    
    //     private $email_min_length = 6;
    //     private $email_max_length = 50;
        
    // private $password_name = "hasło" ;
    //     private $password_min_length = 8;
    //     private $password_max_length = 55;

    private $customConfig;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // load config class
        $this->customConfig = new \Config\CustomConfig();
    }

        


    public function index()
    {
        $data = [];
        helper(['form']);

        // echo "<h1>AuthController :: index()</h1>";

        if(session()->get('isLoggedIn')){
            return redirect()->to('/dashboard');
        }

        if($this->request->getMethod() == 'post'){  // check if method is POST, because GET could cause some problems
            //validations
            $rules = [
                'email' => 'required',
                'password' => 'required|validateUser[email,password]',
            ];

            $errors = $this->customConfig->user_validation_errors();
            $errors['password']['validateUser'] = 'Błędny '.$this->customConfig->email_name.' lub '.$this->customConfig->password_name.'.';

            if(! $this->validate($rules, $errors)){
                // handle validation erros
                $data ['validation'] = $this->validator;
                
            } else {
                // try to login
                // inicialize model
                $model = new UserModel();

                $user = $model->where('email',$this->request->getVar('email'))
                                -> first();

                $this->setUserSession($user);
                
                session()->setFlashdata('success', 'Zalogowano pomyślnie!');
                return redirect()->to('dashboard');
            }
        } 


        echo view('templates/header', $data);
        echo view('auth_user/login');
        echo view('templates/footer');
    }

    private function setUserSession($user){

        $PrivilegesManagerObject = new PrivilegesManager();

        $data = [
            'id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'isLoggedIn' => true,
            'privileges_level' => $user['privileges_level'],
            'isModerator' => $PrivilegesManagerObject->isUserModerator($user['id']),
            'sessionStartTime' => time(),
            'sessionEndTime' => time() + config('Session')->expiration,
        ];


        session()->set($data);
        return true;
    }

    public function register(){
        $data = [];
        helper(['form']);
        // echo "<h1>AuthController :: register()</h1>";


        if($this->request->getMethod() == 'post'){  // check if method is POST, because GET could cause some problems
            //validations

            $rules = [
                'firstname' => 'required|min_length['.$this->customConfig->firstname_min_length.']|max_length['.$this->customConfig->firstname_max_length.']',
                'lastname' => 'required|min_length['.$this->customConfig->lastname_min_length.']|max_length['.$this->customConfig->lastname_max_length.']',
                'email' => 'required|min_length['.$this->customConfig->email_min_length.']|max_length['.$this->customConfig->email_max_length.']|valid_email|is_unique[user.email]', // CI will automatically check if this is unique in table.column
                'password' => 'required|min_length['.$this->customConfig->password_min_length.']|max_length['.$this->customConfig->password_max_length.']',
                'password_confirm' => 'matches[password]',
            ];

            if(! $this->validate($rules, $this->customConfig->user_validation_errors())){
                // handle validation erros
                $data ['validation'] = $this->validator;
                
            } else {
                // store user in database
                // inicialize model
                $model = new UserModel();

                $newData = [
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                ];
                
                $model -> save($newData);

                $session = session();
                // CodeIgniter supports “flashdata”, or session data that will only be available for the next request, and is then automatically cleared.
                $session->setFlashdata('success', 'Zarejestrowano pomyślnie!');
                return redirect()->to('/');
            }
        } 


        echo view('templates/header', $data);
        echo view('auth_user/register');
        echo view('templates/footer');
    }

    public function logout(){
        session()->destroy();
        // echo "WYLOGOWANO!";
        // return null;
        session()->setFlashdata('success', 'Wylogowano pomyślnie!');
        return redirect()->to('/');
    }

    public function profile(){
        $data = [];
        helper(['form']);
        // echo "<h1>AuthController :: profile()</h1>";

        // inicialize model
        $model = new UserModel();


        if($this->request->getMethod() == 'post'){  // check if method is POST, because GET could cause some problems
            //validations
            $rules = [
                'firstname' => 'required|min_length['.$this->customConfig->firstname_min_length.']|max_length['.$this->customConfig->firstname_max_length.']',
                'lastname' => 'required|min_length['.$this->customConfig->lastname_min_length.']|max_length['.$this->customConfig->lastname_max_length.']',
            ]; //no email
            
            if($this->request->getPost('password') != '' || $this->request->getPost('password_confirm') != '' ){
                $rules['password'] = 'required|min_length['.$this->customConfig->password_min_length.']|max_length['.$this->customConfig->password_max_length.']';
                $rules['password_confirm'] = 'matches[password]';
            }

            if(! $this->validate($rules, $this->customConfig->user_validation_errors())){
                // handle validation erros
                $data ['validation'] = $this->validator;
                
            } else {
                // update  user in database

                $newData = [
                    'id' => session()->get('id'),
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                    // 'email' => $this->request->getVar('email'),
                ];
                if($this->request->getPost('password') != ''){
                    $newData['password'] = $this->request->getPost('password');
                }
                
                $model -> save($newData);

                // update session data
                $user = $model->where('email', session()->get('email'))
                                -> first();
                $this->setUserSession($user);

                // print_r($user);
                // return null;


                $session = session();
                $session->setFlashdata('success', 'Zapisano pomyślnie!');
                return redirect()->to('/profile');
            }
        } 

        $data['user'] = $model->where('id',session()->get('id'))->first();
        echo view('templates/header', $data);
        echo view('auth_user/profile');
        echo view('templates/footer');
    }

    public function test(){
        
        $reservation_model = new ReservationModel();

        // foreach ($reservation_model->findAll() as $row){
            
            //     $data = [
            //         'id'                => $row['id'],
            //         'notes'             => $row['notes'],
            //         'user_id'           => $row['user_id'],
            //         'slot_id'           => $row['slot_id'],
            //         'slot_room_id'      => $row['slot_room_id'],
            //         'slot_room_building_id'      => $row['slot_room_building_id'],
            //         'start_time'        => '2023-12-25',
            //         'end_time'          => '2024-01-25',
            //         'price'             => 499,
            //     ];
                
            //     $reservation_model->save($data);
        // }

        // $reservation_model->delete(1);

        foreach ($reservation_model->findAll() as $row){            
            print_r($row);
            print_r('<br>');
            print_r('<br>');
        }

    }

    public function foo(){
        return "AuthController::foo()";
    }
}
