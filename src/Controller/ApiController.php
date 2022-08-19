<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Client;
use Cake\I18n\FrozenTime;

class ApiController extends AppController
{

    public function index()
    {
        return $this->response->withType('json')->withStringBody(json_encode(['User has previously enrolled']));
    }

    public function enroll()
    {
        $this->request->allowMethod(['post']);

        $data_request = $this->request->getData();
        $user_data = json_decode($data_request['data']);

        $user_id = $user_data->id;
        $index_finger_string_array = $user_data->index_finger;
        $middle_finger_string_array = $user_data->middle_finger;

        $pre_reg_fmd_array = [
            "index_finger" => $index_finger_string_array,
            "middle_finger" => $middle_finger_string_array
        ];


        if (empty($index_finger_string_array) || empty($middle_finger_string_array)) return $this->response->withType('text/plain')->withStringBody('Valide que la huella se halla capturado');

        if ($this->isDuplicate($index_finger_string_array[0]) || $this->isDuplicate($middle_finger_string_array[0])) {
            return $this->response->withType('text/plain')->withStringBody('No se permite el duplicado de huellas!');
        } else {
            $json_response = $this->enroll_fingerprint($pre_reg_fmd_array);
            $response = json_decode($json_response);
            if ($response !== "enrollment failed") {
                $enrolled_index_finger_fmd_string = $response->enrolled_index_finger;
                $enrolled_middle_finger_fmd_string = $response->enrolled_middle_finger;
                $reponse_db = $this->setUserFmds($user_id, $enrolled_index_finger_fmd_string, $enrolled_middle_finger_fmd_string);
                return $this->response->withType('text/plain')->withStringBody($reponse_db);
            } else {
                return $this->response->withType('text/plain')->withStringBody('El usuario se ha inscrito previamente');
            }
        }

        return $this->response->withType('text/plain')->withStringBody('El usuario se ha inscrito previamente');
    }

    public function verify()
    {

        $this->request->allowMethod(['post']);

        $data_request = $this->request->getData();
        $user_data = json_decode($data_request['data']);

        $user_id = $user_data->id;
        //this is not necessarily index_finger it could be
        //any finger we wish to identify

        if (empty($user_data->index_finger[0])) return $this->response->withType('text/plain')->withStringBody('failed');

        $pre_reg_fmd_string = $user_data->index_finger[0];

        $hand_data = $this->getUserFmds($user_id)[0];

        $enrolled_fingers = [
            "index_finger" => $hand_data['indexfinger'],
            "middle_finger" => $hand_data['middlefinger']
        ];

        $json_response = $this->verify_fingerprint($pre_reg_fmd_string, $enrolled_fingers);
        $response = json_decode($json_response);
        if ($response === "match") {
            if ($user_data->training_id > 0) $this->setAsistence($user_data->training_id);
            return $this->response->withType('text/plain')->withStringBody('success');
        } else {
            return $this->response->withType('text/plain')->withStringBody('failed');
        }

        return $this->response->withType('text/plain')->withStringBody('');
    }

    private function setAsistence($training_id)
    {
        $TrainingAssistances = $this->getTableLocator()->get('TrainingsAssistances');
        $trainingAssistance = $TrainingAssistances->get($training_id);


        $training = $TrainingAssistances->patchEntity($trainingAssistance, ['checked' => 1, 'check_ts' => new FrozenTime(FrozenTime::now()->i18nFormat('yyyy-MM-dd kk:mm:ss')), 'type_check' => 'Confirma Asistencia Huella', 'modified_by' => $this->Auth->user('id')]);
        $TrainingAssistances->save($training);
    }

    private function isduplicate($fmd_to_check_string)
    {
        $allFmds = $this->getAllFmds();

        if (!$allFmds) return false;  // there is nothing here, so nothing to do

        $enrolled_hand_array = $allFmds;

        $json_response = $this->is_duplicate_fingerprint($fmd_to_check_string, $enrolled_hand_array);
        $response = json_decode($json_response);

        return ($response) ? true : false;
    }

    private function setUserFmds($user_id, $index_finger_fmd_string, $middle_finger_fmd_string)
    {
        $Users = $this->getTableLocator()->get('Users');

        $usuario = $Users->get($user_id);

        $usuario->indexfinger = $index_finger_fmd_string;
        $usuario->middlefinger = $middle_finger_fmd_string;
        $reponse = $Users->save($usuario);

        return ($reponse) ? "success" : "Error intentelo mas tarde";
    }

    private function getAllFmds()
    {
        $Users = $this->getTableLocator()->get('Users');

        $all_data = $Users->find()->select(['indexfinger', 'middlefinger']);
        $data = json_decode(json_encode($all_data->toArray()), true);

        return $data;
    }

    private function getUserDetails($user_id)
    {
        $Users = $this->getTableLocator()->get('Users');
        $all_data = $Users->find()->select(['username', 'name'])->where(['id' => $user_id]);
        $data = json_encode($all_data->toArray());

        return $data;
    }

    private function getUserFmds($user_id)
    {
        $Users = $this->getTableLocator()->get('Users');
        $all_data = $Users->find()->select(['indexfinger', 'middlefinger'])->where(['id' => $user_id]);
        $data = json_decode(json_encode($all_data->toArray()), true);

        return $data;
    }


    private function enroll_fingerprint($pre_registered_fmd_array)
    {
        $enrollment_url = "http://67.205.172.232:5555/coreComponents/enroll.php";
        $data = ["data" => json_encode($pre_registered_fmd_array)];
        $response = $this->make_request($enrollment_url, $data);

        return $response;
    }


    private function verify_fingerprint($pre_registered_fmd_string, $enrolled_fingers_array)
    {
        $verify_url = "http://67.205.172.232:5555/coreComponents/verify.php";

        $data = [
            "data" => json_encode([
                "pre_enrolled_finger_data" => $pre_registered_fmd_string,
                "enrolled_index_finger_data" => $enrolled_fingers_array['index_finger'],
                "enrolled_middle_finger_data" => $enrolled_fingers_array['middle_finger']
            ])
        ];

        $response = $this->make_request($verify_url, $data);

        return $response;
    }


    private  function is_duplicate_fingerprint($pre_registered_fmd_string, $enrolled_hands_array)
    {
        $is_duplicate_url = "http://67.205.172.232:5555/coreComponents/is_duplicate.php";

        $data = [
            "data" => json_encode(
                [
                    "pre_enrolled_finger_data" => $pre_registered_fmd_string,
                    "enrolled_hands_list" => $enrolled_hands_array
                ]
            )
        ];

        $response = $this->make_request($is_duplicate_url, $data);

        return $response;
    }

    private  function make_request($url, $data)
    {
        $http = new Client();

        $response = $http->post(
            $url,
            $data,
            ['headers' => ['Content-Type' => 'application/x-www-form-urlencoded']]
        );

        return $response->getStringBody();
    }
}
