<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pengirim_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'penerima_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tempat_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true], // Context of the chat (which UMKM)
            'pesan'       => ['type' => 'TEXT'],
            'is_read'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pengirim_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('penerima_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('chats');
    }

    public function down()
    {
        $this->forge->dropTable('chats');
    }
}
