<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TempatKulinerModel;
use App\Models\UserModel;
use App\Models\ReviewModel;
use App\Models\KategoriModel;
use App\Models\TagModel;
use App\Models\TempatFotoModel;
use App\Models\TempatTagModel;

/**
 * AdminController
 * Mengelola semua fungsi back-end untuk dashboard admin
 * Termasuk Manajemen Tempat, Kategori, Tag, dan Review.
 */
class AdminController extends BaseController
{
    protected $tempatModel;
    protected $userModel;
    protected $reviewModel;
    protected $kategoriModel;
    protected $tagModel;
    protected $fotoModel;
    protected $tempatTagModel;

    /**
     * Constructor untuk inisialisasi semua model yang dibutuhkan
     */
    public function __construct()
    {
        $this->tempatModel = new TempatKulinerModel();
        $this->userModel = new UserModel();
        $this->reviewModel = new ReviewModel();
        $this->kategoriModel = new KategoriModel();
        $this->tagModel = new TagModel();
        $this->fotoModel = new \App\Models\TempatFotoModel();
        $this->tempatTagModel = new \App\Models\TempatTagModel();
    }

    /**
     * Tampilan Utama Dashboard
     * Menampilkan statistik dan daftar semua tempat kuliner
     */
    public function index()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title' => 'Dashboard Admin - UMKM Lokal',
            'total_users' => $this->userModel->countAllResults(),
            'total_tempat' => $this->tempatModel->countAllResults(),
            'total_pending' => $this->tempatModel->where('status', 'pending')->countAllResults(),
            'total_reviews' => $this->reviewModel->countAllResults(),
            'kategori' => $this->kategoriModel->findAll(),
            'tags' => $this->tagModel->findAll(),
        ];

        // Membangun query dengan join untuk detail data
        $builder = $db->table('tempat_kuliner');
        $builder->select('tempat_kuliner.*, kategori.nama_kategori, users.username');
        $builder->join('kategori', 'kategori.id = tempat_kuliner.kategori_id', 'left');
        $builder->join('users', 'users.id = tempat_kuliner.user_id', 'left');
        $builder->orderBy('tempat_kuliner.created_at', 'DESC');
        
        $data['semua_tempat'] = $builder->get()->getResultArray();

        return view('admin/v_dashboard', $data);
    }

    /**
     * Method Save Baru: Menyimpan data dari form dashboard
     */
    public function save_tempat()
    {
        $rules = [
            'nama' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama lokasi wajib diisi.',
                    'min_length' => 'Nama lokasi minimal harus 3 karakter.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => ['required' => 'Alamat lengkap wajib diisi.']
            ],
            'id_kategori' => [
                'rules' => 'required',
                'errors' => ['required' => 'Silakan pilih kategori terlebih dahulu.']
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto lokasi wajib diunggah.',
                    'max_size' => 'Ukuran foto maksimal adalah 2MB.',
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data. Silakan periksa kembali form Anda.');
        }

        // Proses file upload
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move(FCPATH . 'uploads', $namaFoto);

        // Resize Image using CI4 Image Library (max 800px)
        \Config\Services::image()
            ->withFile(FCPATH . 'uploads/' . $namaFoto)
            ->resize(800, 800, true, 'auto')
            ->save(FCPATH . 'uploads/' . $namaFoto);

        // Create Thumbnail (max 200px)
        $thumbName = 'thumb_' . $namaFoto;
        \Config\Services::image()
            ->withFile(FCPATH . 'uploads/' . $namaFoto)
            ->resize(200, 200, true, 'auto')
            ->save(FCPATH . 'uploads/' . $thumbName);

        // Menyiapkan data untuk insert
        $dataPayload = [
            'nama'        => $this->request->getPost('nama'),
            'kategori_id' => $this->request->getPost('id_kategori'),
            'alamat'      => $this->request->getPost('alamat'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'lat'         => $this->request->getPost('lat'),
            'lng'         => $this->request->getPost('lng'),
            'status'      => 'pending',
            'user_id'     => session()->get('user_id') ?? 1,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        if ($this->tempatModel->insert($dataPayload)) {
            $last_id = $this->tempatModel->getInsertID();
            
            // Simpan record foto
            $this->fotoModel->insert([
                'tempat_id' => $last_id,
                'foto_path' => $namaFoto
            ]);

            return redirect()->to('/admin')->with('success', 'Data UMKM Berhasil ditambahkan ke sistem.');
        }

        return redirect()->back()->with('error', 'Terjadi masalah pada server saat menyimpan data.');
    }

    /**
     * Persetujuan lokasi oleh admin
     */
    public function approve($id)
    {
        $this->tempatModel->update($id, ['status' => 'approved']);
        return redirect()->back()->with('success', 'Status tempat kuliner berhasil diubah menjadi Approved.');
    }

    /**
     * Penolakan lokasi oleh admin
     */
    public function reject($id)
    {
        $this->tempatModel->update($id, ['status' => 'rejected']);
        return redirect()->back()->with('success', 'Status tempat kuliner berhasil diubah menjadi Rejected.');
    }

    /**
     * --- MANAJEMEN KATEGORI ---
     */
    public function kategori()
    {
        $data = [
            'title' => 'Kelola Kategori Produk',
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('admin/v_kategori', $data);
    }

    public function kategoriAdd()
    {
        $rules = [
            'nama_kategori' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama kategori tidak boleh kosong.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getError('nama_kategori'));
        }

        $this->kategoriModel->insert(['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function kategoriEdit($id)
    {
        $rules = [
            'nama_kategori' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama kategori tidak boleh kosong saat diedit.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getError('nama_kategori'));
        }

        $this->kategoriModel->update($id, ['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->back()->with('success', 'Perubahan nama kategori berhasil disimpan.');
    }

    public function kategoriDelete($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->back()->with('success', 'Data kategori telah dihapus secara permanen.');
    }

    /**
     * --- MANAJEMEN TAG ---
     */
    public function tag()
    {
        $data = [
            'title' => 'Kelola Tagar / Label',
            'tags' => $this->tagModel->findAll()
        ];
        return view('admin/v_tag', $data);
    }

    public function tagAdd()
    {
        $rules = [
            'nama_tag' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama tag wajib diisi.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getError('nama_tag'));
        }

        $this->tagModel->insert(['nama_tag' => $this->request->getPost('nama_tag')]);
        return redirect()->back()->with('success', 'Tag baru berhasil dibuat.');
    }

    public function tagEdit($id)
    {
        $rules = [
            'nama_tag' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama tag tidak boleh dikosongkan.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getError('nama_tag'));
        }

        $this->tagModel->update($id, ['nama_tag' => $this->request->getPost('nama_tag')]);
        return redirect()->back()->with('success', 'Data tag berhasil diperbarui.');
    }

    public function tagDelete($id)
    {
        $this->tagModel->delete($id);
        return redirect()->back()->with('success', 'Tag telah dihapus dari sistem.');
    }

    /**
     * --- EDIT & UPDATE TEMPAT (DETAIL) ---
     */
    public function tempatEdit($id)
    {
        $data = [
            'title' => 'Formulir Perubahan Data Tempat',
            'tempat' => $this->tempatModel->find($id),
            'kategori' => $this->kategoriModel->findAll(),
            'tags' => $this->tagModel->findAll(),
            'selected_tags' => array_column($this->tempatTagModel->where('tempat_id', $id)->findAll(), 'tag_id')
        ];
        
        if(!$data['tempat']) {
            return redirect()->to('/admin')->with('error', 'Maaf, data tempat tersebut tidak ditemukan dalam database.');
        }
        
        $data['fotos'] = $this->fotoModel->where('tempat_id', $id)->findAll();
        
        // Pengecekan aset gambar NiceAdmin untuk template
        $assetPath = FCPATH . 'NiceAdmin/assets/img/';
        $availableAssets = [];
        if (is_dir($assetPath)) {
            $files = scandir($assetPath);
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
                    $availableAssets[] = $file;
                }
            }
        }
        $data['available_assets'] = $availableAssets;

        return view('admin/v_tempat_edit', $data);
    }

    public function tempatUpdate($id)
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'alamat' => 'required',
            'kategori_id' => 'required',
            'status' => 'required|in_list[pending,approved,rejected]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Eksekusi update data utama
        $this->tempatModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'alamat' => $this->request->getPost('alamat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Pengelolaan Tag (Many to Many)
        $this->tempatTagModel->where('tempat_id', $id)->delete();
        $tags = $this->request->getPost('tags');
        if (!empty($tags) && is_array($tags)) {
            foreach ($tags as $tagId) {
                $this->tempatTagModel->insert([
                    'tempat_id' => $id, 
                    'tag_id' => $tagId
                ]);
            }
        }

        // Pengelolaan Foto Tambahan (Upload Multiple)
        $files = $this->request->getFileMultiple('foto_upload');
        if ($files) {
            foreach ($files as $file) {
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

                    // Simpan ke DB
                    $this->fotoModel->insert([
                        'tempat_id' => $id, 
                        'foto_path' => $newName
                    ]);
                }
            }
        }

        // Pengelolaan Foto dari Template NiceAdmin
        $fotoAsset = $this->request->getPost('foto_asset');
        if (!empty($fotoAsset)) {
            $this->fotoModel->insert([
                'tempat_id' => $id,
                'foto_path' => 'NiceAdmin/assets/img/' . $fotoAsset
            ]);
        }

        return redirect()->to('/admin')->with('success', 'Seluruh perubahan data tempat kuliner telah disimpan.');
    }

    /**
     * Menghapus foto tertentu berdasarkan ID
     */
    public function fotoDelete($id)
    {
        $foto = $this->fotoModel->find($id);
        if ($foto) {
            // Cek apakah file berada di folder uploads atau assets template
            if (strpos($foto['foto_path'], 'NiceAdmin') === false) {
                $filePath = FCPATH . 'uploads/' . $foto['foto_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $this->fotoModel->delete($id);
            return redirect()->back()->with('success', 'File foto berhasil dihapus dari server.');
        }
        return redirect()->back()->with('error', 'Data foto tidak ditemukan.');
    }

    /**
     * Menghapus Tempat secara total beserta relasinya
     */
    public function tempatDelete($id)
    {
        // 1. Bersihkan file fisik di folder uploads
        $fotos = $this->fotoModel->where('tempat_id', $id)->findAll();
        foreach ($fotos as $f) {
            if (strpos($f['foto_path'], 'NiceAdmin') === false) {
                $p = FCPATH . 'uploads/' . $f['foto_path'];
                if (file_exists($p)) unlink($p);
            }
        }
        
        // 2. Bersihkan record di database
        $this->fotoModel->where('tempat_id', $id)->delete();
        $this->tempatTagModel->where('tempat_id', $id)->delete();
        $this->tempatModel->delete($id);
        
        return redirect()->back()->with('success', 'Seluruh data tempat dan file terkait telah berhasil dihapus.');
    }

    /**
     * Menghapus Review User
     */
    public function reviewDelete($id)
    {
        if($this->reviewModel->delete($id)) {
            return redirect()->back()->with('success', 'Ulasan user telah berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'Gagal menghapus ulasan.');
    }
}