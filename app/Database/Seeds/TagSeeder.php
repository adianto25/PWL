<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('tags')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            ['nama_tag' => 'Resep Warisan'],
            ['nama_tag' => 'Tanpa Pengawet'],
            ['nama_tag' => 'Halal MUI'],
            ['nama_tag' => 'PIRT'],
            ['nama_tag' => 'Otentik Semarang'],
            ['nama_tag' => 'Bisa COD'],
            ['nama_tag' => 'Gratis Ongkir'],
            ['nama_tag' => 'Kemasan Vakum'],
            ['nama_tag' => 'Bisa Bayar QRIS']
        ];
        $this->db->table('tags')->insertBatch($data);
    }
}
