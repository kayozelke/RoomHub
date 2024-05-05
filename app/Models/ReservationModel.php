<?php

namespace App\Models;

use App\Libraries\DateOperator;
use CodeIgniter\Model;


class ReservationModel extends Model
{
    protected $table = 'reservation';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'slot_id',
        'slot_room_id',
        'slot_room_building_id',
        'notes',
        'start_time',
        'end_time',
        'type',
        'price',
        'payment_done',
        'contract_number',
    ];


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


    // FINDS
    public function findAllWithDeletedOrdered($order = "end_time ASC")
    {
        return $this->db->table('reservation')
            ->orderBy($order)
            // -----
            ->get()
            ->getResultArray();
    }

    public function findAllWithDeletedJoinFullDataOrdered($order = "end_time ASC")
    {
        return $this->db->table('reservation')
            ->select('
                reservation.id as reservation_id,
                reservation.notes as reservation_notes,
                reservation.start_time as reservation_start_time,
                reservation.end_time as reservation_end_time,
                reservation.type as type,
                reservation.price as reservation_price,
                reservation.payment_done as reservation_payment_done,
                reservation.contract_number as reservation_contract_number,
                reservation.created_at as reservation_created_at,
                reservation.updated_at as reservation_updated_at,
                reservation.deleted_at as reservation_deleted_at,
                user.id as user_id,
                user.email as user_email,
                user.firstname as user_firstname,
                user.lastname as user_lastname,
                slot.id as slot_id,
                slot.name as slot_name,
                room.id as room_id,
                room.number as room_number,
                building.id as building_id,
                building.name as building_name,
                ')
            ->join('user', 'user.id = reservation.user_id')
            ->join('slot', 'slot.id = reservation.slot_id')
            ->join('room', 'room.id = reservation.slot_room_id')
            ->join('building', 'building.id = reservation.slot_room_building_id')
            ->orderBy($order)
            // -----
            ->get()
            ->getResultArray();
    }

    public function findAllJoinFullDataOrdered($order = "end_time ASC")
    {
        return $this->db->table('reservation')
            ->select('
                    reservation.id as reservation_id,
                    reservation.notes as reservation_notes,
                    reservation.start_time as reservation_start_time,
                    reservation.end_time as reservation_end_time,
                    reservation.type as type,
                    reservation.price as reservation_price,
                    reservation.payment_done as reservation_payment_done,
                    reservation.contract_number as reservation_contract_number,
                    reservation.created_at as reservation_created_at,
                    reservation.updated_at as reservation_updated_at,
                    reservation.deleted_at as reservation_deleted_at,
                    user.id as user_id,
                    user.email as user_email,
                    user.firstname as user_firstname,
                    user.lastname as user_lastname,
                    slot.id as slot_id,
                    slot.name as slot_name,
                    room.id as room_id,
                    room.number as room_number,
                    building.id as building_id,
                    building.name as building_name,
                    ')
            ->where('reservation.deleted_at IS NULL') // IMPORTANT!
            ->join('user', 'user.id = reservation.user_id')
            ->join('slot', 'slot.id = reservation.slot_id')
            ->join('room', 'room.id = reservation.slot_room_id')
            ->join('building', 'building.id = reservation.slot_room_building_id')
            ->orderBy($order)
            ->get()
            ->getResultArray();




        // return $this->db->table('room')
        //     ->select('room.id as room_id, room.building_id, room.number, room.floor_eu, room.room_type_id, room.created_at as room_created_at, room.updated_at as room_updated_at, room_type.id as room_type_id, room_type.name as room_type_name')
        //     ->where('room.building_id', $building_id)
        //     ->join('room_type', 'room_type.id = room.room_type_id', 'inner')
        //     ->orderBy('room.floor_eu ASC, room.number ASC')
        //     ->get()
        //     ->getResultArray();
    }

    public function findAllWhereSlotJoinFullDataOrdered($slot_id, $order = "end_time ASC")
    {
        return $this->db->table('reservation')
            ->select('
                        reservation.id as reservation_id,
                        reservation.notes as reservation_notes,
                        reservation.start_time as reservation_start_time,
                        reservation.end_time as reservation_end_time,
                        reservation.type as type,
                        reservation.price as reservation_price,
                        reservation.payment_done as reservation_payment_done,
                        reservation.contract_number as reservation_contract_number,
                        reservation.created_at as reservation_created_at,
                        reservation.updated_at as reservation_updated_at,
                        reservation.deleted_at as reservation_deleted_at,
                        user.id as user_id,
                        user.email as user_email,
                        user.firstname as user_firstname,
                        user.lastname as user_lastname,
                        slot.id as slot_id,
                        slot.name as slot_name,
                        room.id as room_id,
                        room.number as room_number,
                        building.id as building_id,
                        building.name as building_name,
                    ')
            ->where('reservation.slot_id = ' . $slot_id)
            ->where('reservation.deleted_at IS NULL') // IMPORTANT!
            ->join('user', 'user.id = reservation.user_id')
            ->join('slot', 'slot.id = reservation.slot_id')
            ->join('room', 'room.id = reservation.slot_room_id')
            ->join('building', 'building.id = reservation.slot_room_building_id')
            ->orderBy($order)
            ->get()
            ->getResultArray();
    }

    public function findAllWhereUserJoinFullDataOrdered($user_id, $order = "end_time ASC")
    {
        return $this->db->table('reservation')
            ->select('
                        reservation.id as reservation_id,
                        reservation.notes as reservation_notes,
                        reservation.start_time as reservation_start_time,
                        reservation.end_time as reservation_end_time,
                        reservation.type as type,
                        reservation.price as reservation_price,
                        reservation.payment_done as reservation_payment_done,
                        reservation.contract_number as reservation_contract_number,
                        reservation.created_at as reservation_created_at,
                        reservation.updated_at as reservation_updated_at,
                        reservation.deleted_at as reservation_deleted_at,
                        user.id as user_id,
                        user.email as user_email,
                        user.firstname as user_firstname,
                        user.lastname as user_lastname,
                        slot.id as slot_id,
                        slot.name as slot_name,
                        room.id as room_id,
                        room.number as room_number,
                        building.id as building_id,
                        building.name as building_name,
                    ')
            ->where('reservation.user_id = ' . $user_id)
            ->where('reservation.deleted_at IS NULL') // IMPORTANT!
            ->join('user', 'user.id = reservation.user_id')
            ->join('slot', 'slot.id = reservation.slot_id')
            ->join('room', 'room.id = reservation.slot_room_id')
            ->join('building', 'building.id = reservation.slot_room_building_id')
            ->orderBy($order)
            ->get()
            ->getResultArray();
    }

    public function findAllWhereUserEmailJoinFullDataOrdered($user_email, $order = "end_time ASC")
    {

        return $this->db->table('reservation')
            ->select('
                        reservation.id as reservation_id,
                        reservation.notes as reservation_notes,
                        reservation.start_time as reservation_start_time,
                        reservation.end_time as reservation_end_time,
                        reservation.type as type,
                        reservation.price as reservation_price,
                        reservation.payment_done as reservation_payment_done,
                        reservation.contract_number as reservation_contract_number,
                        reservation.created_at as reservation_created_at,
                        reservation.updated_at as reservation_updated_at,
                        reservation.deleted_at as reservation_deleted_at,
                        user.id as user_id,
                        user.email as user_email,
                        user.firstname as user_firstname,
                        user.lastname as user_lastname,
                        slot.id as slot_id,
                        slot.name as slot_name,
                        room.id as room_id,
                        room.number as room_number,
                        building.id as building_id,
                        building.name as building_name,
                    ')
            ->where('user.email = "' . $user_email . '"')
            ->where('reservation.deleted_at IS NULL') // IMPORTANT!
            ->join('user', 'user.id = reservation.user_id')
            ->join('slot', 'slot.id = reservation.slot_id')
            ->join('room', 'room.id = reservation.slot_room_id')
            ->join('building', 'building.id = reservation.slot_room_building_id')
            ->orderBy($order)
            ->get()
            ->getResultArray();
    }

    public function findAllWhereUserEmailJoinFullDataOrderedWithDeleted($user_email, $order = "end_time ASC")
    {

        return $this->db->table('reservation')
            ->select('
                        reservation.id as reservation_id,
                        reservation.notes as reservation_notes,
                        reservation.start_time as reservation_start_time,
                        reservation.end_time as reservation_end_time,
                        reservation.type as type,
                        reservation.price as reservation_price,
                        reservation.payment_done as reservation_payment_done,
                        reservation.contract_number as reservation_contract_number,
                        reservation.created_at as reservation_created_at,
                        reservation.updated_at as reservation_updated_at,
                        reservation.deleted_at as reservation_deleted_at,
                        user.id as user_id,
                        user.email as user_email,
                        user.firstname as user_firstname,
                        user.lastname as user_lastname,
                        slot.id as slot_id,
                        slot.name as slot_name,
                        room.id as room_id,
                        room.number as room_number,
                        building.id as building_id,
                        building.name as building_name,
                    ')
            ->where('user.email = "' . $user_email . '"')
            // ->where('reservation.deleted_at IS NULL') // IMPORTANT!
            ->join('user', 'user.id = reservation.user_id')
            ->join('slot', 'slot.id = reservation.slot_id')
            ->join('room', 'room.id = reservation.slot_room_id')
            ->join('building', 'building.id = reservation.slot_room_building_id')
            ->orderBy($order)
            ->get()
            ->getResultArray();
    }

    public function findReservationsQuery($reservation_id = null, $user_email = null, $building_id = null, $room_number = null, 
    $start_date = null, $end_date = null, $payment_done = null, $include_deleted = false, $order = "end_time ASC"){
        echo 'TEST<br>';
        $query = $this->db->table('reservation')
            ->select('
                        reservation.id as reservation_id,
                        reservation.notes as reservation_notes,
                        reservation.start_time as reservation_start_time,
                        reservation.end_time as reservation_end_time,
                        reservation.type as type,
                        reservation.price as reservation_price,
                        reservation.payment_done as reservation_payment_done,
                        reservation.contract_number as reservation_contract_number,
                        reservation.created_at as reservation_created_at,
                        reservation.updated_at as reservation_updated_at,
                        reservation.deleted_at as reservation_deleted_at,
                        user.id as user_id,
                        user.email as user_email,
                        user.firstname as user_firstname,
                        user.lastname as user_lastname,
                        slot.id as slot_id,
                        slot.name as slot_name,
                        room.id as room_id,
                        room.number as room_number,
                        building.id as building_id,
                        building.name as building_name,
                    ')
            ->join('user', 'user.id = reservation.user_id')
            ->join('slot', 'slot.id = reservation.slot_id')
            ->join('room', 'room.id = reservation.slot_room_id')
            ->join('building', 'building.id = reservation.slot_room_building_id')
            ->orderBy($order);

        if($include_deleted == false) {
            // echo "include_deleted = $include_deleted";
            $query->where('reservation.deleted_at IS NULL');
        }
        // by id
        if($reservation_id){
            // echo "reservation_id = $reservation_id <br>";
            $query->where('reservation.id = ' . $reservation_id);
        }
        if($user_email){
            // echo "user_email = $user_email <br>";
            $query->where('user.email = "' . $user_email . '"');
        }
        if($building_id){
            // echo "building_id = $building_id <br>";
            $query->where('building.id = ' . $building_id);
        }
        // by room_number (part containing)
        if($room_number){
            // echo "room_number LIKE %$room_number% <br>";
            $query->where('room.number LIKE "%' . $room_number . '%"');
        }
        
        if($payment_done || $payment_done == 0){
            // echo "payment_done = $payment_done <br>";
            $query->where('reservation.payment_done = ' . $payment_done);
        }
        
        // filter by dates
        if($start_date){
            echo "where('reservation.end_time (actually a start) >= ' . $start_date)" ;
            $query->where('reservation.end_time >= "' . $start_date . '"');
        }
        if($end_date){
            echo "where('reservation.start_time (actually the end) <= ' . $end_date)" ;
            $query->where('reservation.start_time <= "' . $end_date . '"');
        }


        return $query->get()->getResultArray();

    }

    public function findJoinFullDataOrdered($reservation_id)
    {
        return $this->db->table('reservation')
            ->select('
                    reservation.id as reservation_id,
                    reservation.notes as reservation_notes,
                    reservation.start_time as reservation_start_time,
                    reservation.end_time as reservation_end_time,
                    reservation.type as type,
                    reservation.price as reservation_price,
                    reservation.payment_done as reservation_payment_done,
                    reservation.contract_number as reservation_contract_number,
                    reservation.created_at as reservation_created_at,
                    reservation.updated_at as reservation_updated_at,
                    reservation.deleted_at as reservation_deleted_at,
                    user.id as user_id,
                    user.email as user_email,
                    user.firstname as user_firstname,
                    user.lastname as user_lastname,
                    slot.id as slot_id,
                    slot.name as slot_name,
                    room.id as room_id,
                    room.number as room_number,
                    building.id as building_id,
                    building.name as building_name,
                ')
            ->where('reservation.id = ' . $reservation_id)
            ->where('reservation.deleted_at IS NULL') // IMPORTANT!
            ->join('user', 'user.id = reservation.user_id')
            ->join('slot', 'slot.id = reservation.slot_id')
            ->join('room', 'room.id = reservation.slot_room_id')
            ->join('building', 'building.id = reservation.slot_room_building_id')
            ->get()
            ->getRowArray();
    }
    // INPUT FILTERING
    public function filterFullReservationsDataByDatesRange($reservations_joined_full_data, $f_start_date = null, $f_end_date = null)
    {

        $dateOperator = new DateOperator();
        $filteredData = [];
        foreach ($reservations_joined_full_data as $item) {

            // if start filter && end filter

            /*    ORDER VISUALISATION (only properly ordered dates)

                        filter_s --- start_dt --- f_end_date --- filter_e     OK

                        filter_s --- start_dt --- filter_e --- f_end_date     OK

                        filter_s --- filter_e --- start_dt --- f_end_date     SKIP

                        start_dt --- filter_s --- f_end_date --- filter_e     OK

                        start_dt --- filter_s --- filter_e --- f_end_date     OK

                        start_dt --- f_end_date --- filter_s --- filter_e     SKIP

            */


            if ($f_start_date && $f_end_date) {

                if (!$dateOperator->isDateOrderProper($f_start_date, $f_end_date)) {
                    // TODO - redo with flash data
                    // return $this->filtering("Data zakończenia nie może poprzedzać daty początkowej!");
                    return [];
                }
                ////////////////////////////////////////////////////
                // echo '<br>';
                // echo ('f_end_date').' < '.('reservation_start_time').'<br>';
                // echo ($f_end_date).' < '.($item['reservation_start_time']).'<br>';
                // echo (strtotime($f_end_date)).' < '.strtotime($item['reservation_start_time']).'<br>';

                if (strtotime($f_end_date) < strtotime($item['reservation_start_time'])) {
                    // echo $f_end_date." is younger than ".$item['reservation_start_time']." so SKIP <br>";
                    continue;
                } else {
                    // echo 'not matched! <br>';
                }
                /////////////////////////////////////////////////////
                // echo '<br>';
                // echo ('reservation_end_time').' < '.('f_start_date').'<br>';
                // echo (strtotime($item['reservation_end_time'])).'  < '.strtotime($f_start_date).'<br>';
                // echo ($item['reservation_end_time']).' < '.($f_start_date).'<br>';

                if (strtotime($item['reservation_end_time']) < strtotime($f_start_date)) {
                    // echo $item['reservation_end_time']." is younger than ".$f_start_date." so SKIP <br>";
                    continue;
                } else {
                    // echo 'not matched! <br>';
                }
            } else {
                if ($f_start_date) {
                    if (strtotime($f_start_date) > strtotime($item['reservation_end_time'])) {
                        // echo $f_start_date." is younger than ".$item['reservation_end_time']." so SKIP <br>";
                        continue;
                    }
                }
                if ($f_end_date) {
                    if (strtotime($f_end_date) < strtotime($item['reservation_start_time'])) {
                        // echo $f_end_date." is older than ".$item['reservation_start_time']." so SKIP <br>";
                        continue;
                    }
                }
            }

            array_push($filteredData, $item);
        }

        return $filteredData;
    }


    public function filterFullReservationsDataByPayment($reservations_joined_full_data, bool $payment_done)
    {

        $filteredData = [];
        foreach ($reservations_joined_full_data as $item) {

            if ($item['reservation_payment_done'] == $payment_done) {
                array_push($filteredData, $item);
            }
        }

        return $filteredData;
    }

    public function filterFullReservationsDataByFieldValue($reservations_joined_full_data, string $fieldName, $fieldValue, bool $contain = false)
    {

        $filteredData = [];
        foreach ($reservations_joined_full_data as $item) {
            if ($contain) {
                if(str_contains($item[$fieldName], $fieldValue)){
                    array_push($filteredData, $item);
                }
            } else {
                if ($item[$fieldName] == $fieldValue) {
                    array_push($filteredData, $item);
                }
            }
        }

        return $filteredData;
    }



    // CHECKS and special

    public function getRoomReservationsNumber($room_id)
    {
        $data = $this->db->table('reservation')
            ->select('count(reservation.id) as counter')
            ->where('reservation.slot_room_id =' . $room_id)
            ->where('reservation.deleted_at IS NULL') // IMPORTANT!
            ->get()
            ->getRowArray();

        if (!$data)
            return 0;
        else
            return $data['counter'];
    }

    public function getNewContractNumber()
    {
        $data = $this->db->table('reservation')
            ->select('max(contract_number) as max_contract_number')
            // not using it here
            // -> where ('reservation.deleted_at IS NULL') 
            ->get()
            ->getRowArray();

        if (!$data)
            return 1;
        else
            return $data['max_contract_number'] + 1;
    }

    public function isSlotFreeAtDay($reservations_joined_full_data, $date_str, $slot_id = null)
    {
        $data = $this->filterFullReservationsDataByDatesRange($reservations_joined_full_data, f_start_date: $date_str, f_end_date: $date_str);
        if ($data) return false;
        else return true;
    }

    public function findNextStartDateOfSlotInReservations($reservations_joined_full_data, $slot_id = null, $after_date_str = null)
    {
        if (!$after_date_str) {
            $after_date_str = date('Y-m-d');
        }

        $reservations_joined_full_data = $this->filterFullReservationsDataByDatesRange($reservations_joined_full_data, $after_date_str);
        if (!$reservations_joined_full_data) {
            return null;
        } else return $reservations_joined_full_data[0]['reservation_start_time'];
    }

    public function findNextEndDateOfSlotInReservations($reservations_joined_full_data, $slot_id = null, $after_date_str = null)
    {
        if (!$after_date_str) {
            $after_date_str = date('Y-m-d');
        }
        $reservations_joined_full_data = $this->filterFullReservationsDataByDatesRange($reservations_joined_full_data, $after_date_str);

        $dateOperator = new DateOperator;

        $firstLoop = true;
        $previous_end_date = $after_date_str;
        foreach ($reservations_joined_full_data as $reservation) {
            if ($firstLoop) {
                $previous_end_date = $reservation['reservation_end_time'];
                $firstLoop = false;
                continue;
            }
            if (!$dateOperator->checkIfTwoDaysAreNeighbours($previous_end_date, $reservation['reservation_start_time'])) {
                return $previous_end_date;
            }
            $previous_end_date = $reservation['reservation_end_time'];

            // echo '<br>'; 
            // print_r($reservation['reservation_end_time']);
        }

        return $previous_end_date;
    }

    public function addColumnReservationStatus($data, $start_time_column = 'reservation_start_time', $end_time_column = 'reservation_end_time', $status_column = 'reservation_status'){
        // 0 - ended
        // 1 - active
        // 2 - unstarted
        $newData = [];
        $dateOperator = new DateOperator();
        $today = date('Y-m-d');
        foreach ($data as $row){
            // if our date is same as start or end date, return active
            if($today == $row[$start_time_column] || $today == $row[$end_time_column]){
                $row[$status_column] = 1;
            } else {
            // check other possibilities

                // if TODAY < START, then it is unstarted
                if ($dateOperator->isDateOrderProper($today,$row[$start_time_column])) {
                    // unstarted
                    $row[$status_column] = 2;
                }
                
                // if END < TODAY, then it has been ended
                else if ($dateOperator->isDateOrderProper($row[$end_time_column], $today)) {
                    // ended
                    $row[$status_column] = 0;
                }
                
                // the only left possibility is START < TODAY < END
                else {
                    // active
                    $row[$status_column] = 1;
                }
            }
            
            
            array_push($newData,$row);
        }
        return $newData;
    }
}
