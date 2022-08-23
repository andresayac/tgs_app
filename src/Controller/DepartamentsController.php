<?php

declare(strict_types=1);

namespace App\Controller;

class DepartamentsController extends AppController
{

    public function index()
    {
        $this->paginate = [
            'limit' => 5000,
            'maxLimit' => 5000
        ];

        $departaments = $this->paginate($this->Departaments);

        $this->set(compact('departaments'));
    }

    public function view($id = null)
    {
        $departament = $this->Departaments->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('departament'));
    }

    public function add()
    {
        $departament = $this->Departaments->newEmptyEntity();
        if ($this->request->is('post')) {
            $departament = $this->Departaments->patchEntity($departament, $this->request->getData());
            if ($this->Departaments->save($departament)) {
                $this->Flash->success(__('Area guardada con exito'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La Area no se pudo salvar. Inténtalo de nuevo.'));
        }
        $this->set(compact('departament'));
    }

    public function edit($id = null)
    {
        $departament = $this->Departaments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $departament = $this->Departaments->patchEntity($departament, $this->request->getData());
            if ($this->Departaments->save($departament)) {
                $this->Flash->success(__('Area guardada con exito'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La Area no se pudo salvar. Inténtalo de nuevo.'));
        }
        $this->set(compact('departament'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $departament = $this->Departaments->get($id);
        if ($this->Departaments->delete($departament)) {
            $this->Flash->success(__('Area eliminado con exito.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el Area. Inténtalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
