<?php 
namespace App\Validation;

use App\Models\UserModel;

class AuthRules{
    // public function validateUser (string $str, string $fields, $data){
    //     $model = new UserModel();
    //     $user = $model -> where('email', $data['email'])
    //                     -> first();

        
    //     print_r ($user);


    //     if(!$user){
    //         echo "<br> no user!";
    //         return false;
    //     }
    //     else{
    //         echo "<br> there is user!";
    //     }

    //     echo '<br>';
    //     print_r ("data['password'] =>". $data['password']."<=");

    //     echo '<br>';
    //     $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
    //     print_r ("password_hash( data[..]) =>". $hashed_password."<=");

    //     echo '<br>';
    //     print_r ("user['password'] =>". $user['password']."<=");

        
    //     echo '<br>';
    //     if ($hashed_password == $user['password']){
    //         print_r ("Test 1: True");
    //     } else print_r ("Test 1: False");


    //     echo '<br>';
    //     if (password_verify($data['password'], $user['password'])){
    //         print_r ("Test 2: True");
    //     } else print_r ("Test 2: False");
        
        
        
        
    //     return password_verify($data['password'], $user['password']);

    // }


    public function validateUser(string $str, string $fields, array $data){
        $model = new UserModel();
        $user = $model->where('email', $data['email'])
                      ->first();
    
        if(!$user)
          return false;
    
        return password_verify($data['password'], $user['password']);
      }
}


?>