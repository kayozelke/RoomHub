<?php

namespace App\Libraries;

use App\Models\UserModel;

class PrivilegesManager
{

    private $user_model;

    function __construct()
    {
        // print "In BaseClass constructor\n";
        $this->user_model = new UserModel();
    }

    public function levelToNameStr($id): string {
        switch ($id) {
            case 0:
                return "Użytkownik";
            case 1:
                return "Moderator";
            // case 2:
            //     return "Administrator";
            default:
                return "Undefined level - ".$id;
        }
    }

    public function isUserModerator($id): bool
    {
        $userData = $this->user_model->find(($id));

        if (!$userData)
            return false;

        if ($userData['privileges_level'] >= 1)
            return true;
        else
            return false;
    }

    public function setPrivilegesLevel($user_id, $level)
    {
        $userData = $this->user_model->find(($user_id));
        if ($userData && $level >= 0) {
            $userData = [];
            $userData['id'] = $user_id;
            $userData['privileges_level'] = $level;
            $this->user_model->save($userData);
            session()->setFlashdata('success', 'Pomyślnie zmieniono uprawnienia!');
        }


        if($user_id == session()->get('id')){
            session()->destroy();
            session()->setFlashdata('success', 'Zaloguj się ponownie!');
            
            redirect()->to('/');
        }
    }



}
