<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SemarangKulinerSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan data lama agar murni hanya data asli
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('reviews')->truncate();
        $this->db->table('tempat_tags')->truncate();
        $this->db->table('tempat_fotos')->truncate();
        $this->db->table('favorit')->truncate();
        $this->db->table('tempat_kuliner')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $kategoriMap = [
            'Makanan Berat' => 1,
            'Jajanan Tradisional' => 2,
            'Oleh-Oleh' => 3,
            'Minuman Tradisional' => 4,
        ];

        $kulinerData = [
            [
                'nama' => 'Kepala Manyung "Warung Kamu"',
                'alamat' => 'Pusat Jajan Jolotundo, Kota Semarang',
                'deskripsi' => 'Olahan Ndas (Kepala) Manyung segar yang dimasak dadakan dengan rempah tanpa MSG, memiliki rasa pedas nan nikmat dengan harga terjangkau.',
                'kategori' => 'Makanan Berat',
                'lat' => -6.985651,
                'lng' => 110.439401,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Bumbunya medok dan pedasnya mantap! Ikan manyungnya sangat segar.'],
                    ['rating' => 4, 'text' => 'Kepala manyungnya besar-besar, porsinya sangat mengenyangkan.']
                ],
                'foto' => 'product-1.jpg'
            ],
            [
                'nama' => 'Ganjel Rel Masjuki',
                'alamat' => 'Kota Semarang',
                'deskripsi' => 'Roti Ganjel Rel otentik khas Semarang dari Bapak Aunil Masjuki. Roti dengan tekstur padat, kaya rempah dan taburan wijen yang nikmat, sering hadir dalam tradisi Dugderan.',
                'kategori' => 'Jajanan Tradisional',
                'lat' => -6.974550,
                'lng' => 110.423719,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Teksturnya pas, rasanya sangat otentik membawa nostalgia Semarang tempo dulu.'],
                    ['rating' => 5, 'text' => 'Aroma rempahnya wangi banget, sangat cocok disantap bersama teh hangat.']
                ],
                'foto' => 'product-2.jpg'
            ],
            [
                'nama' => 'Lumpia Cik Renren',
                'alamat' => 'Kota Semarang',
                'deskripsi' => 'Lumpia rebung dengan cita rasa yang crispy dan renyah garapan Iwan Permana. Tahan lama hingga 30 jam, menjadikannya pilihan tepat untuk oleh-oleh.',
                'kategori' => 'Oleh-Oleh',
                'lat' => -6.983944,
                'lng' => 110.419084,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Kulit lumpianya sangat renyah dan rebungnya sama sekali tidak pesing!'],
                    ['rating' => 4, 'text' => 'Dikirim ke luar kota masih tahan dan teksturnya tetap enak saat dihangatkan.']
                ],
                'foto' => 'product-3.jpg'
            ],
            [
                'nama' => 'Blenyik AMI',
                'alamat' => 'Kota Semarang',
                'deskripsi' => 'Blenyik atau olahan teri nasi segar tangkapan nelayan tanpa campuran ikan lain, karya Dimas Satrio. Memberikan sensasi gurih khas pesisir yang bernostalgia.',
                'kategori' => 'Oleh-Oleh',
                'lat' => -6.963493,
                'lng' => 110.418305,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Teri nasinya utuh dan gurih banget, digoreng pakai telur luar biasa enaknya.'],
                    ['rating' => 5, 'text' => 'Sangat nikmat disantap pakai nasi hangat dan sambal terasi.']
                ],
                'foto' => 'product-4.jpg'
            ],
            [
                'nama' => 'Bandeng Presto "QINA"',
                'alamat' => 'Kota Semarang',
                'deskripsi' => 'Bandeng presto olahan Parasanty Legita menggunakan bandeng segar langsung dari petani, dibumbui rempah pilihan tanpa MSG.',
                'kategori' => 'Oleh-Oleh',
                'lat' => -6.982163,
                'lng' => 110.412497,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Dagingnya sangat lembut dan durinya benar-benar lunak. Bumbunya meresap sampai dalam.'],
                    ['rating' => 4, 'text' => 'Varian pepes bandeng dan otak-otaknya juga juara!']
                ],
                'foto' => 'product-5.jpg'
            ],
            [
                'nama' => 'Tahu Gimbal',
                'alamat' => 'Kawasan Simpang Lima, Kota Semarang',
                'deskripsi' => 'Kuliner khas berisi tahu goreng, lontong, kol, taoge, dan gimbal (udang goreng tepung), disiram dengan bumbu kacang petis pedas manis.',
                'kategori' => 'Makanan Berat',
                'lat' => -6.988089,
                'lng' => 110.422501,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Bumbu petis kacangnya sangat lezat dan kental!'],
                    ['rating' => 4, 'text' => 'Gimbal udangnya crispy. Bikin nagih.']
                ],
                'foto' => 'product-1.jpg'
            ],
            [
                'nama' => 'Soto Ayam Khas Semarang',
                'alamat' => 'Jalan Bangkong, Kota Semarang',
                'deskripsi' => 'Soto ayam berkuah bening gurih segar khas Semarang, disantap lengkap dengan sate telur puyuh, sate kerang, dan gorengan.',
                'kategori' => 'Makanan Berat',
                'lat' => -6.993098,
                'lng' => 110.417255,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Kuahnya bening tapi ngaldu banget. Perasan jeruk nipis bikin makin segar.'],
                    ['rating' => 5, 'text' => 'Sate kerangnya empuk dan bumbunya pas.']
                ],
                'foto' => 'product-2.jpg'
            ],
            [
                'nama' => 'Mie Kopyok',
                'alamat' => 'Jalan Plampitan, Kota Semarang',
                'deskripsi' => 'Olahan mie, lontong, irisan tahu, dan tauge rebus yang disiram kuah bawang putih gurih pedas manis yang masih menggunakan arang saat dimasak.',
                'kategori' => 'Makanan Berat',
                'lat' => -6.979144,
                'lng' => 110.413155,
                'reviews' => [
                    ['rating' => 4, 'text' => 'Sederhana tapi rasa kuah bawang putihnya segar dan nampol.']
                ],
                'foto' => 'product-3.jpg'
            ],
            [
                'nama' => 'Wingko Babat',
                'alamat' => 'Stasiun Tawang, Kota Semarang',
                'deskripsi' => 'Jajanan dan oleh-oleh legendaris memadukan kelapa muda pilihan dan gula, menghadirkan rasa khas legit manis dalam berbagai varian seperti durian dan nangka.',
                'kategori' => 'Oleh-Oleh',
                'lat' => -6.964444,
                'lng' => 110.427778,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Kelapanya terasa banget dan tidak terlalu manis, cocok buat oleh-oleh.']
                ],
                'foto' => 'product-4.jpg'
            ],
            [
                'nama' => 'Tahu Pong',
                'alamat' => 'Kawasan Pecinan, Jalan Gajahmada, Kota Semarang',
                'deskripsi' => 'Tahu kopong yang dihidangkan panas-panas bersama bumbu petis manis pedas dan cocolan acar mentimun yang sangat segar.',
                'kategori' => 'Jajanan Tradisional',
                'lat' => -6.980556,
                'lng' => 110.413889,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Tahunya renyah di luar tapi kopong di dalam, diselup ke petis rasanya luar biasa!'],
                    ['rating' => 4, 'text' => 'Enak disantap panas-panas buat cemilan malam di Semarang.']
                ],
                'foto' => 'product-5.jpg'
            ]
        ];

        $userId = 2; // User kontributor ID
        $reviewerId = 1; // User admin ID as reviewer

        $tagIds = [];
        $tagsResult = $this->db->query("SELECT id FROM tags")->getResultArray();
        foreach($tagsResult as $t) {
            $tagIds[] = $t['id'];
        }

        foreach ($kulinerData as $data) {
            $katId = $kategoriMap[$data['kategori']] ?? 1;

            $this->db->table('tempat_kuliner')->insert([
                'user_id' => $userId,
                'nama' => $data['nama'],
                'alamat' => $data['alamat'],
                'deskripsi' => $data['deskripsi'],
                'kategori_id' => $katId,
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'status' => 'approved',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $tempatId = $this->db->insertID();

            // Insert 2 random tags if available
            if (count($tagIds) >= 2) {
                $randomKeys = array_rand($tagIds, 2);
                $this->db->table('tempat_tags')->insertBatch([
                    ['tempat_id' => $tempatId, 'tag_id' => $tagIds[$randomKeys[0]]],
                    ['tempat_id' => $tempatId, 'tag_id' => $tagIds[$randomKeys[1]]]
                ]);
            }

            // Insert Reviews
            foreach ($data['reviews'] as $rev) {
                $this->db->table('reviews')->insert([
                    'tempat_id' => $tempatId,
                    'user_id' => $reviewerId,
                    'rating' => $rev['rating'],
                    'review_text' => $rev['text'],
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            // Assign foto
            $fotoFile = $data['foto'] ?? 'product-1.jpg';

            $this->db->table('tempat_fotos')->insert([
                'tempat_id' => $tempatId,
                'foto_path' => 'NiceAdmin/assets/img/' . $fotoFile
            ]);
        }
    }
}
