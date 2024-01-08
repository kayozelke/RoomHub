<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Noauth implements FilterInterface
{
    // you have to type both before() and after() even if you dont use one of them

    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here

        if(session()->get('isLoggedIn'))
            return redirect()->to('/dashboard');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}