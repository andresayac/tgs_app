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
        $trainings = $this->paginate($this->Trainings);

        $this->set(compact('trainings'));
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
        $Departaments = $this->getTableLocator()->get('Departaments');
        $Designations = $this->getTableLocator()->get('Designations');

        $departaments =  json_decode(json_encode($Departaments->find()->select(['id', 'name'])->toArray()), true);
        $designations =  json_decode(json_encode($Designations->find()->select(['id', 'name'])->toArray()), true);

        $training = $this->Trainings->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['designations'] = implode(',', $data['designations']);
            $data['departaments'] = implode(',', $data['departaments']);
            $training = $this->Trainings->patchEntity($training, $data);
            $this->Flash->error(__('The training could not be saved. Please, try again.'));

            if ($this->Trainings->save($training)) {
                $this->Flash->success(__('The training has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The training could not be saved. Please, try again.'));
        }
        $this->set(compact('training', 'designations', 'departaments'));
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
        $training = $this->Trainings->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $training = $this->Trainings->patchEntity($training, $this->request->getData());
            if ($this->Trainings->save($training)) {
                $this->Flash->success(__('The training has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The training could not be saved. Please, try again.'));
        }
        $this->set(compact('training'));
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
