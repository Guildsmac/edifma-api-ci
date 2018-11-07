<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_users
 *
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_create_table_logs extends CI_Migration
{
    protected $table = 'logs';

    public function up()
    {
        $fields = array(
            'idlog' => array(
                'type' => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned' => TRUE,
            ),
            'uri' => array(
                'type' => 'varchar(255)',

            ),
            'method' => array(
                'type' => 'varchar(6)',

            ),
            'params' => array(
                'type' => 'text',

            ),
            'api_key' => array(
                'type' => 'varchar(64)',

            ),
            'ip_address' => array(
                'type' => 'varchar(45)',

            ),
            'time' => array(
                'type' => 'INT(11)',

            ),
            'rtime' => array(
                'type' => 'float',
                'null' => TRUE,
                'default' => null
            ),
            'authorized' => array(
                'type' => 'varchar(1)'
            ),
            'response_code' => array(
                'type' => 'smallint(3)',
                'default' => '0'
            )
        );
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('idlog', TRUE);
        $this->dbforge->create_table($this->table, TRUE, $attributes);

    }

    public function down()
    {
        if ($this->db->table_exists($this->table)) {
            $this->dbforge->drop_table($this->table);
        }
    }

}