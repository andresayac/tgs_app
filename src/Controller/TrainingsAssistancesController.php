<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TrainingsAssistances Controller
 *
 * @property \App\Model\Table\TrainingsAssistancesTable $TrainingsAssistances
 * @method \App\Model\Entity\TrainingsAssistance[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrainingsAssistancesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Trainings', 'Users'],
        ];
        $trainingsAssistances = $this->paginate($this->TrainingsAssistances);

        $this->set(compact('trainingsAssistances'));
    }

    /**
     * View method
     *
     * @param string|null $id Trainings Assistance id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $trainingsAssistance = $this->TrainingsAssistances->get($id, [
            'contain' => ['Trainings', 'Users'],
        ]);

        $this->set(compact('trainingsAssistance'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $trainingsAssistance = $this->TrainingsAssistances->newEmptyEntity();
        if ($this->request->is('post')) {
            $trainingsAssistance = $this->TrainingsAssistances->patchEntity($trainingsAssistance, $this->request->getData());
            if ($this->TrainingsAssistances->save($trainingsAssistance)) {
                $this->Flash->success(__('The trainings assistance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The trainings assistance could not be saved. Please, try again.'));
        }
        $trainings = $this->TrainingsAssistances->Trainings->find('list', ['limit' => 200])->all();
        $users = $this->TrainingsAssistances->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('trainingsAssistance', 'trainings', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Trainings Assistance id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $trainingsAssistance = $this->TrainingsAssistances->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $trainingsAssistance = $this->TrainingsAssistances->patchEntity($trainingsAssistance, $this->request->getData());
            if ($this->TrainingsAssistances->save($trainingsAssistance)) {
                $this->Flash->success(__('The trainings assistance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The trainings assistance could not be saved. Please, try again.'));
        }
        $trainings = $this->TrainingsAssistances->Trainings->find('list', ['limit' => 200])->all();
        $users = $this->TrainingsAssistances->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('trainingsAssistance', 'trainings', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Trainings Assistance id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $trainingsAssistance = $this->TrainingsAssistances->get($id);
        if ($this->TrainingsAssistances->delete($trainingsAssistance)) {
            $this->Flash->success(__('The trainings assistance has been deleted.'));
        } else {
            $this->Flash->error(__('The trainings assistance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
