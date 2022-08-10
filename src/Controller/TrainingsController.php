<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Trainings Controller
 *
 * @property \App\Model\Table\TrainingsTable $Trainings
 * @method \App\Model\Entity\Training[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrainingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $Users = $this->getTableLocator()->get('Users');
        $users =  json_decode(json_encode($Users->find()->select(['document', 'name', 'lastname'])->toArray()), true);

        $trainings = $this->paginate($this->Trainings);

        $this->set(compact('trainings', 'users'));
    }

    /**
     * View method
     *
     * @param string|null $id Training id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $training = $this->Trainings->get($id, [
            'contain' => ['TrainingsAssistances'],
        ]);

        $this->set(compact('training'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $Users = $this->getTableLocator()->get('Users');

        $users =  json_decode(json_encode($Users->find()->select(['document', 'name', 'lastname'])->toArray()), true);

        $training = $this->Trainings->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $date_training = $data['start_date'];

            $data['start_date'] =   $date_training . " " . $data['start_hour'];
            $data['end_date']   =   $date_training . " " . $data['end_hour'];

            $data['trainer'] = implode(',', $data['trainer']);

            $training = $this->Trainings->patchEntity($training, $data);
            $training->created_by = $this->Auth->user('id');

            if ($this->Trainings->save($training)) {
                $this->Flash->success(__('La capacitación se ha creado con exito'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar la capacitación. Inténtalo de nuevo.'));
        }
        $this->set(compact('training',  'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Training id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $Users = $this->getTableLocator()->get('Users');

        $users =  json_decode(json_encode($Users->find()->select(['document', 'name', 'lastname'])->toArray()), true);


        $training = $this->Trainings->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $date_training = $data['start_date'];
            $data['start_date'] =   $date_training . " " . $data['start_hour'];
            $data['end_date']   =   $date_training . " " . $data['end_hour'];

            $data['trainer'] = implode(',', $data['trainer']);
            $data['modified_by'] =  $this->Auth->user('id');

            $training = $this->Trainings->patchEntity($training, $data);

            if ($this->Trainings->save($training)) {
                $this->Flash->success(__('The training has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The training could not be saved. Please, try again.'));
        }
        $this->set(compact('training', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Training id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $training = $this->Trainings->get($id);
        if ($this->Trainings->delete($training)) {
            $this->Flash->success(__('The training has been deleted.'));
        } else {
            $this->Flash->error(__('The training could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function me()
    {
        $this->paginate = [
            'limit' => 15,
            'order' => [
                'start_date' => 'ASC'
            ],
        ];

        $trainings = $this->Trainings->find('all');
        $trainings->where(['start_date >=' =>  date("Y-m-d")]);
        $trainings->where(['end_date <=' => date("Y-m-d") . " 23:59:59"]);
        $trainings->where(['created_by =' => $this->Auth->user('id')]);


        $next_trainings = $this->Trainings->find('all');
        $next_trainings->where(['start_date >' => date("Y-m-d") . " 23:59:59"]);
        $next_trainings->where(['created_by =' => $this->Auth->user('id')]);

        $next_trainings = $this->paginate($next_trainings);

        $this->set(compact('trainings', 'next_trainings'));
    }

    public function history()
    {
        $this->paginate = [
            'limit' => 15,
            'order' => [
                'start_date' => 'DESC'
            ],
        ];

        $query = $this->Trainings->find('search', ['search' => $this->request->getData()]);
        $query->where(['created_by =' => $this->Auth->user('id')]);

        $trainings = $this->paginate($query);

        $this->set(compact('trainings'));
    }

    public function attendanceDelete($id, $training_id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $TrainingAssistances = $this->getTableLocator()->get('TrainingsAssistances');
        $training = $TrainingAssistances->get($id);
        if ($training) {
            $TrainingAssistances->delete($training);
            $this->Flash->success(__('The training has been deleted.'));
        } else {
            $this->Flash->error(__('The training could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'attendance', $training_id]);
    }

    public function attendanceSave()
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        $TrainingAssistances = $this->getTableLocator()->get('TrainingsAssistances');
        $trainingAssistance = $TrainingAssistances->get($data['assistant_id']);

        if ($data["accion"] == "asistir") {
            $training = $this->Trainings->patchEntity($trainingAssistance, ['checked' => 1, 'type_check' => 'Confirma Asistencia Manual', 'modified_by' => $this->Auth->user('id')]);
            $TrainingAssistances->save($training);
        }


        if ($data["accion"] == "no_asistir") {
            $training = $this->Trainings->patchEntity($trainingAssistance, ['checked' => 0, 'type_check' => 'Elimina Asistencia', 'modified_by' => $this->Auth->user('id')]);
            $TrainingAssistances->save($training);
        }

        return $this->response->withStringBody("success");
    }

    public function attendance($id)
    {
        $Users = $this->getTableLocator()->get('Users');
        $users =  json_decode(json_encode($Users->find()->contain(['Designations', 'Departaments'])->select(['Users.document', 'Users.name', 'Users.lastname', 'Departaments.name','Designations.name'])->toArray()), true);

        $TrainingAssistances = $this->getTableLocator()->get('TrainingsAssistances');
        $assistances = $TrainingAssistances->find('all')->contain(['Trainings', 'Users'])->where(['training_id' => $id])->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            foreach ($data['new_assistances'] as $assistance) {
                $user_data = $Users->find()->select(['id'])->where(['document' => $assistance])->limit(1)->toArray();
                $training_tmp  = $this->fetchTable('TrainingsAssistances')->newEmptyEntity();
                $training_tmp->training_id = $id;
                $training_tmp->user_id = $user_data[0]->id;
                $training_tmp->checked = 0;
                $training_tmp->type_check = '';
                $training_tmp->created_by = $this->Auth->user('id');
                $training_tmp->modified_by = $this->Auth->user('id');

                $response = $this->fetchTable('TrainingsAssistances')->save($training_tmp);
            }

            $this->Flash->success(__('Se han creado los usuarios en la lista de asistencia, ahora debe verificar asistencia'));

            return $this->redirect(['action' => 'attendance', $id]);
        }

        $training = $this->Trainings->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('training', 'users', 'assistances'));
    }

    public function calendar()
    {
        $trainings = $this->paginate($this->Trainings);
        $this->set(compact('trainings'));
    }


    public function getCalendarioEvents()
    {
        $this->request->allowMethod(['post']);

        $request = $this->request->getData();

        $capacitaciones_data = $this->Trainings->find('all');
        $capacitaciones_data->where(['start_date >=' => $request["start"]]);
        $capacitaciones_data->where(['end_date <=' => $request["end"]]);


        // construyo arreglo para fullcalendar
        $capacitaciones = [];
        foreach ($capacitaciones_data as $capacitacion) {

            $nombre_evento = $capacitacion->name;

            $capacitaciones[] = [
                'title' => $nombre_evento,
                'start' => $capacitacion->start_date->format('Y-m-d') . 'T' . $capacitacion->start_date->format('H:i:s'),
                'end' => $capacitacion->end_date->format('Y-m-d') . 'T' . $capacitacion->end_date->format('H:i:s'),
                'backgroundColor' => boolval($capacitacion->start_date->format('Y-m-d') <  date('Y-m-d')) ? "#fc544b" : "#6777ef",
                'borderColor' => boolval($capacitacion->start_date->format('Y-m-d') <  date('Y-m-d')) ? "#fc544b" : "#6777ef",
                'textColor' => '#fff',
                'data_id' => $capacitacion->id,
                'data_fecha' => $capacitacion->start_date->format('Y-m-d'),
                'data_horario' => $capacitacion->end_date->format('H:i') . '-' . $capacitacion->end_date->format('H:i'),
            ];
        }

        $response = $this->response->withType('application/json')
            ->withStringBody(json_encode($capacitaciones));

        return $response;
    }
}
