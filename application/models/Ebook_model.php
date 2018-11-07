<?php

class Ebook_model extends CI_Model{
    public $book_path;
    public $opf_path;
    public $icon_img_path;
    public $created_at;
    public $updated_at;

    public function get_ebooks($columns = array(), $conditions = array(), $order = ''){
        $this->db->where($conditions); // e.g: array('idusuario <=' => 20, 'nome =' => john, ...);
        $this->db->select($columns); // e.g: array('idusuario', 'nome', 'username');
        $this->db->order_by($order); // e.g: 'idusuario DESC';
        return $this->db->get('e_book')->result();

    }

    public function insert_ebook($data){
        $this->book_path = $data->post('book_path');
        $this->opf_path = $data->post('opf_path');
        $this->icon_img_path = $data->post('icon_img_path');
        $this->created_at = Date('YmdGis');
        $this->updated_at = Date('YmdGis');

        if($this->db->insert('e_book', $this))
            return true;
        return false;

    }

}