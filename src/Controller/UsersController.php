<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\Http\CallbackStream; // ← Added new in this sample

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function index()
    {
        $this->paginate = [
            'limit' => 5000,
            'maxLimit' => 5000,
            'contain' => ['Roles', 'Departaments', 'Branchs', 'Designations'],
        ];

        $roles_permisos = (in_array($this->Auth->user('rol_id'), [1, 2])) ? [0] : [1, 2];
        if ($this->Auth->user('rol_id') === 2) $roles_permisos = [1];

        $users_paginate = $this->Users->find()->where(['rol_id NOT IN ' => $roles_permisos]);
        $users = $this->paginate($users_paginate);

        $this->set(compact('users'));
    }

    public function view($id = null)
    {
        $roles_permisos = (in_array($this->Auth->user('rol_id'), [1, 2])) ? [0] : [1, 2];
        if ($this->Auth->user('rol_id') === 2) $roles_permisos = [1];

        $valida = $this->Users->find()
            ->where(['id' => $id, 'rol_id NOT IN' =>  $roles_permisos])
            ->limit(1)
            ->count();

        if (!$valida) {
            $this->Flash->error(__('El usuario no existe o no tiene permisos'));
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Departaments', 'Branchs', 'Designations']
        ]);

        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('El usuario ha sido guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar el usuario. Inténtalo de nuevo. '));
        }
        $roles_permisos = (in_array($this->Auth->user('rol_id'), [1, 2])) ? [0] : [1, 2, 3];
        if ($this->Auth->user('rol_id') === 2) $roles_permisos = [1];

        $roles = $this->Users->Roles
            ->find('list', ['limit' => 2000])
            ->where(['Roles.id  NOT IN ' => $roles_permisos]);

        $departaments = $this->Users->Departaments
            ->find('list', ['limit' => 2000])
            ->where(['active' => 1])
            ->all();
        $branchs = $this->Users->Branchs
            ->find('list', ['limit' => 2000])
            ->where(['active' => 1])
            ->all();
        $designations = $this->Users->Designations
            ->find('list', ['limit' => 2000])
            ->where(['active' => 1])
            ->all();
        $this->set(compact('user', 'roles', 'departaments', 'branchs', 'designations'));
    }

    public function edit($id = null)
    {

        $roles_permisos = (in_array($this->Auth->user('rol_id'), [1, 2])) ? [0] : [1, 2];
        if ($this->Auth->user('rol_id') === 2) $roles_permisos = [1];

        $valida = $this->Users->find()
            ->where(['id' => $id, 'rol_id NOT IN' =>  $roles_permisos])
            ->limit(1)
            ->count();

        if (!$valida) {
            $this->Flash->error(__('El usuario no existe o no tiene permisos'));
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            $user = $this->Users->patchEntity($user, $data);

            if (empty($data['password'])) unset($user->password);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('El usuario ha sido guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar el usuario. Inténtalo de nuevo.'));
        }

        $roles_permisos = (in_array($this->Auth->user('rol_id'), [1, 2])) ? [0] : [1, 2, 3];
        if ($this->Auth->user('rol_id') === 2) $roles_permisos = [1];

        $roles = $this->Users->Roles
            ->find('list', ['limit' => 2000])
            ->where(['Roles.id  NOT IN ' => $roles_permisos]);

        $departaments = $this->Users->Departaments
            ->find('list', ['limit' => 2000])
            ->where(['active' => 1])
            ->all();
        $branchs = $this->Users->Branchs
            ->find('list', ['limit' => 2000])
            ->where(['active' => 1])
            ->all();
        $designations = $this->Users->Designations
            ->find('list', ['limit' => 2000])
            ->where(['active' => 1])
            ->all();

        $this->set(compact('user', 'roles', 'departaments', 'branchs', 'designations'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $roles_permisos = (in_array($this->Auth->user('rol_id'), [1, 2])) ? [1] : [1, 2];

        $valida = $this->Users->find()
            ->where(['id' => $id, 'rol_id NOT IN' =>  $roles_permisos])
            ->limit(1)
            ->count();

        if (!$valida) {
            $this->Flash->error(__('El usuario no existe o no tiene permisos'));
            return $this->redirect(['action' => 'index']);
        }

        $TrainingAssistances = $this->getTableLocator()->get('TrainingsAssistances');
        $valided_assistences = $TrainingAssistances->find()
            ->where(['user_id' => $id])
            ->count();


        if ($valided_assistences > 0) {
            $this->Flash->error(__('El usuario no se puede eliminar se encuentra vinculado a una o mas listas de asistencia.'));
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('El usuario ha sido eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el usuario. Inténtalo de nuevo.'));
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
        $spreadsheet->getProperties()->setCreator("T-MTI VFT-APP");

        $datos_excel = $this->Users->find()
            ->contain(['Roles', 'Departaments', 'Branchs', 'Designations'])
            ->select([
                'ID_App' => 'Users.id',
                'Tipo_Documento' => 'Users.document_type',
                'Cedula' => 'Users.document',
                'Nombre_Completo' => 'Users.fullname',
                'Fecha_Nacimiento' => 'DATE_FORMAT(Users.date_birthday,"%Y-%m-%d")',
                'Estado' => 'if(Users.active=1,"Activo","Inactivo")',
                'Huella' => 'if(Users.indexfinger IS NULL,"NO","SI")',
                'Telefono' => 'Users.telephone',
                'Rol' => 'Roles.name',
                'Sucursal' => 'Branchs.name',
                'Area' => 'Departaments.name',
                'Cargo' => 'Designations.name'
            ])
            ->disableHydration()
            ->toArray();

        $spreadsheet->getActiveSheet()
            ->getStyle('A1:L1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('00FF7F');

        foreach (range('A', 'L') as $letter) {
            $spreadsheet->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
        }

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
                $spreadsheet->getProperties()->setCreator("T-MTI VFT-APP");

                $columns = [
                    "Usuario",
                    "Nombre",
                    "Documento",
                    "Telefono",
                    "Sucursal Id",
                    "Area Id",
                    "Cargo Id"
                ];

                $spreadsheet->getActiveSheet()
                    ->getStyle('A1:G1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('00FF7F');

                foreach (range('A', 'G') as $letter) {
                    $spreadsheet->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
                }

                $spreadsheet->getActiveSheet()->fromArray($columns, NULL, 'A1');

                $spreadsheet->createSheet();
                $spreadsheet->setActiveSheetIndex(1);
                $spreadsheet->getActiveSheet()->setTitle('Tablas de datos');

                $branchs = $this->getTableLocator()
                    ->get('Branchs')->find()
                    ->select(['Sucursal_ID' => 'id', 'Sucursal_Nombre' => 'name'])
                    ->disableHydration()
                    ->toArray();
                $departaments = $this->getTableLocator()->get('Departaments')->find()->select(['Area_ID' => 'id', 'Area_Nombre' => 'name'])->disableHydration()->toArray();;
                $designations = $this->getTableLocator()->get('Designations')->find()->select(['Cargo_ID' => 'id', 'Cargo_Nombre' => 'name'])->disableHydration()->toArray();;

                array_unshift($branchs, array_keys($branchs[0]));
                array_unshift($departaments, array_keys($departaments[0]));
                array_unshift($designations, array_keys($designations[0]));

                $ejemplo = [
                    [
                        "Usuario" => 'empleado1',
                        "Nombre" => 'Nombre Apellido',
                        "Documento" => '100000123',
                        "Telefono" => '3110001234',
                        "Sucursal Id" => '2',
                        "Area Id" => '5',
                        "Cargo Id" => ' 12'
                    ],
                    [
                        "Usuario" => 'empleado2',
                        "Nombre" => 'Nombre Apellido',
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

            if (in_array($file->getClientMediaType(), $mimes) && $file->getSize() < 5023500) {
                $spreadsheet = IOFactory::load($file->getStream()->getMetadata('uri'));

                $sheet        = $spreadsheet->getActiveSheet();
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range(2, $row_limit);
                $column_range = range('F', $column_limit);

                if ($row_range  <= 2) $this->Flash->error(__('El archivo se encuentra vacio, debe completar'));

                $error_data = [];
                $success = 0;
                foreach ($row_range as $row) {
                    $user = $this->Users->newEmptyEntity();
                    $data['username'] = $user->username = $sheet->getCell('A' . $row)->getValue();
                    $data['fullname'] = $user->fullname = $sheet->getCell('B' . $row)->getValue();
                    $data['document'] = $user->document = $sheet->getCell('C' . $row)->getValue();
                    $data['telephone'] = $user->telephone = $sheet->getCell('D' . $row)->getValue();
                    $data['branch_id'] = $user->branch_id =  $sheet->getCell('E' . $row)->getValue();
                    $data['dep_id'] = $user->dep_id = $sheet->getCell('F' . $row)->getValue();
                    $data['designation_id'] = $user->designation_id = $sheet->getCell('G' . $row)->getValue();
                    $user->active = '1';
                    $user->document_type = 'CC';
                    $user->rol_id = 4;


                    if (!$this->Users->save($user)) {
                        $error_data[] = $data;
                    } else {
                        $success++;
                    }
                }

                if (empty($error_data)) {
                    $this->Flash->success(__('Usuarios Agregados con exito =>' . $success));
                } else {
                    $this->Flash->error(__('Se han identificado ' . count($error_data) . ' registros duplicados'));
                }
            }else{
                $this->Flash->error(__('Archivo no valido o mayor a 5 MB'));
            }

            if (!empty($error_data)) {
                $filename = 'Usuarios_error' . date('Y-m-d_His');

                $spreadsheet = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('UsuariosError');
                $spreadsheet->getProperties()->setCreator("T-MTI VFT-APP");

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

            $this->redirect($this->referer());
        }
    }

    public function profile()
    {
        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => ['Roles'],
        ]);

        $this->set(compact('user'));
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
