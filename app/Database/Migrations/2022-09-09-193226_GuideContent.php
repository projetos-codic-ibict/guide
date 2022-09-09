<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GuideContent extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ct' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ct_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'ct_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ct_section' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_ct', true);
        $this->forge->addForeignKey('ct_section', 'guide_section', 'ct_seq');
        $this->forge->createTable('guide_content');
    }

    public function down()
    {
        $this->forge->dropTable('guide_content');
    }
}
