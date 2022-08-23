<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;

class TrainingsController extends AppController
{

    public function index()
    {
        $Users = $this->getTableLocator()->get('Users');
        $users =  $Users->find()->select(['document', 'fullname', 'id'])
            ->disableHydration()
            ->toArray();

            $this->paginate = [
                'limit' => 5000,
                'maxLimit' => 5000,
                'contain' => [],
                'order' => array('Trainings.start_date' => 'DESC')
                
            ];

        $trainings = $this->paginate($this->Trainings);

        $this->set(compact('trainings', 'users'));
    }

    public function view($id = null)
    {
        $Users = $this->getTableLocator()->get('Users');
        $users =  $Users->find()->select(['document', 'fullname', 'id'])
            ->disableHydration()
            ->toArray();

        $training = $this->Trainings->get($id, [
            'contain' => ['TrainingsAssistances', 'TrainingsAssistances.Users'],
        ]);

        $this->set(compact('training', 'users'));
    }

    public function add()
    {
        $Users = $this->getTableLocator()->get('Users');

        $users =  $Users->find()
            ->contain(['Designations', 'Departaments', 'Branchs'])
            ->select(['Users.document', 'Users.fullname', 'Departaments.name', 'Designations.name', 'Branchs.name'])
            ->where(['Users.active' => 1, 'Users.rol_id NOT IN' => [1]])
            ->disableHydration()
            ->toArray();

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

    public function edit($id = null)
    {

        $valida = $this->Trainings->find()
            ->where(['Trainings.id' => $id, 'Trainings.start_date >=' =>  new FrozenTime(FrozenTime::now()->i18nFormat('yyyy-MM-dd'))])
            ->limit(1)
            ->count();

        if (!$valida) {
            $this->Flash->error(__('No es posible editar la capacitación, la fecha actual es superior a su realización.'));
            return $this->redirect(['action' => 'index']);
        }

        $training = $this->Trainings->get($id, [
            'contain' => [],
        ]);

        $Users = $this->getTableLocator()->get('Users');

        $users = $Users->find()
            ->contain(['Designations', 'Departaments', 'Branchs'])
            ->select(['Users.document', 'Users.fullname', 'Departaments.name', 'Designations.name', 'Branchs.name'])
            ->where(['Users.active' => 1, 'Users.rol_id NOT IN' => [1]])
            ->disableHydration()
            ->toArray();


        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $date_training = $data['start_date'];

            $date_input =  new FrozenTime($date_training);
            $date_now = new FrozenTime(FrozenTime::now()->i18nFormat('yyyy-MM-dd'));

            if ($date_input < $date_now) {
                $this->Flash->error(__('La fecha proporcionada debe ser mayor o igual al dia actual'));
                $this->redirect($this->referer());
            } else {
                $data['start_date'] =   $date_training . " " . $data['start_hour'];
                $data['end_date']   =   $date_training . " " . $data['end_hour'];

                $data['trainer'] = implode(',', $data['trainer']);
                $data['modified_by'] =  $this->Auth->user('id');

                $training = $this->Trainings->patchEntity($training, $data);

                if ($this->Trainings->save($training)) {
                    $this->Flash->success(__('La capacitación se ha guardado.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('No se pudo guardar la capacitación. Inténtalo de nuevo.'));
            }
        }
        $this->set(compact('training', 'users'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $training = $this->Trainings->get($id);

        $TrainingAssistances = $this->getTableLocator()->get('TrainingsAssistances');
        $valided_assistences = $TrainingAssistances->find()
            ->where(['training_id' => $id])
            ->count();

        if ($valided_assistences > 0) {
            $this->Flash->error(__('No se puede eliminar la capacitación tiene asistentes vinculados.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Trainings->delete($training)) {
            $this->Flash->success(__('Capacitación Eliminada'));
        } else {
            $this->Flash->error(__('No puede ser eliminada la capacitación intente mas tarde'));
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

    public function attendanceDelete($id, $training_id, $action)
    {
        $this->request->allowMethod(['post', 'delete']);
        $TrainingAssistances = $this->getTableLocator()->get('TrainingsAssistances');


        if ($action === 'all') {
            $assistances_delete = $TrainingAssistances->find()
                ->where(['training_id' => $training_id, 'checked' => 0]);

            foreach ($assistances_delete as  $assistance_delete) {
                $TrainingAssistances->delete($assistance_delete);
            }
            $this->Flash->success(__('Asistentes Eliminados'));
        }

        if ($action === 'item') {
            $training = $TrainingAssistances->get($id);
            if ($training) {
                $TrainingAssistances->delete($training);
                $this->Flash->success(__('La capacitacion ha sido eliminado.'));
            } else {
                $this->Flash->error(__('No se pudo eliminar la capacitación. Inténtalo de nuevo.'));
            }
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
            $training = $this->Trainings->patchEntity($trainingAssistance, ['checked' => 1, 'check_ts' => new FrozenTime(FrozenTime::now()->i18nFormat('yyyy-MM-dd kk:mm:ss')), 'type_check' => 'Confirma Asistencia Manual', 'modified_by' => $this->Auth->user('id')]);
            $TrainingAssistances->save($training);
        }


        if ($data["accion"] == "no_asistir") {
            $training = $this->Trainings->patchEntity($trainingAssistance, ['checked' => 0, 'check_ts' => new FrozenTime(FrozenTime::now()->i18nFormat('yyyy-MM-dd kk:mm:ss')), 'type_check' => 'Elimina Asistencia', 'modified_by' => $this->Auth->user('id')]);
            $TrainingAssistances->save($training);
        }

        return $this->response->withStringBody("success");
    }

    public function attendance($id)
    {
        $Users = $this->getTableLocator()->get('Users');
        $users =  $Users->find()
            ->contain(['Designations', 'Departaments', 'Branchs'])
            ->select(['Users.document', 'Users.fullname', 'Departaments.name', 'Designations.name', 'Branchs.name'])
            ->where(['Users.active' => 1, 'rol_id NOT IN' => [1]])
            ->disableHydration()
            ->toArray();

        $TrainingAssistances = $this->getTableLocator()->get('TrainingsAssistances');
        $assistances = $TrainingAssistances->find('all')
            ->contain(['Trainings', 'Users'])
            ->where(['training_id' => $id])
            ->toArray();

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

    public function duplicate($id = null)
    {
        $data = $this->Trainings->get($id)->toArray();

        $training = $this->Trainings->newEmptyEntity();
        $training = $this->Trainings->patchEntity($training, $data);

        $training->name =  $training->name . " Duplicado";

        $training->start_date = new FrozenTime(FrozenTime::now()->i18nFormat('yyyy-MM-dd'));
        $training->end_date = new FrozenTime(FrozenTime::now()->i18nFormat('yyyy-MM-dd'));

        if ($this->Trainings->save($training)) {
            $this->Flash->success(__('La capacitación duplicada con exito '));

            return $this->redirect(['action' => 'edit', $training->id]);
        }
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
        if (!in_array($this->Auth->user('rol_id'), [1, 2])) $capacitaciones_data->where(['created_by ' => $this->Auth->user('id')]);


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
