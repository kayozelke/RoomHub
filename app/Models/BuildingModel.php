<?php namespace App\Models;

use CodeIgniter\Model;


class BuildingModel extends Model{
    protected $table = 'building';
    
    protected $primaryKey = 'id';

    protected $allowedFields = ['address', 'name', 'description'];

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
    public function findAllOrdered($order="name ASC"){
        return $this -> db -> table ('building') 
            -> orderBy($order)
            // -----
            -> where ('building.deleted_at IS NULL') // IMPORTANT!
            -> get()
            -> getResultArray();
    }
    // does the same what find() does
    
    // public function get_building_by_id($id){
    //     return $this -> db -> table ('building') 
    //         -> where(['id = ' => $id])
    //         // -----
    //         -> get()
    //         -> getRowArray();
    // }

    // public function findAllByBuildingId($id, $order = ''){
    //     return $this -> db -> table ('building') 
    //         -> where(['building.id = ' => $id])
    //         // -> join('room','room.building_id = building.id', 'inner') //inner is default
    //         -> orderBy($order)
    //         // -----
    //         -> get()
    //         -> getResultArray();
    // }
}



?>