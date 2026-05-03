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
        $this->kategoriModel->insert(['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function kategoriEdit($id)
    {
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
        $this->tagModel->insert(['nama_tag' => $this->request->getPost('nama_tag')]);
        return redirect()->back()->with('success', 'Tag berhasil ditambahkan.');
    }

    public function tagEdit($id)
    {
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
        return view('admin/v_tempat_edit', $data);
    }

    public function tempatUpdate($id)
    {
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

        return redirect()->to('/admin')->with('success', 'Tempat kuliner berhasil diperbarui.');
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
