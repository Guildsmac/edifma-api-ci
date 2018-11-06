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
class Migration_create_table_e_book extends CI_Migration {


    protected $table = 'e_book';


    public function up()
    {
        $fields = array(
            'ide_book'         => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'book_path'      => array(
                'type'   => 'VARCHAR(255)',
                'unique' => TRUE,
            ),
            'opf_path'   => array(
                'type' => 'VARCHAR(255)',
            ),
            'icon_img_path'  => array(
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
        $this->dbforge->add_key('ide_book', TRUE);
        $this->dbforge->create_table($this->table, TRUE);

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
