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
        $builder->whereIn('kategori.nama_kategori', ['Makanan Berat', 'Jajanan Tradisional', 'Minuman Tradisional', 'Oleh-Oleh']);
        
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

    public function show($id = null)
    {
        $data = $this->tempatModel->find($id);
        if ($data) {
            return $this->respond(['status' => 200, 'message' => 'Berhasil mengambil data', 'data' => $data], 200);
        }
        return $this->failNotFound('Data tidak ditemukan');
    }

    public function create()
    {
        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'kategori_id' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'kategori_id' => $this->request->getVar('kategori_id'),
            'lat' => $this->request->getVar('lat'),
            'lng' => $this->request->getVar('lng'),
            'user_id' => 1, // Default owner untuk API
            'status' => 'approved' // Auto approve untuk API
        ];

        $this->tempatModel->insert($data);
        return $this->respondCreated(['status' => 201, 'message' => 'Data berhasil ditambahkan', 'data' => $data]);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        
        if (!$this->tempatModel->find($id)) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $this->tempatModel->update($id, $data);
        return $this->respond(['status' => 200, 'message' => 'Data berhasil diupdate']);
    }

    public function delete($id = null)
    {
        $data = $this->tempatModel->find($id);
        if ($data) {
            $this->tempatModel->delete($id);
            return $this->respondDeleted(['status' => 200, 'message' => 'Data berhasil dihapus']);
        }
        return $this->failNotFound('Data tidak ditemukan');
    }

    public function docs()
    {
        // View terpisah untuk dokumentasi endpoint API (Tidak butuh API Key)
        return view('v_api_docs');
    }
}
