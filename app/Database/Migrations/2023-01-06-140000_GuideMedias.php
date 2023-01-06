<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class GuideMedias extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_i' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'i_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'i_value' => [
                'type'       => 'TEXT',
            ],
            'i_contentype' => [
                'type'       => 'VARCHAR',
                'constraint' => '40',
            ],
            'i_size' => [
                'type'       => 'DOUBLE',
                'default'=>0,
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
        $this->forge->addKey('id_i', true);
        $this->forge->createTable('guide_midias');
    }

    public function down()
    {
        $this->forge->dropTable('guide_midias');
    }
}
