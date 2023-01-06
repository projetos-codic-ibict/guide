<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class UserLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ul' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            '	ul_user' => [
                'type'       => 'INT',
            ],
            'ul_ip' => [
                'type'       => 'VARCHAR',
                'constraint'     => 20,
            ],
            'ul_access' => [
                'type'       => 'DATETIME',
            ],
            'i_size' => [
                'type'       => 'DOUBLE',
                'default' => 0,
            ],
            'i_pj' => [
                'type'       => 'INT',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
                'null' => true,
            ],

        ]);
        $this->forge->addKey('id_ul', true);
        $this->forge->createTable('users_log');
    }

    public function down()
    {
        $this->forge->dropTable('users_log');
    }
}
