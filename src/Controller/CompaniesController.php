<?php

declare(strict_types=1);

namespace App\Controller;

class CompaniesController extends AppController
{

    public function index()
    {
        $companies = $this->paginate($this->Companies);

        $this->set(compact('companies'));
    }

    public function view($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('company'));
    }

    public function add()
    {
        $company = $this->Companies->newEmptyEntity();
        if ($this->request->is('post')) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('La empresa se ha guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La empresa no se pudo guardar. Inténtalo de nuevo.'));
        }
        $this->set(compact('company'));
    }

    public function edit($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('La empresa se ha guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La empresa no se pudo guardar. Inténtalo de nuevo.'));
        }
        $this->set(compact('company'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $company = $this->Companies->get($id);
        if ($this->Companies->delete($company)) {
            $this->Flash->success(__('La empresa ha sido eliminada.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar la empresa. Inténtalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
