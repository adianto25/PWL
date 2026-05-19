<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TempatKulinerModel;
use App\Models\UserModel;
use App\Models\ReviewModel;
use App\Models\KategoriModel;
use App\Models\TagModel;

class AdminController extends BaseController
{
    protected $tempatModel;
    protected $userModel;
    protected $reviewModel;
    protected $kategoriModel;
    protected $tagModel;

    public function __construct()
    {
        $this->tempatModel = new TempatKulinerModel();
        $this->userModel = new UserModel();
        $this->reviewModel = new ReviewModel();
        $this->kategoriModel = new KategoriModel();
        $this->tagModel = new TagModel();
        $this->fotoModel = new \App\Models\TempatFotoModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title' => 'Dashboard',
            'total_users' => $this->userModel->countAllResults(),
            'total_tempat' => $this->tempatModel->countAllResults(),
            'total_pending' => $this->tempatModel->where('status', 'pending')->countAllResults(),
            'total_reviews' => $this->reviewModel->countAllResults(),
        ];

        $builder = $db->table('tempat_kuliner');
        $builder->select('tempat_kuliner.*, kategori.nama_kategori, users.username');
        $builder->join('kategori', 'kategori.id = tempat_kuliner.kategori_id');
        $builder->join('users', 'users.id = tempat_kuliner.user_id');
        $builder->orderBy('tempat_kuliner.created_at', 'DESC');
        
        $data['semua_tempat'] = $builder->get()->getResultArray();

        return view('admin/v_dashboard', $data);
    }

    public function approve($id)
    {
        $this->tempatModel->update($id, ['status' => 'approved']);
        return redirect()->back()->with('success', 'Tempat berhasil disetujui.');
    }

    public function reject($id)
    {
        $this->tempatModel->update($id, ['status' => 'rejected']);
        return redirect()->back()->with('success', 'Tempat berhasil ditolak.');
    }

    // --- Kategori CRUD ---
    public function kategori()
    {
        $data = [
            'title' => 'Kelola Kategori',
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('admin/v_kategori', $data);
    }

    public function kategoriAdd()
    {
        $rules = [
            'nama_kategori' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama kategori harus diisi.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getError('nama_kategori'));
        }

        $this->kategoriModel->insert(['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function kategoriEdit($id)
    {
        $rules = [
            'nama_kategori' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama kategori harus diisi.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getError('nama_kategori'));
        }

        $this->kategoriModel->update($id, ['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->back()->with('success', 'Kategori berhasil diubah.');
    }

    public function kategoriDelete($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }

    // --- Tag CRUD ---
    public function tag()
    {
        $data = [
            'title' => 'Kelola Tag',
            'tags' => $this->tagModel->findAll()
        ];
        return view('admin/v_tag', $data);
    }

    public function tagAdd()
    {
        $rules = [
            'nama_tag' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama tag harus diisi.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getError('nama_tag'));
        }

        $this->tagModel->insert(['nama_tag' => $this->request->getPost('nama_tag')]);
        return redirect()->back()->with('success', 'Tag berhasil ditambahkan.');
    }

    public function tagEdit($id)
    {
        $rules = [
            'nama_tag' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama tag harus diisi.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getError('nama_tag'));
        }

        $this->tagModel->update($id, ['nama_tag' => $this->request->getPost('nama_tag')]);
        return redirect()->back()->with('success', 'Tag berhasil diubah.');
    }

    public function tagDelete($id)
    {
        $this->tagModel->delete($id);
        return redirect()->back()->with('success', 'Tag berhasil dihapus.');
    }

    // --- Tempat CRUD Basic ---
    public function tempatEdit($id)
    {
        $data = [
            'tempat' => $this->tempatModel->find($id),
            'kategori' => $this->kategoriModel->findAll(),
            'tags' => $this->tagModel->findAll(),
            'selected_tags' => array_column((new \App\Models\TempatTagModel())->where('tempat_id', $id)->findAll(), 'tag_id')
        ];
        if(!$data['tempat']) return redirect()->to('/admin')->with('error', 'Data tidak ditemukan.');
        
        $data['fotos'] = $this->fotoModel->where('tempat_id', $id)->findAll();
        
        // Scan NiceAdmin assets for images
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
            'nama' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama tempat harus diisi.',
                    'min_length' => 'Nama tempat minimal 3 karakter.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => ['required' => 'Alamat harus diisi.']
            ],
            'kategori_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kategori harus dipilih.']
            ],
            'status' => [
                'rules' => 'required|in_list[pending,approved,rejected]',
                'errors' => ['required' => 'Status harus dipilih.', 'in_list' => 'Status tidak valid.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->tempatModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'alamat' => $this->request->getPost('alamat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'status' => $this->request->getPost('status')
        ]);

        $tempatTagModel = new \App\Models\TempatTagModel();
        // Clear existing tags
        $tempatTagModel->where('tempat_id', $id)->delete();
        
        // Insert new tags
        $tags = $this->request->getPost('tags');
        if (!empty($tags) && is_array($tags)) {
            foreach ($tags as $tagId) {
                $tempatTagModel->insert([
                    'tempat_id' => $id,
                    'tag_id' => $tagId
                ]);
            }
        }

        // --- Photo Management ---
        $currentPhotoCount = $this->fotoModel->where('tempat_id', $id)->countAllResults();
        
        // 1. Process new file uploads
        $files = $this->request->getFileMultiple('foto_upload');
        if ($files) {
            foreach ($files as $file) {
                if ($currentPhotoCount >= 3) break;
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads', $newName);

                    try {
                        \Config\Services::image()
                            ->withFile(FCPATH . 'uploads/' . $newName)
                            ->resize(800, 800, true, 'auto')
                            ->save(FCPATH . 'uploads/' . $newName);
                    } catch (\Exception $e) {}

                    $this->fotoModel->insert([
                        'tempat_id' => $id,
                        'foto_path' => $newName
                    ]);
                    $currentPhotoCount++;
                }
            }
        }

        // 2. Process NiceAdmin Asset Selection
        $fotoAsset = $this->request->getPost('foto_asset');
        if (!empty($fotoAsset) && $currentPhotoCount < 3) {
            $sourcePath = FCPATH . 'NiceAdmin/assets/img/' . $fotoAsset;
            if (file_exists($sourcePath)) {
                $this->fotoModel->insert([
                    'tempat_id' => $id,
                    'foto_path' => 'NiceAdmin/assets/img/' . $fotoAsset
                ]);
                $currentPhotoCount++;
            }
        }

        return redirect()->to('/admin')->with('success', 'Tempat kuliner berhasil diperbarui.');
    }

    public function fotoDelete($id)
    {
        $foto = $this->fotoModel->find($id);
        if ($foto) {
            // Jangan hapus file fisik jika itu dari template NiceAdmin
            if (strpos($foto['foto_path'], 'NiceAdmin') === false) {
                $filePath = FCPATH . 'uploads/' . $foto['foto_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $this->fotoModel->delete($id);
            return redirect()->back()->with('success', 'Foto berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'Foto tidak ditemukan.');
    }

    public function tempatDelete($id)
    {
        $this->tempatModel->delete($id);
        return redirect()->back()->with('success', 'Tempat kuliner berhasil dihapus.');
    }

    // --- Review Delete ---
    public function reviewDelete($id)
    {
        $this->reviewModel->delete($id);
        return redirect()->back()->with('success', 'Review berhasil dihapus.');
    }
}
