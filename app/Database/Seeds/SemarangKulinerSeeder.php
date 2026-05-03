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
            'Warteg' => 1,
            'Kafe' => 2,
            'Street Food' => 3,
            'Minuman' => 4,
            'Restoran' => 5
        ];

        $kulinerData = [
            [
                'nama' => 'Lumpia Gang Lombok',
                'alamat' => 'Gang Lombok No.11, Purwodinatan, Semarang Tengah',
                'deskripsi' => 'Lumpia paling legendaris di Semarang, resep asli turun-temurun sejak ratusan tahun lalu.',
                'kategori' => 'Street Food',
                'lat' => -6.974950,
                'lng' => 110.428780,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Rasanya otentik banget, rebungnya gak bau sama sekali!'],
                    ['rating' => 4, 'text' => 'Antrinya panjang, tapi sepadan dengan rasanya.']
                ]
            ],
            [
                'nama' => 'Toko Oen Semarang',
                'alamat' => 'Jl. Pemuda No.52, Bangunharjo, Semarang Tengah',
                'deskripsi' => 'Restoran peninggalan Belanda yang menyajikan es krim klasik dan hidangan Eropa kuno.',
                'kategori' => 'Restoran',
                'lat' => -6.975760,
                'lng' => 110.420650,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Vibesnya klasik banget, es krimnya juara.'],
                    ['rating' => 5, 'text' => 'Nostalgia tempo dulu, pelayanannya ramah.']
                ]
            ],
            [
                'nama' => 'Tahu Gimbal Pak Edy',
                'alamat' => 'Jl. Menteri Supeno, Mugassari, Semarang Selatan (Taman KB)',
                'deskripsi' => 'Tahu gimbal paling hits di Semarang dengan porsi besar dan bumbu kacang yang kental.',
                'kategori' => 'Street Food',
                'lat' => -6.993070,
                'lng' => 110.418430,
                'reviews' => [
                    ['rating' => 4, 'text' => 'Gimbal udangnya kriuk, bumbunya pas.'],
                    ['rating' => 5, 'text' => 'Porsinya gede banget, ngenyangin!']
                ]
            ],
            [
                'nama' => 'Soto Bangkong',
                'alamat' => 'Jl. Brigjen Katamso No.1, Peterongan, Semarang Selatan',
                'deskripsi' => 'Soto ayam khas Semarang dengan kuah bening kecoklatan yang gurih mantap.',
                'kategori' => 'Restoran',
                'lat' => -6.996190,
                'lng' => 110.430930,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Soto paling favorit kalau ke Semarang.'],
                    ['rating' => 4, 'text' => 'Sate kerangnya enak banget dicampur soto.']
                ]
            ],
            [
                'nama' => 'Nasi Ayam Bu Wido',
                'alamat' => 'Jl. Melati Selatan, Brumbungan, Semarang Tengah',
                'deskripsi' => 'Nasi ayam legendaris dengan kuah opor yang gurih manis khas Semarang.',
                'kategori' => 'Street Food',
                'lat' => -6.981880,
                'lng' => 110.423980,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Bumbu opornya kental dan meresap.'],
                    ['rating' => 5, 'text' => 'Selalu rame, rasa ayam suwirnya enak parah.']
                ]
            ],
            [
                'nama' => 'Mie Kopyok Pak Dhuwur',
                'alamat' => 'Jl. Tanjung No.18A, Pandansari, Semarang Tengah',
                'deskripsi' => 'Kuliner mie rebus khas Semarang dengan taburan kerupuk karak dan tahu.',
                'kategori' => 'Street Food',
                'lat' => -6.979060,
                'lng' => 110.414430,
                'reviews' => [
                    ['rating' => 4, 'text' => 'Segar dan murah meriah.'],
                    ['rating' => 5, 'text' => 'Karaknya bikin tekstur mienya jadi unik.']
                ]
            ],
            [
                'nama' => 'Gulai Kambing Bustaman Pak Sabar',
                'alamat' => 'Tanjung Mas, Semarang Utara, Kota Semarang',
                'deskripsi' => 'Gulai kambing tanpa santan, dimasak dengan bumbu serundeng kelapa sangrai.',
                'kategori' => 'Restoran',
                'lat' => -6.966450,
                'lng' => 110.427770,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Empuk banget dagingnya, kuahnya ngaldu.']
                ]
            ],
            [
                'nama' => 'Nasi Goreng Babat Pak Karmin Mberok',
                'alamat' => 'Jl. Pemuda No.2, Dadapsari, Semarang Utara',
                'deskripsi' => 'Nasi goreng babat gongso paling terkenal di dekat jembatan Mberok.',
                'kategori' => 'Street Food',
                'lat' => -6.970100,
                'lng' => 110.426210,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Babatnya empuk dan bumbu gongsonya meresap!'],
                    ['rating' => 4, 'text' => 'Harganya lumayan, tapi worth it.']
                ]
            ],
            [
                'nama' => 'Leker Paimo',
                'alamat' => 'Jl. Karang Anyar No.37, Brumbungan, Semarang Tengah',
                'deskripsi' => 'Jajanan leker legendaris di depan SMA Loyola dengan topping melimpah.',
                'kategori' => 'Street Food',
                'lat' => -6.985550,
                'lng' => 110.425890,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Topping sosis mozarellanya gila banget!'],
                    ['rating' => 4, 'text' => 'Antrinya bisa berjam-jam, harus sabar.']
                ]
            ],
            [
                'nama' => 'Tahu Pong Gajah Mada',
                'alamat' => 'Jl. Gajahmada No.63B, Kembangsari, Semarang Tengah',
                'deskripsi' => 'Tahu pong komplit dengan emplek dan gimbal udang plus kuah petis.',
                'kategori' => 'Restoran',
                'lat' => -6.981840,
                'lng' => 110.421500,
                'reviews' => [
                    ['rating' => 4, 'text' => 'Tahu pongnya garing, petisnya juara.']
                ]
            ],
            [
                'nama' => 'Nasi Pecel Mbok Sador',
                'alamat' => 'Jl. Pahlawan, Pleburan, Semarang Selatan',
                'deskripsi' => 'Pecel legendaris di area Simpang Lima yang buka sampai malam.',
                'kategori' => 'Street Food',
                'lat' => -6.992680,
                'lng' => 110.421520,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Bumbu pecelnya mantap, mendoannya anget terus.']
                ]
            ],
            [
                'nama' => 'Bakmi Jowo Pak Gareng',
                'alamat' => 'Jl. Wotgandul Dalam No.43, Gabahan, Semarang Tengah',
                'deskripsi' => 'Bakmi jawa rebus/goreng yang dimasak di atas anglo arang tradisional.',
                'kategori' => 'Restoran',
                'lat' => -6.978580,
                'lng' => 110.423980,
                'reviews' => [
                    ['rating' => 4, 'text' => 'Aroma asap arangnya bikin rasanya khas.']
                ]
            ],
            [
                'nama' => 'Sate Kambing 29',
                'alamat' => 'Jl. Letjen Suprapto No.29, Tanjung Mas, Semarang Utara (Kota Lama)',
                'deskripsi' => 'Sate kambing dan buntel empuk yang melegenda di kawasan Kota Lama.',
                'kategori' => 'Restoran',
                'lat' => -6.968030,
                'lng' => 110.427840,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Sate buntelnya luar biasa enak.']
                ]
            ],
            [
                'nama' => 'Ayam Goreng Kampung Kali',
                'alamat' => 'Jl. Mayor Jend. D.I. Panjaitan No.45, Miroto, Semarang Tengah',
                'deskripsi' => 'Ayam goreng kampung bumbu rempah dengan sambal bajak yang khas.',
                'kategori' => 'Restoran',
                'lat' => -6.983990,
                'lng' => 110.418720,
                'reviews' => [
                    ['rating' => 4, 'text' => 'Ayamnya empuk banget sampai ke tulang.']
                ]
            ],
            [
                'nama' => 'Bebek Goreng Pak Ndut',
                'alamat' => 'Jl. Menteri Supeno No.3, Mugassari, Semarang Selatan',
                'deskripsi' => 'Bebek goreng sangan dengan sambal korek yang super pedas.',
                'kategori' => 'Restoran',
                'lat' => -6.990420,
                'lng' => 110.416800,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Pedasnya nampol, bebeknya gak amis.']
                ]
            ],
            [
                'nama' => 'Es Krim Tentrem',
                'alamat' => 'Jl. Jenderal Sudirman No.297, Salamanmloyo, Semarang Barat',
                'deskripsi' => 'Toko es krim jadul asli Semarang yang sudah ada sejak puluhan tahun.',
                'kategori' => 'Minuman',
                'lat' => -6.985060,
                'lng' => 110.388830,
                'reviews' => [
                    ['rating' => 4, 'text' => 'Es krim Tutti Frutti-nya wajib coba.']
                ]
            ],
            [
                'nama' => 'Gudeg Abimanyu',
                'alamat' => 'Jl. Abimanyu VII No.6, Pindrikan Lor, Semarang Tengah',
                'deskripsi' => 'Gudeg khas Semarang yang tidak terlalu manis dengan tambahan daun singkong.',
                'kategori' => 'Restoran',
                'lat' => -6.980640,
                'lng' => 110.407980,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Gudeg langganan keluarga, kreceknya mantap.']
                ]
            ],
            [
                'nama' => 'Tahu Petis Prasojo',
                'alamat' => 'Pusat Kuliner Simpang Lima, Semarang',
                'deskripsi' => 'Gorengan panas dengan isian petis udang hitam yang melimpah dan gurih.',
                'kategori' => 'Street Food',
                'lat' => -6.990080,
                'lng' => 110.422830,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Petisnya manis gurih, pas dimakan pas panas.']
                ]
            ],
            [
                'nama' => 'Mangut Kepala Manyung Bu Fat',
                'alamat' => 'Jl. Ariloka, Krobokan, Semarang Barat',
                'deskripsi' => 'Olahan kepala ikan manyung asap dengan kuah santan pedas luar biasa.',
                'kategori' => 'Restoran',
                'lat' => -6.969180,
                'lng' => 110.388650,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Pedasnya bikin keringetan tapi nagih!']
                ]
            ],
            [
                'nama' => 'Nasi Gandul Pak Subur',
                'alamat' => 'Jl. Kh Ahmad Dahlan, Karangkidul, Semarang Tengah',
                'deskripsi' => 'Nasi gandul asli Pati yang populer di Semarang dengan kuah melimpah.',
                'kategori' => 'Street Food',
                'lat' => -6.986340,
                'lng' => 110.421680,
                'reviews' => [
                    ['rating' => 4, 'text' => 'Daging sapinya empuk, kuahnya mantap pol.']
                ]
            ],
            [
                'nama' => 'Spiegel Bar & Bistro',
                'alamat' => 'Jl. Letjen Suprapto No.34, Tj. Mas, Kec. Semarang Utara (Kota Lama)',
                'deskripsi' => 'Kafe dan bistro bergaya klasik Eropa di gedung peninggalan bersejarah Kota Lama.',
                'kategori' => 'Kafe',
                'lat' => -6.968190,
                'lng' => 110.427500,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Kopinya enak, tempatnya fotogenik banget.']
                ]
            ],
            [
                'nama' => 'AtoZ Bar, Wine & Brasserie',
                'alamat' => 'Jl. Sumbing No.10, Bendungan, Kec. Gajahmungkur',
                'deskripsi' => 'Kafe premium dan fine dining dengan suasana elegan di kawasan Semarang atas.',
                'kategori' => 'Kafe',
                'lat' => -6.998460,
                'lng' => 110.413750,
                'reviews' => [
                    ['rating' => 5, 'text' => 'Pilihan winenya banyak, makanannya fancy.']
                ]
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
        }
    }
}
