<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use     PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\Http\CallbackStream; // ← Added new in this sample

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
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
            'contain' => ['Roles', 'Departaments', 'Branchs', 'Designations'],
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Departaments', 'Branchs', 'Designations'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();
        $departaments = $this->Users->Departaments->find('list', ['limit' => 200])->all();
        $branchs = $this->Users->Branchs->find('list', ['limit' => 200])->all();
        $designations = $this->Users->Designations->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'roles', 'departaments', 'branchs', 'designations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            $user = $this->Users->patchEntity($user, $data);

            if (empty($data['password'])) unset($user->password);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();
        $departaments = $this->Users->Departaments->find('list', ['limit' => 200])->all();
        $branchs = $this->Users->Branchs->find('list', ['limit' => 200])->all();
        $designations = $this->Users->Designations->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'roles', 'departaments', 'branchs', 'designations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }



    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'logout']);
    }

    public function export()
    {

        $filename = 'Usuarios_' . date('Y-m-d_His');

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Usuarios');
        $spreadsheet->getProperties()->setCreator("TGS-APP");

        $datos_excel = $this->Users->find()
            ->contain(['Roles', 'Departaments', 'Branchs', 'Designations'])
            ->select([
                'ID_App' => 'Users.id',
                'Tipo_Documento' => 'Users.document_type',
                'Cedula' => 'Users.document',
                'Nombre' => 'Users.name',
                'Apellidos' => 'Users.lastname',
                'Fecha_Nacimiento' => 'DATE_FORMAT(Users.date_birthday,"%Y-%m-%d")',
                'Estado' => 'if(Users.active=1,"Activo","Inactivo")',
                'Huella' => 'if(Users.indexfinger IS NULL,"NO","SI")',
                'Telefono' => 'Users.telephone',
                'Rol' => 'Roles.name',
                'Area' => 'Departaments.name',
                'Cargo' => 'Designations.name'
            ])->disableHydration()->toArray();

        array_unshift($datos_excel, array_keys($datos_excel[0]));

        $spreadsheet->getActiveSheet()->fromArray($datos_excel, NULL, 'A1');

        $writer = new Xlsx($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        // Return the stream in a response
        return $this->response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream ?? '');
    }

    public function import($action = NULL)
    {

        if ($this->request->is(['patch', 'post', 'put'])) {

            if ($action === 'file_download') {
                $filename = 'plantilla_usuarios';

                $spreadsheet = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('Usuarios');
                $spreadsheet->getProperties()->setCreator("TGS-APP");

                $columns = [
                    "Usuario",
                    "Nombres",
                    "Apellidos",
                    "Documento",
                    "Telefono",
                    "Sucursal Id",
                    "Area Id",
                    "Cargo Id"
                ];

                $spreadsheet->getActiveSheet()
                    ->getStyle('A1:H1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('00FF7F');

                foreach (range('A', 'H') as $letter) {
                    $spreadsheet->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
                }

                $spreadsheet->getActiveSheet()->fromArray($columns, NULL, 'A1');

                $spreadsheet->createSheet();
                $spreadsheet->setActiveSheetIndex(1);
                $spreadsheet->getActiveSheet()->setTitle('Tablas de datos');

                $branchs = $this->getTableLocator()->get('Branchs')->find()->select(['Sucursal_ID' => 'id', 'Sucursal_Nombre' => 'name'])->disableHydration()->toArray();;
                $departaments = $this->getTableLocator()->get('Departaments')->find()->select(['Area_ID' => 'id', 'Area_Nombre' => 'name'])->disableHydration()->toArray();;
                $designations = $this->getTableLocator()->get('Designations')->find()->select(['Cargo_ID' => 'id', 'Cargo_Nombre' => 'name'])->disableHydration()->toArray();;

                array_unshift($branchs, array_keys($branchs[0]));
                array_unshift($departaments, array_keys($departaments[0]));
                array_unshift($designations, array_keys($designations[0]));

                $ejemplo = [
                    [
                        "Usuario" => 'empleado1',
                        "Nombres" => 'Nombre1 Nombre 2',
                        "Apellidos" => 'Apellido1 Apellido2',
                        "Documento" => '100000123',
                        "Telefono" => '3110001234',
                        "Sucursal Id" => '2',
                        "Area Id" => '5',
                        "Cargo Id" => ' 12'
                    ],
                    [
                        "Usuario" => 'empleado2',
                        "Nombres" => 'Nombre2 Nombre 2',
                        "Apellidos" => 'Apellido2 Apellido2',
                        "Documento" => '100000124',
                        "Telefono" => '3110001235',
                        "Sucursal Id" => '3',
                        "Area Id" => '6',
                        "Cargo Id" => ' 10'
                    ]
                ];

                array_unshift($ejemplo, array_keys($ejemplo[0]));

                $range = [
                    'A1:B1',
                    'D1:E1',
                    'G1:H1',
                    'K2:R2',
                ];

                foreach ($range as $value) {
                    $spreadsheet->getActiveSheet()
                        ->getStyle($value)
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('00FF7F');
                }
                foreach (range('A', 'R') as $letter) {
                    $spreadsheet->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
                }

                $spreadsheet->getActiveSheet()->fromArray($branchs, NULL, 'A1');
                $spreadsheet->getActiveSheet()->fromArray($departaments, NULL, 'D1');
                $spreadsheet->getActiveSheet()->fromArray($designations, NULL, 'G1');
                $spreadsheet->getActiveSheet()->setCellValue('J1', 'Ejemplo de Inserción Usuarios');
                $spreadsheet->getActiveSheet()->fromArray($ejemplo, NULL, 'K2');

                $writer = new Xlsx($spreadsheet);
                $stream = new CallbackStream(function () use ($writer) {
                    $writer->save('php://output');
                });

                // Return the stream in a response
                return $this->response->withType('xlsx')
                    ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
                    ->withBody($stream ?? '');
            }



            $request = $this->request->getData();
            $file = $request['excel'];
            $mimes = array(
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );

            if ($file->getError()) $this->Flash->error(__('Archivo no valido o vacio'));


            if (in_array($file->getClientMediaType(), $mimes) && $file->getSize() < 50235) {
                $spreadsheet = IOFactory::load($file->getStream()->getMetadata('uri'));

                $sheet        = $spreadsheet->getActiveSheet();
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range(2, $row_limit);
                $column_range = range('F', $column_limit);

                if ($row_range  <= 2) $this->Flash->error(__('El archivo se encuentra vacio, debe completar'));

                $error_data = [];
                foreach ($row_range as $row) {
                    $user = $this->Users->newEmptyEntity();
                    $data['username'] = $user->username = $sheet->getCell('A' . $row)->getValue();
                    $data['name'] = $user->name = $sheet->getCell('B' . $row)->getValue();
                    $data['lastname'] = $user->lastname = $sheet->getCell('C' . $row)->getValue();
                    $data['document'] = $user->document = $sheet->getCell('D' . $row)->getValue();
                    $data['telephone'] = $user->telephone = $sheet->getCell('E' . $row)->getValue();
                    $data['branch_id'] = $user->branch_id = $sheet->getCell('F' . $row)->getValue();
                    $data['dep_id'] = $user->dep_id = $sheet->getCell('G' . $row)->getValue();
                    $data['designation_id'] = $user->designation_id = $sheet->getCell('H' . $row)->getValue();
                    $user->active = '1';
                    $user->document_type = 'CC';
                    $user->rol_id = 5;

                    $reponse = $this->Users->save($user);
                    if (!$reponse) {
                        $error_data[] = $data;
                    }
                }

                if (empty($error_data)) {
                    $this->Flash->success(__('Usuarios Agregados con exito'));
                } else {
                    $this->Flash->error(__('Se han identificado ' . count($error_data) . ' registros con error o duplicados'));
                }
            }

            $this->set('error', $error_data);

            if (!empty($error_data)) {
                $filename = 'Usuarios_error' . date('Y-m-d_His');

                $spreadsheet = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('UsuariosError');
                $spreadsheet->getProperties()->setCreator("TGS-APP");

                array_unshift($error_data, array_keys($error_data[0]));

                $spreadsheet->getActiveSheet()->fromArray($error_data, NULL, 'A1');

                $writer = new Xlsx($spreadsheet);
                $stream = new CallbackStream(function () use ($writer) {
                    $writer->save('php://output');
                });

                // Return the stream in a response
                return $this->response->withType('xlsx')
                    ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
                    ->withBody($stream ?? '');
            }

            return $this->redirect(['action' => 'import']);
        }
    }


    public function login()
    {
        $this->viewBuilder()->disableAutoLayout();


        if (!empty($this->Auth->user())) {
            // redirecicon inicial basado en rol
            $Roles = $this->getTableLocator()->get('Roles');
            $rol_info = $Roles->get($this->Auth->user('rol_id'))->toArray();

            if (!empty($rol_info['home_page'])) {
                $home_controller = explode('/', $rol_info['home_page'])[0];
                $home_action = explode('/', $rol_info['home_page'])[1];
                return $this->redirect(['controller' => $home_controller, 'action' => $home_action]);
            }
            return $this->redirect($this->Auth->redirectUrl());
        }


        if ($this->request->is('post')) {
            if ($this->Auth->identify()) {

                $this->Auth->setUser($this->Auth->identify());
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Usuario o contraseña invalidos.'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
