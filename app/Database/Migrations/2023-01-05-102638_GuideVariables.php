<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class GuideVariables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_v' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'v_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'v_value' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'v_pj' => [
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
        $this->forge->addKey('id_v', true);
        $this->forge->createTable('guide_variables');
    }

    public function down()
    {
        $this->forge->dropTable('guide_variables');
    }
}
