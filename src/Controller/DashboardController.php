<?php



namespace App\Controller;

use App\Controller\AppController;


class DashboardController extends AppController
{


    public function index()
    {
        $Users = $this->getTableLocator()->get('Users');

        $all_data = $Users->find()->select(['indexfinger', 'middlefinger']);

        $this->set(compact('all_data'));
    }
}
