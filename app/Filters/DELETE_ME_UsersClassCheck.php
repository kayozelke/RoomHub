<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UsersClassCheck implements FilterInterface
{
    // you have to type both before() and after() even if you dont use one of them

    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        // if segment 1 == users, then redirect to the second segment

        $uri = service('uri');
        if(strtolower($uri->getSegment(1)) == 'authcontroller'){
            if($uri->getSegment(2) == ''){
                $segment = '/';
            }
            else
                $segment = $uri->getSegment(2);
            return redirect()->to($segment);
        }
        // return redirect()->to('/');
        
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}