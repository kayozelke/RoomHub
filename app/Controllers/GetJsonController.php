<?php

namespace App\Controllers;

use App\Libraries\DateOperator;
use App\Models\RoomModel;
use App\Models\SlotModel;

class GetJsonController extends BaseController
{
    public function get_rooms_of_building($id){
        $model = new RoomModel();

        return $this->response->setJSON($model->findWhereBuildingIdJoinRoomTypeCustomSelect($id,  'room.number as room_number, room_type.name as room_type_name'));
        // return $this->response->setJSON($model->findWhereBuildingIdOrdered($id, 'number', 'number ASC'));
    }

    public function get_slots_of_room($id){
        $model = new SlotModel();

        return $this->response->setJSON($model->findAllByRoomId($id, 'id as slot_id, name, room_id'));
    }

    public function get_slots_by_room_number_by_building_id($building_id, $room_number){
        $room_model = new RoomModel();
        $slot_model = new SlotModel();

        $data = $room_model->findWhereBuildingIdOrdered($building_id);

        foreach($data as $row){
            if($row['number'] == $room_number){
                return $this->response->setJSON($slot_model->findAllByRoomId($row['id'], 'id as slot_id, name, room_id'));
            }
        }
        return $this->response->setJSON(null);
    }

    public function calculate_end_date($start_date, $months_count){

        $data = [
            'end_date' => (new DateOperator())->calculateEndDate($start_date,$months_count),
        ];

        return $this->response->setJSON($data);
    }


}
