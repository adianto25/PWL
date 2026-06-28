<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table            = 'keranjang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'menu_id', 'jumlah', 'catatan'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getKeranjangByUser($userId)
    {
        return $this->select('keranjang.*, menus.nama_makanan, menus.harga, menus.foto, tempat_kuliner.nama as nama_warung')
                    ->join('menus', 'menus.id = keranjang.menu_id')
                    ->join('tempat_kuliner', 'tempat_kuliner.id = menus.tempat_id')
                    ->where('keranjang.user_id', $userId)
                    ->findAll();
    }
}
