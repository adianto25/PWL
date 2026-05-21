<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SemarangKulinerSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan data lama
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('reviews')->truncate();
        $this->db->table('tempat_tags')->truncate();
        $this->db->table('tempat_fotos')->truncate();
        $this->db->table('favorit')->truncate();
        $this->db->table('tempat_kuliner')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $kategoriMap = [
            'Makanan Berat'       => 1,
            'Jajanan Tradisional' => 2,
            'Oleh-Oleh'           => 3,
            'Minuman Tradisional' => 4,
        ];

        $kulinerData = [
            // --- MAKANAN BERAT ---
            [
                'nama' => 'Kepala Manyung Bu Fat',
                'alamat' => 'Jl. Ariloka No.28, Krobokan',
                'deskripsi' => 'Mangut kepala ikan manyung asap super pedas dengan kuah santan kental khas Semarang.',
                'kategori' => 'Makanan Berat', 'lat' => -6.97350, 'lng' => 110.39676, 'foto' => 'kepala-manyung-bu-fat.jpg'
            ],
            [
                'nama' => 'Tahu Gimbal Pak H. Edy',
                'alamat' => 'Jl. Menteri Supeno, Mugassari',
                'deskripsi' => 'Perpaduan tahu goreng, gimbal udang, dan kol dengan siraman bumbu kacang petis yang melimpah.',
                'kategori' => 'Makanan Berat', 'lat' => -6.99168, 'lng' => 110.42026, 'foto' => 'tahu-gimbal-pa-edy.jpg'
            ],
            [
                'nama' => 'Soto Ayam Bangkong',
                'alamat' => 'Jl. Brigjen Katamso No.1, Karangtempel',
                'deskripsi' => 'Soto ayam legendaris dengan kuah bening kecokelatan, disajikan dengan aneka sate-satean.',
                'kategori' => 'Makanan Berat', 'lat' => -6.99441, 'lng' => 110.43243, 'foto' => 'soto-bangkong.jpg'
            ],
            [
                'nama' => 'Mie Kopyok Pak Dhuwur',
                'alamat' => 'Jl. Tanjung No.18, Pandansari',
                'deskripsi' => 'Kuliner merakyat berisi mie, lontong, dan tahu dengan kuah bawang putih yang segar.',
                'kategori' => 'Makanan Berat', 'lat' => -6.97626, 'lng' => 110.41628, 'foto' => 'mie_kopyok.jpeg'
            ],
            [
                'nama' => 'Nasi Ayam Pak Supar',
                'alamat' => 'Jl. Moh. Suyudi No.48, Miroto',
                'deskripsi' => 'Nasi gurih khas Semarang dengan sop buntut, sayur labu siam, dan krecek yang lembut.',
                'kategori' => 'Makanan Berat', 'lat' => -6.98258, 'lng' => 110.41882, 'foto' => 'ayam-goreng-pa-supar.jpg'
            ],

            // --- JAJANAN TRADISIONAL ---
            [
                'nama' => 'Lekker Paimo',
                'alamat' => 'Jl. Karang Anyar No.37, Brumbungan',
                'deskripsi' => 'Kue lekker paling hits di Semarang dengan berbagai isian mulai dari cokelat hingga sosis keju.',
                'kategori' => 'Jajanan Tradisional', 'lat' => -6.98184, 'lng' => 110.42908, 'foto' => 'lekker-paimo.jpg'
            ],
            [
                'nama' => 'Tahu Pong Gajah Mada',
                'alamat' => 'Jl. Gajahmada No.63B',
                'deskripsi' => 'Tahu goreng kopong yang dicelupkan ke bumbu kecap petis encer dan acar mentimun.',
                'kategori' => 'Jajanan Tradisional', 'lat' => -6.97802, 'lng' => 110.42073, 'foto' => 'tahu-pong.jpg'
            ],
            [
                'nama' => 'Pisang Plenet Pak Yuli',
                'alamat' => 'Jl. Gajahmada (Area kuliner malam)',
                'deskripsi' => 'Pisang kepok yang dipipihkan (diplenet) lalu dibakar dan diberi topping meses atau keju.',
                'kategori' => 'Jajanan Tradisional', 'lat' => -6.97492, 'lng' => 110.42011, 'foto' => 'pisang-plenet.jpg'
            ],
            [
                'nama' => 'Babat Gongso Pak Karmin',
                'alamat' => 'Jl. Pemuda (Dekat Jembatan Mberok)',
                'deskripsi' => 'Tumisan babat dengan bumbu kecap manis pedas yang sangat meresap.',
                'kategori' => 'Jajanan Tradisional', 'lat' => -6.96214, 'lng' => 110.41763, 'foto' => 'babat-gongso.jpg'
            ],
            [
                'nama' => 'Kue Moaci Gemini',
                'alamat' => 'Jl. Kentangan Barat No.101',
                'deskripsi' => 'Kue moci kenyal isi kacang tanah dengan baluran wijen atau tepung.',
                'kategori' => 'Jajanan Tradisional', 'lat' => -6.9752, 'lng' => 110.4255, 'foto' => 'moci-gemini.jpg'
            ],

            // --- OLEH-OLEH ---
            [
                'nama' => 'Lumpia Gang Lombok',
                'alamat' => 'Jl. Gang Lombok No.11, Purwodinatan',
                'deskripsi' => 'Warung lumpia tertua di Semarang dengan isian rebung dan udang yang otentik.',
                'kategori' => 'Oleh-Oleh', 'lat' => -6.9739, 'lng' => 110.4239, 'foto' => 'lumpia-lombok.jpg'
            ],
            [
                'nama' => 'Wingko Babat Cap Kereta Api',
                'alamat' => 'Jl. Cendrawasih No.10, Purwodinatan',
                'deskripsi' => 'Wingko babat paling legendaris dengan tekstur empuk dan rasa kelapa yang kuat.',
                'kategori' => 'Oleh-Oleh', 'lat' => -6.9675, 'lng' => 110.4280, 'foto' => 'wingko-ka.jpg'
            ],
            [
                'nama' => 'Bandeng Juwana Elrina',
                'alamat' => 'Jl. Pandanaran No.57, Mugassari',
                'deskripsi' => 'Pusat oleh-oleh bandeng presto terbesar dan terlengkap di Semarang.',
                'kategori' => 'Oleh-Oleh', 'lat' => -6.9835, 'lng' => 110.4135, 'foto' => 'bandeng-juwana.jpg'
            ],
            [
                'nama' => 'Ganjel Rel Masjuki',
                'alamat' => 'Jl. Raden Patah No.165',
                'deskripsi' => 'Roti tradisional padat rempah wijen yang mulai langka, dijaga kelestariannya oleh UMKM lokal.',
                'kategori' => 'Oleh-Oleh', 'lat' => -6.9654, 'lng' => 110.4356, 'foto' => 'ganjel-rel.jpg'
            ],
            [
                'nama' => 'Brillian Super Cake',
                'alamat' => 'Jl. Simpang Lima (Ruko Simpang Lima)',
                'deskripsi' => 'Lapis mandarin khas Semarang dengan tekstur super lembut dan tahan lama.',
                'kategori' => 'Oleh-Oleh', 'lat' => -6.9895, 'lng' => 110.4220, 'foto' => 'brillian-cake.jpg'
            ],

            // --- MINUMAN TRADISIONAL ---
            [
                'nama' => 'Es Conglik Ahmad Dahlan',
                'alamat' => 'Jl. KH Ahmad Dahlan No.11',
                'deskripsi' => 'Es puter tradisional dengan santan asli dan potongan buah segar.',
                'kategori' => 'Minuman Tradisional', 'lat' => -6.9904, 'lng' => 110.4243, 'foto' => 'es-conglik.jpg'
            ],
            [
                'nama' => 'Wedang Tahu Pak Pardi',
                'alamat' => 'Jl. Setiabudi, Srondol Banyumanik',
                'deskripsi' => 'Minuman jahe hangat berisi kembang tahu yang sangat lembut.',
                'kategori' => 'Minuman Tradisional', 'lat' => -7.0520, 'lng' => 110.4080, 'foto' => 'wedang-tahu.jpg'
            ],
            [
                'nama' => 'Es Mareme',
                'alamat' => 'Jl. KH Wahid Hasyim, Kranggan',
                'deskripsi' => 'Es campur legendaris Semarang dengan isian cincau, kelapa, dan sirup rahasia.',
                'kategori' => 'Minuman Tradisional', 'lat' => -6.9765, 'lng' => 110.4210, 'foto' => 'es-mareme.jpg'
            ],
            [
                'nama' => 'Wedang Kacang Kapuran',
                'alamat' => 'Jl. Kapuran, Semarang Tengah',
                'deskripsi' => 'Sajian kuah jahe hangat dengan kacang tanah yang dimasak hingga sangat empuk.',
                'kategori' => 'Minuman Tradisional', 'lat' => -6.9740, 'lng' => 110.4180, 'foto' => 'wedang-kacang.jpg'
            ],
            [
                'nama' => 'Es Pankuk Pak Yono',
                'alamat' => 'Jl. Tanjung No.18',
                'deskripsi' => 'Es puter yang disajikan dengan irisan kue pancake tipis di atasnya.',
                'kategori' => 'Minuman Tradisional', 'lat' => -6.9788, 'lng' => 110.4133, 'foto' => 'es-pankuk.jpg'
            ],
        ];

        $userId = 2; $reviewerId = 1;
        $tagIds = [];
        $tagsResult = $this->db->query("SELECT id FROM tags")->getResultArray();
        foreach($tagsResult as $t) { $tagIds[] = $t['id']; }

        foreach ($kulinerData as $data) {
            $this->db->table('tempat_kuliner')->insert([
                'user_id' => $userId,
                'nama' => $data['nama'],
                'alamat' => $data['alamat'],
                'deskripsi' => $data['deskripsi'],
                'kategori_id' => $kategoriMap[$data['kategori']] ?? 1,
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'status' => 'approved',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $tempatId = $this->db->insertID();

            // Insert 1 review dummy agar tidak kosong
            $this->db->table('reviews')->insert([
                'tempat_id' => $tempatId,
                'user_id' => $reviewerId,
                'rating' => 5,
                'review_text' => 'Rekomendasi banget kalau lagi mampir ke Semarang!',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Assign foto
            $this->db->table('tempat_fotos')->insert([
                'tempat_id' => $tempatId,
                'foto_path' => 'NiceAdmin/assets/img/' . $data['foto']
            ]);
        }
    }
}