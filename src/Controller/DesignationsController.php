<?php
declare(strict_types=1);

namespace App\Controller;

class DesignationsController extends AppController
{

    public function index()
    {
        $this->paginate = [
            'limit' => 5000,
            'maxLimit' => 5000
        ];
        $designations = $this->paginate($this->Designations);

        $this->set(compact('designations'));
    }

    public function view($id = null)
    {
        $designation = $this->Designations->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('designation'));
    }

    public function add()
    {
        $designation = $this->Designations->newEmptyEntity();
        if ($this->request->is('post')) {
            $designation = $this->Designations->patchEntity($designation, $this->request->getData());
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('El cargo se ha guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar el cargo. Inténtalo de nuevo.'));
        }
        $this->set(compact('designation'));
    }

    public function edit($id = null)
    {
        $designation = $this->Designations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $designation = $this->Designations->patchEntity($designation, $this->request->getData());
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('El cargo se ha guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar el cargo. Inténtalo de nuevo.'));
        }
        $this->set(compact('designation'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $designation = $this->Designations->get($id);
        if ($this->Designations->delete($designation)) {
            $this->Flash->success(__('El cargo ha sido eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el cargo. Inténtalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
