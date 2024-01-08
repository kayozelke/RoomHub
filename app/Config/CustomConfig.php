<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class CustomConfig extends BaseConfig
{
    // usage 
    
    // $someConfig = new \Config\SomeConfig();
    // $fooMessage = $someConfig->foo;
    // $barMessage = $someConfig->bar;



    public $firstname_name = "imię" ;
        public $firstname_min_length = 3;
        public $firstname_max_length = 20;

    public $lastname_name = "nazwisko" ;
        public $lastname_min_length = 3;
        public $lastname_max_length = 30;
    
    public $email_name = "email" ;    
        public $email_min_length = 6;
        public $email_max_length = 50;
        
    public $password_name = "hasło" ;
        public $password_min_length = 8;
        public $password_max_length = 55;




    // in PHP you cannot initialize a static variable with another variable
    // thats why we are using function that returns data we would normally keep in the variable
    
    public function user_validation_errors() {
        return [
            'firstname' => [
                'required' => 'Pole "'.$this->firstname_name.'" jest wymagane.',
                'min_length' => ucfirst($this->firstname_name).' jest zbyt krótkie - użyj co najmniej '.$this->firstname_min_length.' znaków.',
                'max_length' => ucfirst($this->firstname_name).' jest zbyt długie - użyj maksymalnie '.$this->firstname_max_length.' znaków.'
            ],
            'lastname' => [
                'required' => 'Pole "'.$this->lastname_name.'" jest wymagane.',
                'min_length' => ucfirst($this->lastname_name).' jest zbyt krótkie - użyj co najmniej '.$this->lastname_min_length.' znaków.',
                'max_length' => ucfirst($this->lastname_name).' jest zbyt długie - użyj maksymalnie '.$this->lastname_max_length.' znaków.'
            ],
            'email' => [
                'required' => 'Pole "'.$this->email_name.'" jest wymagane.',
                'min_length' => ucfirst($this->email_name).' jest zbyt krótkie - użyj co najmniej '.$this->email_min_length.' znaków.',
                'max_length' => ucfirst($this->email_name).' jest zbyt długie - użyj maksymalnie '.$this->email_max_length.' znaków.',
                'valid_email' => 'Niepoprawny format adresu email.',
                'is_unique' => 'Ten adres email jest już zajęty.'
            ],
            'password' => [
                'required' => 'Pole "'.$this->password_name.'" jest wymagane.',
                'min_length' => ucfirst($this->password_name).' jest zbyt krótkie - użyj co najmniej '.$this->password_min_length.' znaków.',
                'max_length' => ucfirst($this->password_name).' jest zbyt długie - użyj maksymalnie '.$this->password_max_length.' znaków.'
            ],
            'password_confirm' => [
                'matches' => 'Podane hasła są różne!'
            ],
        ];
    }

    public function room_type_validation_errors(){
        return [
            'name' => [
                'required' => 'Nazwa jest wymagana!'
            ],
            'price_month' => [
                'required' => 'Pole czynszu nie może być puste!',
                'greater_than_equal_to' => 'Czynsz nie może być mniejszy od 0!',
            ],
            'max_residents' => [
                'required' => 'Pole liczby mieszkańców nie może być puste!',
                'greater_than_equal_to' => 'Liczba mieszkańców nie może być mniejsza od 0!',
            ],
        ];
    }

}