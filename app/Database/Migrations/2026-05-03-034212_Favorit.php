<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Favorit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tempat_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tempat_id', 'tempat_kuliner', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('favorit');
    }

    public function down()
    {
        $this->forge->dropTable('favorit');
    }
}
