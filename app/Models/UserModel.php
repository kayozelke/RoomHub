<?php namespace App\Models;

use CodeIgniter\Model;


class UserModel extends Model{
    protected $table = 'user';
    
    protected $primaryKey = 'id';

    protected $allowedFields = ['firstname', 'lastname', 'email', 'password', 'privileges_level'];

    protected $useSoftDeletes = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Callbacks
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];





    protected function beforeInsert(array $data){
        $data = $this->passwordHash($data);
        return $data;
    }


    protected function beforeUpdate(array $data){
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function passwordHash(array $data){
        if(isset($data['data']['password']))
            // print_r("<br> data password before passwordHash =>".$data['data']['password']."<=");
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            // print_r("<br> data password before passwordHash =>".$data['data']['password']."<=");
        return $data;
    }

    public function findByEmail($email){
        return $this -> db -> table ('user') 
                            -> where('email =', $email)
                            -> where ('user.deleted_at IS NULL') // IMPORTANT!
                            -> get()
                            -> getRowArray();
    }


}



?>