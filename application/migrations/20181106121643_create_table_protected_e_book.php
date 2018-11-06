<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_users
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_create_table_protected_e_book extends CI_Migration {

    protected $table = 'protected_e_book';


    public function up()
    {
        $fields = array(
            'id_protected_e_book' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'usuario_idusuario'      => array(
                'type'   => 'INT(11)',
            ),
            'e_book_ide_book'   => array(
                'type' => 'INT(11)',
            ),
            'e_book_path'  => array(
                'type' => 'VARCHAR(255)',
                'unique' => TRUE
            ),
            'created_at' => array(
                'type' => 'DATETIME',
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id_protected_e_book', TRUE);
        $this->dbforge->create_table($this->table, TRUE);
        $this->load->helper('db_helper');
        $this->db->query(add_foreign_key($this->table, 'usuario_idusuario', 'usuario(idusuario)'));
        $this->db->query(add_foreign_key($this->table, 'e_book_ide_book', 'e_book(ide_book)'));

        /*
        $this->load->helper('date');
        for($i=1; $i<=100; $i++) {
            $this->db->insert($this->table, array(
                'email'      => "user-{$i}@mail.com",
                'password'   => password_hash('codeigniter', PASSWORD_DEFAULT),
                'username'  => "Username {$i}",
                'nome'   => "Lastname {$i}",
                'created_at' => now(),
                'updated_at' => now()
            ));
        };*/
    }


    public function down()
    {
        if ($this->db->table_exists($this->table))
        {
            $this->dbforge->drop_table($this->table);
        }
    }

}
