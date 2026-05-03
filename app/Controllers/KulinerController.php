<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TempatKulinerModel;
use App\Models\ReviewModel;
use App\Models\KategoriModel;

class KulinerController extends BaseController
{
    protected $tempatModel;
    protected $reviewModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->tempatModel = new TempatKulinerModel();
        $this->reviewModel = new ReviewModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $kategoriId = $this->request->getGet('kategori_id');
        $tagId = $this->request->getGet('tag_id');
        $minRating = $this->request->getGet('min_rating');
        $jarak = (float)$this->request->getGet('jarak');
        $userLat = (float)$this->request->getGet('user_lat');
        $userLng = (float)$this->request->getGet('user_lng');
        $keyword = $this->request->getGet('keyword');

        $tagModel = new \App\Models\TagModel();

        if ($jarak && $userLat && $userLng) {
            $haversine = "(6371 * acos(cos(radians($userLat)) * cos(radians(tempat_kuliner.lat)) * cos(radians(tempat_kuliner.lng) - radians($userLng)) + sin(radians($userLat)) * sin(radians(tempat_kuliner.lat))))";
            $this->tempatModel->select("tempat_kuliner.*, kategori.nama_kategori, $haversine AS distance, (SELECT IFNULL(AVG(rating),0) FROM reviews WHERE tempat_id = tempat_kuliner.id) as avg_rating");
            $this->tempatModel->having("distance <=", $jarak);
        } else {
            $this->tempatModel->select('tempat_kuliner.*, kategori.nama_kategori, (SELECT IFNULL(AVG(rating),0) FROM reviews WHERE tempat_id = tempat_kuliner.id) as avg_rating');
        }

        $this->tempatModel->join('kategori', 'kategori.id = tempat_kuliner.kategori_id');
        $this->tempatModel->where('status', 'approved');

        if ($kategoriId) {
            $this->tempatModel->where('tempat_kuliner.kategori_id', $kategoriId);
        }
        if ($keyword) {
            $this->tempatModel->groupStart()
                ->like('tempat_kuliner.nama', $keyword)
                ->orLike('tempat_kuliner.alamat', $keyword)
                ->groupEnd();
        }
        if ($tagId) {
            $this->tempatModel->join('tempat_tags', 'tempat_tags.tempat_id = tempat_kuliner.id');
            $this->tempatModel->where('tempat_tags.tag_id', $tagId);
        }
        if ($minRating) {
            $this->tempatModel->having('avg_rating >=', $minRating);
        }

        // Execute query manually to handle having correctly without messing up countAllResults for pagination
        // Using manual pagination approach because 'having' combined with countAllResults in CI4 can break.
        $db = \Config\Database::connect();
        
        $queryBuilder = $this->tempatModel->builder();
        
        // Clone the builder for counting total rows safely (CI4 countAllResults strips SELECT which breaks HAVING)
        $countBuilder = clone $queryBuilder;
        $sql = $countBuilder->getCompiledSelect(false);
        $totalRows = $db->query("SELECT COUNT(*) as total FROM ($sql) as subquery")->getRow()->total;
        
        $page = (int)($this->request->getGet('page') ?? 1);
        $perPage = 9;
        
        $queryBuilder->limit($perPage, ($page - 1) * $perPage);
        $tempat = $queryBuilder->get()->getResultArray();

        // Fetch primary photo for each place
        foreach ($tempat as &$t) {
            $foto = $db->table('tempat_fotos')->where('tempat_id', $t['id'])->orderBy('id', 'ASC')->get()->getRowArray();
            $t['foto_utama'] = $foto ? $foto['foto_path'] : null;
        }

        $pager = \Config\Services::pager();
        
        $data = [
            'title' => 'Eksplorasi Kuliner',
            'tempat' => $tempat,
            'kategori' => $this->kategoriModel->findAll(),
            'tags' => $tagModel->findAll(),
            'pager' => $pager->makeLinks($page, $perPage, $totalRows, 'default_full')
        ];

        return view('v_kuliner_index', $data);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('tempat_kuliner');
        $builder->select('tempat_kuliner.*, kategori.nama_kategori, users.username, (SELECT IFNULL(AVG(rating),0) FROM reviews WHERE tempat_id = tempat_kuliner.id) as avg_rating');
        $builder->join('kategori', 'kategori.id = tempat_kuliner.kategori_id');
        $builder->join('users', 'users.id = tempat_kuliner.user_id');
        $builder->where('tempat_kuliner.id', $id);
        $tempat = $builder->get()->getRowArray();

        if (!$tempat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Tags
        $tagsBuilder = $db->table('tempat_tags');
        $tagsBuilder->select('tags.nama_tag');
        $tagsBuilder->join('tags', 'tags.id = tempat_tags.tag_id');
        $tagsBuilder->where('tempat_id', $id);
        $tempat['tags'] = $tagsBuilder->get()->getResultArray();

        // Fotos
        $fotosBuilder = $db->table('tempat_fotos');
        $fotosBuilder->where('tempat_id', $id);
        $tempat['fotos'] = $fotosBuilder->get()->getResultArray();

        // Reviews
        $builderRev = $db->table('reviews');
        $builderRev->select('reviews.*, users.username');
        $builderRev->join('users', 'users.id = reviews.user_id');
        $builderRev->where('tempat_id', $id);
        $builderRev->orderBy('reviews.created_at', 'DESC');
        $reviews = $builderRev->get()->getResultArray();

        // Calculate Rating Distribution
        $ratingCounts = array_replace([5=>0, 4=>0, 3=>0, 2=>0, 1=>0], array_count_values(array_column($reviews, 'rating')));
        $totalReviews = count($reviews);

        $data = [
            'title' => $tempat['nama'],
            'tempat' => $tempat,
            'reviews' => $reviews,
            'ratingCounts' => $ratingCounts,
            'totalReviews' => $totalReviews
        ];

        return view('v_kuliner_detail', $data);
    }
}
