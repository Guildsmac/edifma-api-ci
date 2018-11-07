<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_users
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */

class Migration_create_table_keys extends CI_Migration{
    protected $table = 'keys';

    public function up(){
        $fields = array(
            'idkey' => array(
                'type' => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned' => TRUE,
            ),
            'key' => array(
                'type' => 'varchar(64)',

            ),
            'level' => array(
                'type' => 'INT(2)',

            ),
            'ignore_limits' => array(
                'type' => 'tinyint(1)',
                'default' => '0',

            ),
            'is_private_key' => array(
                'type' => 'tinyint(1)',
                'default' => '0',

            ),
            'ip_addresses' => array(
                'type' => 'text',
                'null' => TRUE
            ),
            'date_created' => array(
                'type' => 'INT(11)',

            )
        );
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('idkey', TRUE);
        $this->dbforge->create_table($this->table, TRUE, $attributes);

    }
    public function down()
    {
        if ($this->db->table_exists($this->table))
        {
            $this->dbforge->drop_table($this->table);
        }
    }

}