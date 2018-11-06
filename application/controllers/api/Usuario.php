<?php


defined('BASEPATH') OR exit('No direct script access allowed');

/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

use Restserver\Libraries\REST_Controller;

class Usuario extends REST_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['usuarios_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['usuarios_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['usuarios_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    private function deal_error($error)
    {
        $this->response($error, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function usuarios_get()
    {
        // Users from a data store e.g. database
        $this->load->database();
        $this->load->model('usuario_model', '', true);


        $users = $this->usuario_model->get_users();

        $id = $this->get('id');
        // If the id parameter doesn't exist return all the users
        if ($id === NULL) {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($users) {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response(array(
                    'status' => FALSE,
                    'message' => 'No users were found'
                ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $user = NULL;
        if (!empty($users)) {
            foreach ($users as $key => $value) {
                if (isset($value->idusuario) && $value->idusuario == $id) {
                    $user = $value;
                }
            }
        }
        if (!empty($user)) {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'User could not be found'
            ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function usuarios_post()
    {
        // $this->some_model->update_user( ... );

        if ($this->post('nome') && $this->post('username') &&
            $this->post('email') && $this->post('cpf') &&
            $this->post('password')) {
            $this->load->model('usuario_model', '', true);
            $this->load->helper('email');
            if (valid_email($this->post('email')))
                $this->usuario_model->insert_user($this);

            else
                $this->response(array('message' => 'E-Mail Inválido'), REST_Controller::HTTP_BAD_REQUEST);
        } else
            $this->response(array('message' => 'Preencha todos os dados'), REST_Controller::HTTP_BAD_REQUEST);
        $this->set_response(array('message' => 'Usuário criado'), REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }
/*
    public function users_delete()
    {
        $id = (int)$this->get('id');
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // $this->some_model->delete_something($id);
        $message = array(
            'id' => $id,
            'message' => 'Deleted the resource'
        );
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }*/
}