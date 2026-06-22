<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TempatTags extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tempat_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tag_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addForeignKey('tempat_id', 'tempat_kuliner', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tags', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tempat_tags');
    }

    public function down()
    {
        $this->forge->dropTable('tempat_tags');
    }
}
