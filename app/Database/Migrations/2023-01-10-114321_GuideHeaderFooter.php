<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class GuideHeaderFooter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_hd' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'hd_project' => [
                'type'       => 'INT',
            ],
            'hd_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'hd_code' => [
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
        $this->forge->addKey('id_hd', true);
        $this->forge->createTable('guide_header_foot');
    }

    public function down()
    {
        $this->forge->dropTable('guide_header_foot');
    }
}
