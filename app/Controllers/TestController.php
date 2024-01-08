<?php

namespace App\Controllers;

class TestController extends BaseController
{
    public function index()
    {
        echo view('test.php');
    }

    public function test_get_some_data(){
        $inputValue = $this->request->getPost('inputValue');

        // Tutaj umieść logikę pobierania danych z bazy danych na podstawie $inputValue
    
        // Przykładowa odpowiedź AJAX (załóżmy, że rooms to tablica z danymi o pokojach)
        $rooms = [
            ['id' => 12, 'name' => 'Pokój 1'],
            ['id' => 23, 'name' => 'Pokój 2'],
        ];
    
        return $this->response->setJSON($rooms);
    }


}
