<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiDetailModel extends Model
{
    protected $table            = 'transaksi_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['transaksi_id', 'menu_id', 'harga', 'jumlah'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getDetailByTransaksi($transaksiId)
    {
        return $this->select('transaksi_detail.*, menus.nama_makanan, menus.foto')
                    ->join('menus', 'menus.id = transaksi_detail.menu_id')
                    ->where('transaksi_id', $transaksiId)
                    ->findAll();
    }
}
