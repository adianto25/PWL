<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TempatKulinerModel;
use App\Models\TempatFotoModel;
use App\Models\KategoriModel;
use App\Models\ReviewModel;

class KontributorController extends BaseController
{
    protected $tempatModel;
    protected $fotoModel;
    protected $kategoriModel;
    protected $reviewModel;

    public function __construct()
    {
        $this->tempatModel = new TempatKulinerModel();
        $this->fotoModel = new TempatFotoModel();
        $this->kategoriModel = new KategoriModel();
        $this->reviewModel = new ReviewModel();
        $this->tagModel = new \App\Models\TagModel();
        $this->tempatTagModel = new \App\Models\TempatTagModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $data = [
            'title' => 'Dashboard',
            'tempat_saya' => $this->tempatModel->where('user_id', $userId)->findAll(),
            'total_review' => $this->reviewModel->where('user_id', $userId)->countAllResults()
        ];
        return view('kontributor/v_dashboard', $data);
    }

    public function submit()
    {
        $data = [
            'title' => 'Submit Tempat Kuliner',
            'kategori' => $this->kategoriModel->findAll(),
            'tags' => $this->tagModel->findAll()
        ];
        return view('kontributor/v_submit', $data);
    }

    public function processSubmit()
    {
        // Validasi input
        $rules = [
            'nama' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama tempat/UMKM harus diisi.',
                    'min_length' => 'Nama tempat minimal 3 karakter.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.'
                ]
            ],
            'kategori_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus dipilih.'
                ]
            ],
            'fotos' => [
                'rules' => 'max_size[fotos,2048]|ext_in[fotos,jpg,jpeg,png]|is_image[fotos]',
                'errors' => [
                    'max_size' => 'Ukuran salah satu foto lebih dari 2MB.',
                    'ext_in' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
                    'is_image' => 'File yang diupload harus berupa gambar.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('user_id');
        
        $dataInsert = [
            'user_id' => $userId,
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'lat' => $this->request->getPost('lat'),
            'lng' => $this->request->getPost('lng'),
            'status' => 'pending', // Perlu moderasi admin
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->tempatModel->insert($dataInsert);
        $tempatId = $this->tempatModel->insertID();

        // Handle Tags
        $tags = $this->request->getPost('tags');
        if(!empty($tags) && is_array($tags)) {
            foreach($tags as $tagId) {
                $this->tempatTagModel->insert([
                    'tempat_id' => $tempatId,
                    'tag_id' => $tagId
                ]);
            }
        }

        // Handle File Uploads (max 3)
        $files = $this->request->getFileMultiple('fotos');
        if ($files) {
            $count = 0;
            foreach ($files as $file) {
                if ($count >= 3) break;
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads', $newName);

                    // Resize Image using CI4 Image Library (max 800px)
                    \Config\Services::image()
                        ->withFile(FCPATH . 'uploads/' . $newName)
                        ->resize(800, 800, true, 'auto')
                        ->save(FCPATH . 'uploads/' . $newName);

                    // Create Thumbnail (max 200px)
                    $thumbName = 'thumb_' . $newName;
                    \Config\Services::image()
                        ->withFile(FCPATH . 'uploads/' . $newName)
                        ->resize(200, 200, true, 'auto')
                        ->save(FCPATH . 'uploads/' . $thumbName);

                    $this->fotoModel->insert([
                        'tempat_id' => $tempatId,
                        'foto_path' => $newName
                    ]);
                    $count++;
                }
            }
        }

        return redirect()->to(base_url('kontributor/dashboard'))->with('success', 'Tempat berhasil disubmit dan menunggu moderasi admin.');
    }

    public function geocode()
    {
        $alamatInput = $this->request->getGet('q');
        if (!$alamatInput) return $this->response->setJSON(['error' => 'Alamat kosong']);

        // Clean common Indonesian prefixes that confuse Nominatim
        $cleanAlamat = str_ireplace(['jl.', 'jalan', 'kec.', 'kecamatan', 'kab.', 'kabupaten', 'kota', 'provinsi'], '', $alamatInput);
        $cleanAlamat = trim(preg_replace('/\s+/', ' ', $cleanAlamat));

        // Split by comma
        $parts = explode(',', $cleanAlamat);
        $parts = array_map('trim', $parts);

        $client = \Config\Services::curlrequest([
            'headers' => [
                'User-Agent' => 'KulinerKampusApp/1.0' // Nominatim requires User-Agent
            ]
        ]);

        $queriesToTry = [];
        
        // 1. Try exact input
        $queriesToTry[] = $alamatInput;
        
        // 2. Try cleaned input
        $queriesToTry[] = implode(', ', $parts);
        
        // 3. Progressive broader search (remove the first part repeatedly until 2 parts left)
        // e.g. "Gondoriyo, Ngaliyan, Semarang" -> "Ngaliyan, Semarang" -> "Semarang"
        $fallbackParts = $parts;
        while(count($fallbackParts) > 1) {
            array_shift($fallbackParts); // Remove the most specific part (street name, etc)
            $queriesToTry[] = implode(', ', $fallbackParts);
        }

        // Remove duplicates to save API calls
        $queriesToTry = array_unique($queriesToTry);

        foreach ($queriesToTry as $q) {
            if (empty(trim($q))) continue;
            
            $url = 'https://nominatim.openstreetmap.org/search?q=' . urlencode($q) . '&format=json&limit=1';
            
            try {
                $response = $client->request('GET', $url);
                $body = $response->getBody();
                $data = json_decode($body, true);
                
                if (!empty($data) && isset($data[0]['lat'])) {
                    return $this->response->setJSON([
                        'lat' => $data[0]['lat'],
                        'lon' => $data[0]['lon'],
                        'matched_query' => $q
                    ]);
                }
            } catch (\Exception $e) {
                // If one request fails (e.g. timeout), try the next one
                continue;
            }
        }

        return $this->response->setJSON(['error' => 'Sistem otomatis kesulitan memetakan alamat ini secara presisi. Mohon KLIK PADA PETA untuk menandai lokasi.']);
    }

    public function postReview($tempatId)
    {
        $userId = session()->get('user_id');
        $rating = $this->request->getPost('rating');
        $reviewText = $this->request->getPost('review_text');

        $this->reviewModel->insert([
            'tempat_id' => $tempatId,
            'user_id' => $userId,
            'rating' => $rating,
            'review_text' => $reviewText,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan.');
    }

    public function updateReview($reviewId)
    {
        $userId = session()->get('user_id');
        $review = $this->reviewModel->find($reviewId);

        if ($review && $review['user_id'] == $userId) {
            $createdAt = strtotime($review['created_at']);
            if (time() - $createdAt <= 86400) {
                $this->reviewModel->update($reviewId, [
                    'rating' => $this->request->getPost('rating'),
                    'review_text' => $this->request->getPost('review_text')
                ]);
                return redirect()->back()->with('success', 'Ulasan berhasil diperbarui.');
            } else {
                return redirect()->back()->with('error', 'Waktu edit ulasan sudah melebihi 24 jam.');
            }
        }
        return redirect()->back()->with('error', 'Tidak berhak mengedit ulasan ini.');
    }

    public function toggleFavorit($tempatId)
    {
        $userId = session()->get('user_id');
        $favoritModel = new \App\Models\FavoritModel();
        
        $exists = $favoritModel->where('user_id', $userId)->where('tempat_id', $tempatId)->first();
        if ($exists) {
            $favoritModel->where('user_id', $userId)->where('tempat_id', $tempatId)->delete();
            return redirect()->back()->with('success', 'Dihapus dari favorit.');
        } else {
            $favoritModel->insert([
                'user_id' => $userId,
                'tempat_id' => $tempatId
            ]);
            return redirect()->back()->with('success', 'Ditambahkan ke favorit.');
        }
    }

    public function tandaiTutup($tempatId)
    {
        $tempat = $this->tempatModel->find($tempatId);
        if ($tempat) {
            $this->tempatModel->update($tempatId, [
                'status' => 'pending'
            ]);
            return redirect()->back()->with('success', 'Tempat telah dilaporkan tutup permanen dan menunggu moderasi admin.');
        }
        return redirect()->back()->with('error', 'Tempat tidak ditemukan.');
    }
}
