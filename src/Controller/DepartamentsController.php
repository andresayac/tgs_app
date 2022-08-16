<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Departaments Controller
 *
 * @property \App\Model\Table\DepartamentsTable $Departaments
 * @method \App\Model\Entity\Departament[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DepartamentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $this->paginate = [
            'limit' => 5000,
            'maxLimit' => 5000
        ];


        $departaments = $this->paginate($this->Departaments);

        $this->set(compact('departaments'));
    }

    /**
     * View method
     *
     * @param string|null $id Departament id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $departament = $this->Departaments->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('departament'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $departament = $this->Departaments->newEmptyEntity();
        if ($this->request->is('post')) {
            $departament = $this->Departaments->patchEntity($departament, $this->request->getData());
            if ($this->Departaments->save($departament)) {
                $this->Flash->success(__('The departament has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The departament could not be saved. Please, try again.'));
        }
        $this->set(compact('departament'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Departament id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $departament = $this->Departaments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $departament = $this->Departaments->patchEntity($departament, $this->request->getData());
            if ($this->Departaments->save($departament)) {
                $this->Flash->success(__('The departament has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The departament could not be saved. Please, try again.'));
        }
        $this->set(compact('departament'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Departament id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $departament = $this->Departaments->get($id);
        if ($this->Departaments->delete($departament)) {
            $this->Flash->success(__('The departament has been deleted.'));
        } else {
            $this->Flash->error(__('The departament could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
