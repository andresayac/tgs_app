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

        if ($this->request->is('post')) {


            if ($action === 'file_download') {
                $filename = 'plantilla_usuarios';

                $spreadsheet = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('Usuarios');
                $spreadsheet->getProperties()->setCreator("TGS-APP");

                $columns = [
                    "Usuario[username]",
                    "Nombres[name]",
                    "Apellidos[lastname]",
                    "Tipo Documento[document_type]",
                    "Documento[document]",
                    "Fecha Nacimiento[date_birthday]",
                    "Telefono[telephone]",
                    "Sucursal[branch_id]",
                    "Area[dep_id]",
                    "Cargo[designation_id]"
                ];

                $spreadsheet->getActiveSheet()->fromArray($columns, NULL, 'A1');

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

            if (in_array($file->getClientMediaType(), $mimes)) {
                /* var_dump($file->getClientFilename());
                var_dump($file->getClientMediaType());
                var_dump($file->getSize());
                var_dump($file->getError());
                
                var_dump($file->getStream()->getMetadata('uri')); */

                $spreadsheet = IOFactory::load($file->getStream()->getMetadata('uri'));

                $sheet        = $spreadsheet->getActiveSheet();
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range(2, $row_limit);
                $column_range = range('F', $column_limit);


                foreach ($row_range as $row) {
                    $data[] = [
                        'username' => $sheet->getCell('A' . $row)->getValue(),
                        'name' => $sheet->getCell('B' . $row)->getValue(),
                        'lastname' => $sheet->getCell('C' . $row)->getValue(),
                        'document_type' => $sheet->getCell('D' . $row)->getValue(),
                        'document' => $sheet->getCell('E' . $row)->getValue(),
                        'date_birthday' => $sheet->getCell('F' . $row)->getValue(),
                        'telephone' => $sheet->getCell('G' . $row)->getValue(),
                        'branch_id' => $sheet->getCell('H' . $row)->getValue(),
                        'dep_id' => $sheet->getCell('I' . $row)->getValue(),
                        'designation_id' => $sheet->getCell('J' . $row)->getValue(),
                    ];
                }

                var_dump($data);
            }


            if ($this->Auth->identify()) {

                $this->Auth->setUser($this->Auth->identify());
                return $this->redirect($this->Auth->redirectUrl());
            }
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
