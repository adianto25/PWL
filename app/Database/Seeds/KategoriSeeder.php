<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Warteg'],
            ['nama_kategori' => 'Kafe'],
            ['nama_kategori' => 'Street Food'],
            ['nama_kategori' => 'Minuman'],
            ['nama_kategori' => 'Restoran']
        ];
        $this->db->table('kategori')->insertBatch($data);
    }
}
