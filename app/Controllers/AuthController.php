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
        // loading config class
        $this->customConfig = new \Config\CustomConfig();
    }



    // login and default page without session

    public function index()
    {
        $data = [];
        helper(['form']);

        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        // check if there is an attempt for logging in
        if ($this->request->getPost()) {
            //validations
            $rules = [
                'email' => 'required',
                #validateUser method added to framework's validation class. Method code is defined at \App\Validation\AuthRules.php
                'password' => 'required|validateUser[email,password]',
            ];

            $errors = $this->customConfig->user_validation_errors();
            $errors['password']['validateUser'] = 'Błędny ' . $this->customConfig->email_name . ' lub ' . $this->customConfig->password_name . '.';

            if (!$this->validate($rules, $errors)) {
                // handle validation erros
                $data['validation'] = $this->validator;
            } else {
                // logging in
                $model = new UserModel();
                $user = $model->where('email', $this->request->getVar('email'))
                    ->first();

                $this->setUserSession($user);

                session()->setFlashdata('success', 'Zalogowano pomyślnie!');
                return redirect()->to('dashboard');
            }
        }


        echo view('templates/header');
        echo view('auth_user/login', $data);
        echo view('templates/footer');
    }

    private function setUserSession($user)
    {

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

    public function register()
    {
        $data = [];
        helper(['form']);

        if ($this->request->getPost()) {
            //validations

            $rules = [
                'firstname' => 'required|min_length[' . $this->customConfig->firstname_min_length . ']|max_length[' . $this->customConfig->firstname_max_length . ']',
                'lastname' => 'required|min_length[' . $this->customConfig->lastname_min_length . ']|max_length[' . $this->customConfig->lastname_max_length . ']',
                'email' => 'required|min_length[' . $this->customConfig->email_min_length . ']|max_length[' . $this->customConfig->email_max_length . ']|valid_email|is_unique[user.email]', // CI will automatically check if this is unique in table.column
                'password' => 'required|min_length[' . $this->customConfig->password_min_length . ']|max_length[' . $this->customConfig->password_max_length . ']',
                'password_confirm' => 'matches[password]',
            ];

            if (!$this->validate($rules, $this->customConfig->user_validation_errors())) {
                // handle validation erros
                $data['validation'] = $this->validator;
            } else {
                // store user in the database
                $model = new UserModel();

                $newData = [
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                ];

                $model->save($newData);

                $session = session();
                // CodeIgniter supports “flashdata”, or session data that will only be available for the next request, and is then automatically cleared.
                $session->setFlashdata('success', 'Zarejestrowano pomyślnie!');
                return redirect()->to('/');
            }
        }


        echo view('templates/header');
        echo view('auth_user/register', $data);
        echo view('templates/footer');
    }

    public function logout()
    {
        session()->destroy();
        
        session()->setFlashdata('success', 'Wylogowano pomyślnie!');
        return redirect()->to('/');
    }

    // edit profile
    public function profile()
    {
        $data = [];
        helper(['form']);

        // inicialize model
        $model = new UserModel();


        if ($this->request->getPost()) {
            //validations
            $rules = [
                'firstname' => 'required|min_length[' . $this->customConfig->firstname_min_length . ']|max_length[' . $this->customConfig->firstname_max_length . ']',
                'lastname' => 'required|min_length[' . $this->customConfig->lastname_min_length . ']|max_length[' . $this->customConfig->lastname_max_length . ']',
            ]; //no email

            if ($this->request->getPost('password') != '' || $this->request->getPost('password_confirm') != '') {
                $rules['password'] = 'required|min_length[' . $this->customConfig->password_min_length . ']|max_length[' . $this->customConfig->password_max_length . ']';
                $rules['password_confirm'] = 'matches[password]';
            }

            if (!$this->validate($rules, $this->customConfig->user_validation_errors())) {
                // handle validation erros
                $data['validation'] = $this->validator;
            } else {
                // update  user in database

                $newData = [
                    'id' => session()->get('id'),
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                    // 'email' => $this->request->getVar('email'),
                ];
                if ($this->request->getPost('password') != '') {
                    $newData['password'] = $this->request->getPost('password');
                }

                $model->save($newData);

                // update session data
                $user = $model->where('email', session()->get('email'))
                    ->first();
                $this->setUserSession($user);

                // print_r($user);
                // return null;


                $session = session();
                $session->setFlashdata('success', 'Zapisano pomyślnie!');
                return redirect()->to('/profile');
            }
        }

        $data['user'] = $model->where('id', session()->get('id'))->first();
        echo view('templates/header', $data);
        echo view('auth_user/profile');
        echo view('templates/footer');
    }

    
}
