<?php namespace App\Models;

use CodeIgniter\Model;


class RoomTypeModel extends Model{
    protected $table = 'room_type';
    
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'price_month', 'max_residents'];

    protected $useSoftDeletes = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Callbacks
    // protected $beforeInsert = ['beforeInsert'];
    // protected $beforeUpdate = ['beforeUpdate'];


    
    // protected function beforeInsert(array $data){
    //     $data = $this->passwordHash($data);
    //     return $data;
    // }


    // protected function beforeUpdate(array $data){
    //     $data = $this->passwordHash($data);
    //     return $data;
    // }

    public function findAllOrdered($order_by="name", $order_how="ASC"){
        return $this -> db -> table ('room_type') 
            ->where ('room_type.deleted_at IS NULL') 
            -> orderBy($order_by, $order_how)
            // -----
            -> get()
            -> getResultArray();
    }
    
}



?>