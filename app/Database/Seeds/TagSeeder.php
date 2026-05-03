<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_tag' => 'Halal'],
            ['nama_tag' => 'Murah'],
            ['nama_tag' => 'AC'],
            ['nama_tag' => 'WiFi'],
            ['nama_tag' => 'Parkir Luas']
        ];
        $this->db->table('tags')->insertBatch($data);
    }
}
