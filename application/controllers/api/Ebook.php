<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

use Restserver\Libraries\REST_Controller;

class Ebook extends REST_Controller{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['ebooks_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['ebooks_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['ebooks_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function ebooks_get(){
        $this->load->database();
        $this->load->model('ebook_model', '', true);
        $ebooks = $this->usuario_model->get_ebooks();
        $id = $this->get('id');

        if($id === NULL){
            if($ebooks)
                $this->response($ebooks, REST_Controller::HTTP_OK);
            else
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Não foram achados ebooks'
                ), REST_Controller::HTTP_NOT_FOUND);
        }

        $id = (int)$id;
        if($id<=0)
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        $ebook = null;
        if(!empty($ebooks))
            foreach($ebooks as $key => $value)
                if(isset($value->ide_book) && $value->ide_book == $id)
                    $user = $value;
        if(!empty($user))
            $this->set_response($user, REST_Controller::HTTP_OK);
        else
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'eBook não pôde ser achado'
            ), REST_Controller::HTTP_NOT_FOUND);
    }

    public function ebooks_post(){
        $success =false;
        if($this->post('book_path') && $this->post('opf_path') && $this->post('icon_img_path')){
            $this->load->model('ebook_model', '', true);
            $success = $this->ebook_model->insert_ebook($this);
        }else
            $this->response(array('status' => FALSE, 'message' => 'Preencha todos os dados'));
        if($success)
            $this->set_response(array('message' => 'eBook criado'));
        else
            $this->set_response(array('status' => FALSE, 'message' => 'Não foi possível criar o eBook'));


    }
}