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
class Migration_create_table_usuario extends CI_Migration {


    protected $table = 'usuario';


    public function up()
    {
        $fields = array(
            'idusuario' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'nome'   => array(
                'type' => 'VARCHAR(255)',

            ),
            'username'  => array(
                'type' => 'VARCHAR(32)',
                'unique' => TRUE
            ),
            'email'      => array(
                'type'   => 'VARCHAR(255)',
                'unique' => TRUE,
            ),
            'cpf'      => array(
                'type'   => 'VARCHAR(255)',
                'unique' => TRUE,
            ),
            'password'   => array(
                'type' => 'VARCHAR(64)',
            ),
            'created_at' => array(
                'type' => 'DATETIME',
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('idusuario', TRUE);
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
