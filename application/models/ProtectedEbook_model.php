<?php
/**
 * Created by PhpStorm.
 * User: luisclaudio
 * Date: 07/11/2018
 * Time: 08:21
 */

class ProtectedEbook_model extends CI_Model {
    public $usuario_idusuario;
    public $e_book_ide_book;
    public $e_book_path;
    public $created_at;
    public $updated_at;

    public function get_protected_ebooks($columns = array(), $conditions = array(), $order = ''){
        $this->db->where($conditions); // e.g: array('idusuario <=' => 20, 'nome =' => john, ...);
        $this->db->select($columns); // e.g: array('idusuario', 'nome', 'username');
        $this->db->order_by($order); // e.g: 'idusuario DESC';
        return $this->db->get('protected_e_book')->result();

    }

    public function insert_protected_ebook($data){
        $this->usuario_idusuario = $data->post('usuario_idusuario');
        $this->e_book_ide_book = $data->post('e_book_ide_book');
        //$this->e_book_path = $data->post('e_book_path');
        $user =& get_instance();
        $user->load->model('usuario_model');
        $userResult = $user->usuario_model->get_users(array('nome as Nome', 'email as Email', 'cpf as CPF'),
                                                      array('idusuario =' => $this->usuario_idusuario));
        $userResult = $userResult[0];

        if(empty($userResult)) return false;
        $ebook =& get_instance();
        $ebook->load->model('ebook_model');
        $ebookResult = $ebook->ebook_model->get_ebooks(array('ide_book', 'book_path'), array('ide_book =' => $this->e_book_ide_book));
        $ebookResult = $ebookResult[0];
        if(empty($ebookResult)) return false;
        $result = $this->get_protected_ebooks(array('e_book_path'), array('usuario_idusuario =' => $this->usuario_idusuario, 'e_book_ide_book =' => $this->e_book_ide_book));
        if(!empty($result))
            return $result[0]->e_book_path . '/' . basename($ebookResult->book_path);

        $this->load->library('Manipulador-Ebooks/FolderManipulator');
        $this->load->library('Manipulador-Ebooks/Zipper');
        $this->load->library('Manipulador-Ebooks/DRMInserter');
        $this->load->library('Manipulador-Ebooks/NameManipulator');

        $pathToExtractedeBooks = NameManipulator::normalizePath(FCPATH . 'application/storage/generated_unzipped_eBooks');
        if(!file_exists($pathToExtractedeBooks)) mkdir($pathToExtractedeBooks, 0777);
        $pathToFinaleBooks = NameManipulator::normalizePath(FCPATH . 'application/storage/protected_eBooks');
        if(!file_exists($pathToFinaleBooks)) mkdir($pathToFinaleBooks, 0777);

        $unzippedFolder = NameManipulator::normalizePath(FolderManipulator::getNewFolder($pathToExtractedeBooks, 'ebook'));
        Zipper::unzip($ebookResult->book_path, $unzippedFolder);

        DRMInserter::insertDRM($unzippedFolder, $userResult);
        $newBookFolder = NameManipulator::normalizePath(FolderManipulator::getNewFolder($pathToFinaleBooks, 'ebook'));
        Zipper::zipFolder($unzippedFolder, basename($ebookResult->book_path), $newBookFolder);

        $pathToBook = NameManipulator::invertSlashes($newBookFolder);
        $this->e_book_path = $pathToBook;

        $this->created_at = Date('YmdGis');
        $this->updated_at = Date('YmdGis');
        if($this->db->insert('protected_e_book', $this))
            return $this->e_book_path . '/' . basename($ebookResult->book_path);
        return false;
    }
}