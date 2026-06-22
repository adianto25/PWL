<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'=>'april',
                'password'=>password_hash('1234567', PASSWORD_DEFAULT),
                'role'=>'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'user1',
                'password' => password_hash('1234567', PASSWORD_DEFAULT),
                'role'     => 'user',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
