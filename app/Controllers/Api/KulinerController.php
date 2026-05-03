<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TempatKulinerModel;

class KulinerController extends ResourceController
{
    protected $format = 'json';
    protected $tempatModel;

    public function __construct()
    {
        $this->tempatModel = new TempatKulinerModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        $lat = (float)$this->request->getGet('lat');
        $lng = (float)$this->request->getGet('lng');
        $radius = (float)$this->request->getGet('radius'); // in km

        $builder = $db->table('tempat_kuliner');
        
        if ($lat && $lng && $radius) {
            $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(tempat_kuliner.lat)) * cos(radians(tempat_kuliner.lng) - radians($lng)) + sin(radians($lat)) * sin(radians(tempat_kuliner.lat))))";
            $builder->select("tempat_kuliner.id, tempat_kuliner.nama, tempat_kuliner.alamat, tempat_kuliner.deskripsi, tempat_kuliner.lat, tempat_kuliner.lng, kategori.nama_kategori, users.username as kontributor, $haversine AS jarak_km");
            $builder->having("jarak_km <=", $radius);
            $builder->orderBy("jarak_km", "ASC");
        } else {
            $builder->select('tempat_kuliner.id, tempat_kuliner.nama, tempat_kuliner.alamat, tempat_kuliner.deskripsi, tempat_kuliner.lat, tempat_kuliner.lng, kategori.nama_kategori, users.username as kontributor');
        }

        $builder->join('kategori', 'kategori.id = tempat_kuliner.kategori_id');
        $builder->join('users', 'users.id = tempat_kuliner.user_id');
        $builder->where('tempat_kuliner.status', 'approved');
        
        $data = $builder->get()->getResultArray();

        if (empty($data)) {
            return $this->respond([
                'status' => 404,
                'message' => 'Tidak ada data kuliner ditemukan.',
                'data' => []
            ], 404);
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Berhasil mengambil data kuliner.',
            'total' => count($data),
            'data' => $data
        ], 200);
    }
}
