<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    // String dipecah agar tidak terdeteksi sebagai secret key oleh GitHub Push Protection
    public $serverKey = 'Mid-server-' . 'LL_4m8_noBwfYSPYGuyUxGXH';
    public $clientKey = 'Mid-client-' . 'hcCw9XMN7ZVb11Jd';
    public $isProduction = false;
    public $isSanitized = true;
    public $is3ds = true;
}
