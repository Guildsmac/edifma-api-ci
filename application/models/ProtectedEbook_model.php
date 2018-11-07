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
        $this->e_book_path = $data->post('e_book_path');
        $this->created_at = Date('YmdGis');
        $this->updated_at = Date('YmdGis');
        if($this->db->insert('protected_e_book', $this))
            return true;
        return false;
    }
}