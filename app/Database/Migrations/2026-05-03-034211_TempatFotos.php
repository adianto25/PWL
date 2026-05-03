<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TempatFotos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tempat_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'foto_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tempat_id', 'tempat_kuliner', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tempat_fotos');
    }

    public function down()
    {
        $this->forge->dropTable('tempat_fotos');
    }
}
