<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

use Restserver\Libraries\REST_Controller;

class Auth extends REST_Controller{

    public function __construct(){
        parent::__construct();

    }

    private function email_exists($email){
        $this->load->database();
        $this->load->model('usuario_model', '', true);
        return $this->usuario_model->get_users(array(), array('email =' => $email));

    }

    private function username_exists($username){
        $this->load->database();
        $this->load->model('usuario_model', '', true);
        return $this->usuario_model->get_users(array(), array('username =' => $username));

    }

    public function index_post(){
        $this->load->helper('email');
        $username = strtolower($this->post('username'));
        $password = strtolower($this->post('password'));
        $isEmail = filter_var($username, FILTER_VALIDATE_EMAIL) !== false;
        $data = null;
        if(empty($username) && empty($password))
            $this->response(array(
                'status' => FALSE,
                'message' => 'Todos os campos devem ser preenchidos.'
            ), REST_Controller::HTTP_NOT_FOUND);
        if(empty($username))
            $this->response(array(
                'status' => FALSE,
                'message' => 'O campo usuário deve ser preenchido.'
            ), REST_Controller::HTTP_NOT_FOUND);
        if(empty($password))
            $this->response(array(
                'status' => FALSE,
                'message' => 'O campo senha deve ser preenchido.'
            ), REST_Controller::HTTP_NOT_FOUND);
        if($isEmail) {
            $data = $this->email_exists($username);
            if (empty($data) | is_null($data))
                $this->response(array(
                    'status' => FALSE,
                    'message' => 'Email informado é inválido.'
                ), REST_Controller::HTTP_NOT_FOUND);
        }
        else {
            $data = $this->username_exists($username);
            if (empty($data) | is_null($data))
                $this->response(array(
                    'status' => FALSE,
                    'message' => 'Nome de usuário informado é inválido.'
                ), REST_Controller::HTTP_NOT_FOUND);
        }
        $data = $data[0];
        if(password_verify($password, $data->senha))
            $this->response(array(
                'status' => TRUE,
                'message' => 'Acesso liberado',
                'payload' => $data
            ), REST_Controller::HTTP_OK);
        else
            $this->response(array(
                'status' => FALSE,
                'message' => 'Senha inválida'
            ), REST_Controller::HTTP_NOT_FOUND);


    }

}