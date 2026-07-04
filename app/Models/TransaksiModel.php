<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'order_id', 'user_id', 'tempat_id', 'gross_amount', 
        'payment_type', 'transaction_status', 'snap_token'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Mendapatkan riwayat transaksi user beserta nama tempatnya
    public function getRiwayatByUser($userId)
    {
        return $this->select('transaksi.*, tempat_kuliner.nama as nama_warung, (SELECT foto_path FROM tempat_foto WHERE tempat_id = transaksi.tempat_id LIMIT 1) as foto_warung')
                    ->join('tempat_kuliner', 'tempat_kuliner.id = transaksi.tempat_id', 'left')
                    ->where('transaksi.user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Mendapatkan semua transaksi untuk panel Admin
    public function getAllTransaksi()
    {
        return $this->select('transaksi.*, users.username, tempat_kuliner.nama as nama_warung, (SELECT foto_path FROM tempat_foto WHERE tempat_id = transaksi.tempat_id LIMIT 1) as foto_warung')
                    ->join('users', 'users.id = transaksi.user_id')
                    ->join('tempat_kuliner', 'tempat_kuliner.id = transaksi.tempat_id', 'left')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
