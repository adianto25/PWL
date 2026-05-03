<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TempatSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $baseLat = -6.9829;
        $baseLng = 110.4091;
        
        $names = ['Warteg', 'Kafe', 'Soto', 'Bakso', 'Mie Ayam', 'Nasi Goreng', 'Sate', 'Pecel', 'Ayam Geprek', 'Seblak'];
        $adjectives = ['Berkah', 'Maju', 'Enak', 'Mantap', 'Ceria', 'Jaya', 'Sedap', 'Nusantara', 'Kampus', 'UDINUS'];
        
        for ($i = 0; $i < 25; $i++) {
            $name = $names[array_rand($names)] . ' ' . $adjectives[array_rand($adjectives)];
            $data[] = [
                'user_id' => 2,
                'nama' => $name,
                'alamat' => 'Jl. Nakula I No.' . ($i+1) . ', Pendrikan Kidul, Semarang',
                'deskripsi' => 'Tempat makan ' . strtolower($name) . ' yang direkomendasikan untuk mahasiswa.',
                'kategori_id' => rand(1, 5),
                'lat' => $baseLat + (rand(-50, 50) / 10000),
                'lng' => $baseLng + (rand(-50, 50) / 10000),
                'status' => 'approved',
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('tempat_kuliner')->insertBatch($data);
    }
}
