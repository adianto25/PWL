<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterReviewsAddParentId extends Migration
{
    public function up()
    {
        $fields = [
            'parent_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id' // Put it right after ID
            ],
        ];
        $this->forge->addColumn('reviews', $fields);
        
        // Add foreign key manually because addColumn doesn't support adding FKs directly in the same call in some CI4 versions without executing SQL directly or manipulating keys.
        // It's safer to use raw query for alter table add constraint if needed, or forge's process.
        $this->db->query('ALTER TABLE `reviews` ADD CONSTRAINT `reviews_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `reviews`(`id`) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `reviews` DROP FOREIGN KEY `reviews_parent_id_foreign`');
        $this->forge->dropColumn('reviews', 'parent_id');
    }
}
