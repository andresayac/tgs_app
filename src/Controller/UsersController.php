<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles', 'Departaments', 'Branchs', 'Designations'],
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Departaments', 'Branchs', 'Designations'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();
        $departaments = $this->Users->Departaments->find('list', ['limit' => 200])->all();
        $branchs = $this->Users->Branchs->find('list', ['limit' => 200])->all();
        $designations = $this->Users->Designations->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'roles', 'departaments', 'branchs', 'designations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $data = $this->request->getData();

            $user = $this->Users->patchEntity($user, $data);

            if (empty($data['password'])) unset($user->password);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();
        $departaments = $this->Users->Departaments->find('list', ['limit' => 200])->all();
        $branchs = $this->Users->Branchs->find('list', ['limit' => 200])->all();
        $designations = $this->Users->Designations->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'roles', 'departaments', 'branchs', 'designations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }



    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('add');
    }

    public function login()
    {
        $this->viewBuilder()->disableAutoLayout();

        
        if (!empty($this->Auth->user())) {
            // redirecicon inicial basado en rol
            $Roles = $this->getTableLocator()->get('Roles');
            $rol_info = $Roles->get($this->Auth->user('rol_id'))->toArray();

            if (!empty($rol_info['home_page'])) {
                $home_controller = explode('/', $rol_info['home_page'])[0];
                $home_action = explode('/', $rol_info['home_page'])[1];
                return $this->redirect(['controller' => $home_controller, 'action' => $home_action]);
            }
            return $this->redirect($this->Auth->redirectUrl());
        }


        if ($this->request->is('post')) {
            if ($this->Auth->identify()) {

                $this->Auth->setUser($this->Auth->identify());
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Usuario o contraseña invalidos.'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
