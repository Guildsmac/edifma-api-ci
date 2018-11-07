<?php

class Usuario_model extends CI_Model{
    public $nome;
    public $username;
    public $email;
    public $cpf;
    public $senha;
    public $created_at;
    public $updated_at;

    public function get_users($columns = array(), $conditions = array(), $order = ''){
        $this->db->where($conditions); // e.g: array('idusuario <=' => 20, 'nome =' => john, ...);
        $this->db->select($columns); // e.g: array('idusuario', 'nome', 'username');
        $this->db->order_by($order); // e.g: 'idusuario DESC';
        return $this->db->get('usuario')->result();

    }

    public function insert_user($data){
        $this->nome = $data->post('nome');
        $this->username = strtolower($data->post('username'));
        $this->email = strtolower($data->post('email'));
        $this->cpf = strtolower($data->post('cpf'));
        $this->senha = password_hash($data->post('password'), PASSWORD_BCRYPT);
        $this->created_at = Date('YmdGis');
        $this->updated_at = Date('YmdGis');
        if($this->db->insert('usuario', $this))
            return true;
        return false;

    }

}