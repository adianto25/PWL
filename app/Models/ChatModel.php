<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table            = 'chats';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['pengirim_id', 'penerima_id', 'tempat_id', 'pesan', 'is_read', 'created_at'];

    protected $useTimestamps = false; // We only use created_at, no updated_at
}
