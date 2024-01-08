<?php

namespace App\Filters;

use App\Libraries\PrivilegesManager;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserModerator implements FilterInterface
{
    // you have to type both before() and after() even if you dont use one of them

    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
            
        if(session()->get('id')){
            $PrivilegesManagerObject = new PrivilegesManager();
            // check if current user is at least moderator (priveleges level >= 1)
            if(!$PrivilegesManagerObject->isUserModerator(session()->get('id'))){
                session()->setFlashdata('failure', 'Brak uprawnień!');
                return redirect()->back();
            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}