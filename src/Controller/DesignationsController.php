<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Designations Controller
 *
 * @property \App\Model\Table\DesignationsTable $Designations
 * @method \App\Model\Entity\Designation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DesignationsController extends AppController
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
        $designations = $this->paginate($this->Designations);

        $this->set(compact('designations'));
    }

    /**
     * View method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $designation = $this->Designations->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('designation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $designation = $this->Designations->newEmptyEntity();
        if ($this->request->is('post')) {
            $designation = $this->Designations->patchEntity($designation, $this->request->getData());
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('The designation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The designation could not be saved. Please, try again.'));
        }
        $this->set(compact('designation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $designation = $this->Designations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $designation = $this->Designations->patchEntity($designation, $this->request->getData());
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('The designation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The designation could not be saved. Please, try again.'));
        }
        $this->set(compact('designation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $designation = $this->Designations->get($id);
        if ($this->Designations->delete($designation)) {
            $this->Flash->success(__('The designation has been deleted.'));
        } else {
            $this->Flash->error(__('The designation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
