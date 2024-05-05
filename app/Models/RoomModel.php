<?php namespace App\Models;

use CodeIgniter\Model;


class RoomModel extends Model{
    protected $table = 'room';
    
    protected $primaryKey = 'id';

    protected $allowedFields = ['building_id', 'number', 'floor_eu', 'room_type_id'];

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



    // function join_building(){
    //     return $this -> db -> table ('room') 
    //                         // ->where('post_id >', 50)
    //                         // ->where('post_id <', 60)
    //                         ->join('building','room.building_id = building.id', 'inner') //inner is default
    //                         -> get()
    //                         -> getResultArray();
    // }
    function findByNumberWhereBuildingId($room_number, $building_id){
        return $this -> db -> table ('room') 
                            -> where('building_id =', $building_id)
                            -> where('number =', $room_number)
                            -> where ('room.deleted_at IS NULL') // IMPORTANT!
                            -> get()
                            -> getRowArray();
    }

    function findWhereBuildingIdOrdered($building_id, $select='*', $order='floor_eu DESC, number ASC'){
        return $this -> db -> table ('room') 
                            -> select($select)
                            -> where('building_id =', $building_id)
                            -> where ('room.deleted_at IS NULL') // IMPORTANT!
                            -> orderBy($order)
                            -> get()
                            -> getResultArray();
    }

    function findWhereBuildingIdJoinRoomTypeOrdered($building_id, $order='room.floor_eu ASC, room.number ASC') {
        return $this->db->table('room')
            ->select('room.id as room_id, room.building_id, room.number, room.floor_eu, room.room_type_id, room.created_at as room_created_at, room.updated_at as room_updated_at, room_type.id as room_type_id, room_type.name as room_type_name')
            ->where('room.building_id', $building_id)
            ->where ('room.deleted_at IS NULL') // IMPORTANT!
            ->join('room_type', 'room_type.id = room.room_type_id', 'inner')
            ->orderBy($order)
            ->get()
            ->getResultArray();
    }

    function findWhereBuildingIdJoinRoomTypeCustomSelect($building_id, $select, $order='room.number ASC') {
        return $this->db->table('room')
            ->select($select)
            ->where('room.building_id', $building_id)
            ->where ('room.deleted_at IS NULL') // IMPORTANT!
            ->join('room_type', 'room_type.id = room.room_type_id', 'inner')
            ->orderBy($order)
            ->get()
            ->getResultArray();
    }


    function findJoinSlots($id) {
        return $this->db->table('room')
            ->select('room.id as room_id, room.building_id, room.number, room.floor_eu, room.room_type_id, room.created_at as room_created_at, room.updated_at as room_updated_at, slot.id as slot_id, slot.name as slot_name, slot.room_id as slot_room_id, slot.room_building_id as slot_room_building_id')
            ->where('room.id', $id)
            ->where ('room.deleted_at IS NULL') // IMPORTANT!
            ->join('slot', 'room.id = slot.room_id', 'inner')
            ->get()
            ->getResultArray();
    }

    function findAllWhereBuildingJoinSlots($building_id, $select) {
        return $this->db->table('room')
            ->select($select)
            ->where('room.building_id', $building_id)
            ->where ('room.deleted_at IS NULL') // IMPORTANT!
            ->join('slot', 'room.id = slot.room_id', 'inner')
            ->get()
            ->getResultArray();
    }


    public function countRoomsInBuilding($buildingId) {
        $data = $this->db->table('room')
            ->selectCount('id')
            ->where ('room.deleted_at IS NULL') 
            ->where('building_id', $buildingId)
            ->groupBy('building_id')
            ->get()
            ->getRowArray();
        if(!$data)
            return 0;
        else
            return $data['id'];
        
    }

    public function findAllWhereRoomType($room_type_id) {
        return $this->db->table('room')
            ->where('room.room_type_id', $room_type_id)
            ->where ('room.deleted_at IS NULL') // IMPORTANT!
            ->get()
            ->getResultArray();
    }

    public function deleteWithSlots($id){
        
        $reservations_counter = (new ReservationModel())->getRoomReservationsNumber($id);

        if($reservations_counter > 0){
            return false;
        }

        $slot_model = new SlotModel();

        $slots = $slot_model -> findAllByRoomId($id, 'id');

        foreach ($slots as $slot_data){
            print_r($slot_data['id']); echo '<br>';
            $slot_model->delete($slot_data['id']);
        }
        $this->delete($id);
        return true;
    }
    
}



?>