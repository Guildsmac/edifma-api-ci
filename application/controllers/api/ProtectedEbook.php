<?php
/**
 * Copyright (c) 2019.
 * Developed by Gabriel Sousa
 * @author Gabriel Sousa <gabrielssc.ti@gmail.com>
 * Last modified 15/12/18 15:53.
 *
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

use Restserver\Libraries\REST_Controller;

class ProtectedEbook extends REST_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['protected_ebook_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['protected_ebook_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['protected_ebook_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function protected_ebooks_get(){
        $this->load->database();
        $this->load->model('ProtectedEbook_model', '', true);
        $protected_ebooks = $this->ProtectedEbook_model->get_protected_ebooks();
        $id = $this->get('id');
        if($id===NULL){
            if($protected_ebooks)
                $this->response($protected_ebooks, REST_Controller::HTTP_OK);
            else
                $this->response(array(
                    'status' => FALSE,
                    'message'=> 'Nenhum livro protegido encontrando'
                ), REST_Controller::HTTP_NOT_FOUND);
        }
        $id = (int)$id;
        if($id<=0)
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        $protected_ebook = NULL;
        if(!empty($protected_ebooks))
            foreach($protected_ebooks as $key => $value)
                if(isset($value->id_protected_e_book) && $value->id_protected_e_book == $id)
                    $protected_ebook = $value;
        if(!empty($protected_ebook)) {
            $this->set_response($protected_ebook, REST_Controller::HTTP_OK);
        }
        else
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Livro protegido não pôde ser achado'
            ), REST_Controller::HTTP_NOT_FOUND);
    }

    public function protected_ebooks_post() {
        $success = false;
        if($this->post('usuario_idusuario') && $this->post('e_book_ide_book')){
            $this->load->model('ProtectedEbook_model', '', true);
            $success = $this->ProtectedEbook_model->insert_protected_ebook($this);
            $temp = explode('/', $_SERVER['REQUEST_URI']);
            $temp = $temp[1];
            $success = 'http://'.$_SERVER['HTTP_HOST'] . substr($success, strlen($temp), strlen($success));
            $this->response(array('status' => TRUE, 'message' => array('downloadable_path' => $success, 'filename' => basename($success))));

        }else
            $this->response(array('status' => FALSE,'message' => 'Erro ao criar livro. Tente novamente mais tarde'), REST_Controller::HTTP_NOT_FOUND);
        if($success)
            $this->set_response(array('message' => 'Livro protegido criado'));
        else
            $this->set_response(array('status' => FALSE, 'message' => 'Livro não pôde ser criado. Tente novamente mais tarde'), REST_Controller::HTTP_NOT_FOUND);

    }

}