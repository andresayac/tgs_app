<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Routing\Route\Route;
use Muffin\Footprint\Auth\FootprintAwareTrait;
use Cake\Routing\Router;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // $this->loadComponent('RequestHandler');
        // $this->loadComponent('Flash');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginRedirect' => [
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'authError' => 'No tiene autorización para esta acción.',
        ]);


        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->request->addDetector('ssl', array(
            'env' => 'HTTP_X_FORWARDED_PROTO',
            'value' => 'https'
        ));

        // var for all views
        $this->set('_app_name_', Configure::read('app_name'));

        // add rol to user logged
        if (!empty($this->Auth->user())) {
            if (empty($this->Auth->user('rol_id'))) {
                $user_c = $this->Auth->user();
                $Roles = $this->getTableLocator()->get('Roles');
                $user_c['rol_id'] = $Roles->get($this->Auth->user('rol_id'))->toArray();
                $this->Auth->setUser($user_c);
            }
        }

        $this->set('_logged_user_', $this->Auth->user());
    }


    public function isAuthorized($user)
    {
        // Admin can access every action
        if (isset($user['rol_id']) && $user['rol_id'] === '1') {
            return true;
        }


        // by pass acciones del sistema
        $funciones_sistema = [
            'getCalendarioEvents', // controlles con gestion imagenes
            'attendanceSave', // eventos controller
            'attendanceDelete', // eventos controller
            'calendar',  // eventos controller
            'verify',
            'enroll'
        ];

        if (in_array($this->request->getParam('action'), $funciones_sistema))
            return true;
        // permisions from db
        $RolesPermisos = $this->getTableLocator()->get('RolesPermisos');
        $permisos_bruto = $RolesPermisos->find('all')
            ->where([
                'roles LIKE' => '%' . $user['rol_id'] . '%'
            ])->toArray();


        $permisos_refinado = [];
        $_permisos_users = [];
        foreach ($permisos_bruto as $key => $value) {
            if (in_array($user['rol_id'], explode(',', $value->roles))) {
                $permisos_refinado[] = $value;

                $_permisos_users[$value->modulo_padre][$value->modulo_hijo]=$value->modulo_hijo;
            }
        }

        $this->set('_permisos_user_', $_permisos_users);

        // users without permisions force to exit
        if (empty($permisos_refinado)) {
            $session = $this->request->getSession();
            $session->destroy();
            $this->Flash->error($this->Auth->getConfig('authError'));
            header("Location: " . Router::url('/', true));
            die();
        }



        // users autorized for controller and action are allowed
        foreach ($permisos_refinado as $key => $value) {
            if (
                $value->modulo_padre == strtolower($this->request->getParam('controller'))
                && $value->modulo_hijo == strtolower($this->request->getParam('action'))
            ) {
                array_push($_permisos_users, [$value->modulo_padre, $value->modulo_hijo]);
                return true;
            }
        }




        // if redirect is present un url reset auth redirect
        $this->Auth->setConfig('unauthorizedRedirect', true);
        if (strpos($this->request->referer(), '?redirect=') !== false) {
            $this->Auth->setConfig('unauthorizedRedirect', $this->Auth->getConfig('loginRedirect'));
        }



        return false;
    }

    public function returnJsonOk($data)
    {
        return $this->response->withType('json')
            ->withStatus(200)
            ->withStringBody(json_encode(['data' => $data], JSON_PARTIAL_OUTPUT_ON_ERROR));
    }
}
