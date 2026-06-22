<?php

namespace App\Models;

use CodeIgniter\Model;

class TempatTagModel extends Model
{
    protected $table            = 'tempat_tags';
    protected $primaryKey       = 'tempat_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tempat_id', 'tag_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
}
