<?php

namespace App\Controller\Api;

use App\Controller\AppController;

class ServicesController extends AppController
{

    public function index()
    {
        return $this->response->withType('json')->withStringBody(json_encode(['User has previously enrolled']));
    }


    public function enroll()
    {
        return $this->response->withType('json')->withStringBody(json_encode(['User has previously enrolled']));
    }
    

    public function verify()
    {
        return "no_match";
    }
    public function is_duplicate()
    {
        return false;
    }
}
