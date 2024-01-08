<?php namespace App\Models;

use CodeIgniter\Model;


class SlotModel extends Model{
    protected $table = 'slot';
    
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'room_id', 'room_building_id'];

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

    // public function findAllByRoomId($room_id, $order = ''){
    //     return $this -> db -> table ('slot') 
    //                         ->where('room_id =', $room_id)
    //                         -> orderBy($order)
    //                         -> get()
    //                         -> getResultArray();
    // }
    public function findAllByRoomId($room_id, $select = '*', $order = ''){
        return $this -> db -> table ('slot') 
                            -> select($select)
                            -> where('room_id =', $room_id)
                            -> where ('slot.deleted_at IS NULL') // IMPORTANT!
                            -> orderBy($order)
                            -> get()
                            -> getResultArray();
    }
    
}



?>