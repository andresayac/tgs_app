<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Branchs Controller
 *
 * @property \App\Model\Table\BranchsTable $Branchs
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BranchsController extends AppController
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
            'maxLimit' => 5000,
            'contain' => ['Companies'],
        ];


        $branchs = $this->paginate($this->Branchs);

        $this->set(compact('branchs'));
    }

    public function view($id = null)
    {
        $branch = $this->Branchs->get($id, [
            'contain' => ['Companies', 'Users'],
        ]);

        $this->set(compact('branch'));
    }

    public function add()
    {
        $branch = $this->Branchs->newEmptyEntity();
        if ($this->request->is('post')) {
            $branch = $this->Branchs->patchEntity($branch, $this->request->getData());
            if ($this->Branchs->save($branch)) {
                $this->Flash->success(__('La sucursal ha sido guardada.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La sucursal no se pudo guardar. Inténtalo de nuevo.'));
        }
        $companies = $this->Branchs->Companies->find('list', ['limit' => 200])->all();
        $this->set(compact('branch', 'companies'));
    }

    public function edit($id = null)
    {
        $branch = $this->Branchs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $branch = $this->Branchs->patchEntity($branch, $this->request->getData());
            if ($this->Branchs->save($branch)) {
                $this->Flash->success(__('La sucursal ha sido guardada.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La sucursal no se pudo guardar. Inténtalo de nuevo.'));
        }
        $companies = $this->Branchs->Companies->find('list', ['limit' => 200])->all();
        $this->set(compact('branch', 'companies'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $branch = $this->Branchs->get($id);
        if ($this->Branchs->delete($branch)) {
            $this->Flash->success(__('La sucursal ha sido eliminada.'));
        } else {
            $this->Flash->error(__('La sucursal no se pudo guardar. Inténtalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
