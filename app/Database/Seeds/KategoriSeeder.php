<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('kategori')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            ['nama_kategori' => 'Makanan Berat'],
            ['nama_kategori' => 'Jajanan Tradisional'],
            ['nama_kategori' => 'Oleh-Oleh'],
            ['nama_kategori' => 'Minuman Tradisional']
        ];
        $this->db->table('kategori')->insertBatch($data);
    }
}
