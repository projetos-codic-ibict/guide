<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class GuideProject extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pj' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pj_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'pj_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'pj_desc' => [
                'type'       => 'TEXT',
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
        $this->forge->addKey('id_pj', true);
        $this->forge->createTable('guide_project');
    }

    public function down()
    {
        $this->forge->dropTable('guide_project');
    }
}
