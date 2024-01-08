<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    // you have to type both before() and after() even if you dont use one of them

    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        // in case the user is not logged in

        if(!session()->get('isLoggedIn'))
            return redirect()->to('/');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}