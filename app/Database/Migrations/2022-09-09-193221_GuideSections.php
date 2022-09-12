<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GuideSections extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sc' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'sc_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'sc_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'sc_seq' => [
                'type' => 'INT',
                'null' => true,
            ],
            'sc_father' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_sc', true);
        $this->forge->createTable('guide_section');
    }

    public function down()
    {
        $this->forge->dropTable('guide_section');
    }
}
