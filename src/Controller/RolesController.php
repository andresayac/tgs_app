<?php
declare(strict_types=1);

namespace App\Controller;

class RolesController extends AppController
{
    public function index()
    {
        $roles = $this->paginate($this->Roles);

        $this->set(compact('roles'));
    }

    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('role'));
    }

    public function add()
    {
        $role = $this->Roles->newEmptyEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('El rol se ha guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar el rol. Inténtalo de nuevo.'));
        }
        $this->set(compact('role'));
    }

    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('El rol se ha guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar el rol. Inténtalo de nuevo.'));
        }
        $this->set(compact('role'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);
        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('El rol ha sido eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el rol. Inténtalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
