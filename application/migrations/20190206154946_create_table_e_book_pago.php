<?php
/**
 * Copyright (c) 2019.
 * Developed by Gabriel Sousa
 * @author Gabriel Sousa <gabrielssc.ti@gmail.com>
 * Last modified 06/02/19 11:06.
 *
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_users
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_create_table_e_book_pago extends CI_Migration {


    protected $table = 'e_book_pago';


    public function up()
    {
        $fields = array(
            'id_e_book_pago' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'usuario_idusuario'   => array(
                'type'           => 'INT(11)',
                'unsigned'       => TRUE,

            ),
            'e_book_ide_book'  => array(
                'type'           => 'INT(11)',
                'unsigned'       => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id_e_book_pago', TRUE);
        $this->db->query(add_foreign_key($this->table, 'usuario_idusuario', 'usuario(idusuario)'));
        $this->db->query(add_foreign_key($this->table, 'e_book_ide_book', 'e_book(ide_book)'));
        $this->dbforge->create_table($this->table, TRUE);

        /*$this->load->helper('date');
        for($i=1; $i<=100; $i++) {
            $this->db->insert($this->table, array(
                'email'      => "user-{$i}@mail.com",
                'password'   => password_hash('codeigniter', PASSWORD_DEFAULT),
                'username'  => "Username {$i}",
                'nome'   => "Lastname {$i}",
                'cpf' => "CPF {$i}",
                'created_at' => Date('YmdGis'),
                'updated_at' => Date('YmdGis')
            ));
        }*/
    }


    public function down()
    {
        if ($this->db->table_exists($this->table))
        {
            $this->dbforge->drop_table($this->table);
        }
    }

}