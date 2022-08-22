<?php



namespace App\Controller;

use App\Controller\AppController;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\Http\CallbackStream; // ← Added new in this sample

class DashboardController extends AppController
{


    public function index()
    {

        $Users = $this->getTableLocator()->get('Users');
        $Trainings = $this->getTableLocator()->get('Trainings');

        $trainings_counts = $Trainings->find()->count();
        $trainings_month = $Trainings->find()->where(['MONTH(created) ' =>  date('m'), 'YEAR(created)' =>  date('Y')])->count();

        $users_counts = $Users->find()->count();
        $users_month = $Users->find()->where(['MONTH(created) ' =>  date('m'), 'YEAR(created)' =>  date('Y')])->count();


        $trainings_month_chart = $Trainings->find()
            ->select(['month' => 'month(start_date)', 'total' => 'sum(1)'])
            ->where(['YEAR(created)' =>  date('Y')])
            ->group('month(start_date)')
            ->disableHydration()
            ->toArray();

        $TrainingsAssistances = $this->getTableLocator()->get('TrainingsAssistances');
        $trainings_assistence_chart = $TrainingsAssistances->find()
            ->contain(['Trainings'])
            ->select([
                'month' => 'month(start_date)',
                'total' => 'sum(1)',
                'assistances_yes' => 'sum(if(TrainingsAssistances.checked=1,1,0))',
                'assistances_not' => 'sum(if(TrainingsAssistances.checked=0,1,0))'
            ])
            ->where(['YEAR(Trainings.created)' =>  date('Y')])
            ->group('month(Trainings.start_date)')
            ->disableHydration()
            ->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $rango = explode(' - ', $request['rango_reporte']);

            if (count($rango) <= 1) return $this->Flash->error(__('Selecione el rango con el formato adecuado'));

            $TrainingsAssistances = $this->getTableLocator()->get('TrainingsAssistances');

            $users_report = $Trainings->find()
                ->select([
                    'ID' => 'Trainings.id',
                    'CAPACITACION' => 'Trainings.name',
                    'CAPACITACION_NOTA' => 'Trainings.note',
                    'CAPACITACION_REALIZA' => 'group_concat(users_trainer.fullname)',
                    'FECHA' => 'DATE_FORMAT(Trainings.start_date, "%Y-%m-%d")',
                    'HORA_INICIO' => 'DATE_FORMAT(Trainings.start_date, "%h:%i %p")',
                    'HORA_FINAL' => 'DATE_FORMAT(Trainings.end_date, "%h:%i %p")',
                    'ASISTENTE' => '(Users.fullname',
                    'ASISTENTE_DOCUMENTO' => 'Users.document',
                    'ASISTENTE_ROL' => 'Roles.name',
                    'ASISTE_EVENTO' => 'if(TrainingsAssistances.checked=1,"SI","NO")',
                    'ASISTE_FECHA' => 'TrainingsAssistances.check_ts',
                    'ASISTE_TIPO' => 'TrainingsAssistances.type_check',
                    'ASISTENCIA_AGREGA_USER' => 'users_created.fullname',
                    'ASISTENCIA_TOMA' => 'users_modified.name',
                    'SUCURSAL' => 'Branchs.name',
                    'AREA' => 'Departaments.name',
                    'CARGO' => 'Designations.name'
                ])
                ->leftJoin(
                    ['TrainingsAssistances' => 'trainings_assistances'],
                    ['Trainings.id= TrainingsAssistances.training_id ']
                )
                ->leftJoin(
                    ['Users' => 'users'],
                    ['Users.id = TrainingsAssistances.user_id ']
                )
                ->leftJoin(
                    ['Branchs' => 'branchs'],
                    ['Branchs.id = Users.branch_id']
                )
                ->leftJoin(
                    ['Designations' => 'designations'],
                    ['Designations.id = Users.designation_id ']
                )
                ->leftJoin(
                    ['Departaments' => 'departaments'],
                    ['Departaments.id = Users.dep_id ']
                )
                ->leftJoin(
                    ['Roles' => 'roles'],
                    ['Roles.id = Users.rol_id ']
                )
                ->leftJoin(
                    ['users_trainer' => 'users'],
                    ['FIND_IN_SET(users_trainer.document, Trainings.trainer)']
                )
                ->leftJoin(
                    ['users_created' => 'users'],
                    ['TrainingsAssistances.created_by = users_created.id']
                )
                ->leftJoin(
                    ['users_modified' => 'users'],
                    ['TrainingsAssistances.modified_by = users_modified.id']
                )
                ->where(['Trainings.created >=' => $rango[0], 'Trainings.created <=' =>  $rango[1] . ' 23:59:59'])
                ->group('TrainingsAssistances.id ')
                ->order(['Trainings.id' => 'ASC'])
                ->disableHydration()
                ->toArray();

            if (empty($users_report)) return $this->Flash->error(__('No hay capacitaciones para el rango proporcionado'));

            $filename = 'INFORME_' .  $rango[0] . ':' . $rango[1] . '_GENERA_' . date('Y-m-d_His');

            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('Informe Capacitaciones');
            $spreadsheet->getProperties()->setCreator("TGS-APP");

            array_unshift($users_report, array_keys($users_report[0]));

            $spreadsheet->getActiveSheet()
                ->getStyle('A1:R1')
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('00FF7F');

            foreach (range('A', 'R') as $letter) {
                $spreadsheet->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
            }

            $spreadsheet->getActiveSheet()->fromArray($users_report, NULL, 'A1');

            $writer = new Xlsx($spreadsheet);
            $stream = new CallbackStream(function () use ($writer) {
                $writer->save('php://output');
            });

            // Return the stream in a response
            return  $this->response->withType('xlsx')
                ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
                ->withBody($stream ?? '');
        }

        $this->set(compact('trainings_counts', 'trainings_month', 'users_counts', 'users_month', 'trainings_month_chart', 'trainings_assistence_chart'));
    }
}
