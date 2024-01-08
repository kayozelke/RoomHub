<?php 
namespace App\Validation;

use App\Models\RoomModel;

class RoomRules{

    public function is_unique_in_building(string $str, string $fields, array $data){
        $model = new RoomModel();
        $rooms_of_building = $model -> findWhereBuildingIdOrdered($fields, 'number');


        // print_r("--- <br>");
        // print_r($str);
        // print_r("<br> --- <br>");
        // print_r($fields);
        // print_r("<br> --- <br>");
        // print_r($data);
        // print_r("<br> --- <br> ");

        // print_r($rooms_of_building);
        // print_r("<br> ---");

        foreach($rooms_of_building as $row){
            // print_r("<br>");
            // print_r($row);
            if($row['number'] == $str) {
                return false;  
            }
        }
        
        return true;
    
      }
}


?>