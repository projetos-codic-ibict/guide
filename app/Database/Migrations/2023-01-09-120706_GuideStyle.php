<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class GuideStyle extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_css' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'css_project' => [
                'type'       => 'INT',
            ],
            'css_class' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'css_code' => [
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
        $this->forge->addKey('id_css', true);
        $this->forge->createTable('guide_style');
    }

    public function down()
    {
        $this->forge->dropTable('guide_style');
    }
}
