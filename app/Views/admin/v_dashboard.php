<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<style>
    /* Custom Styling for UMKM LOKAL Mockup */
    body {
        background-color: #f8f9fa !important;
    }
    
    /* Neutralize default layout.php card wrapper */
    main#main .section > .row > .col-lg-12 > .card {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    main#main .section > .row > .col-lg-12 > .card > .card-body {
        padding: 0 !important;
    }
    main#main .section > .row > .col-lg-12 > .card > .card-body > .card-title {
        display: none !important;
    }

    .dashboard-title-area {
        margin-bottom: 2rem;
    }
    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.02);
        padding: 1.5rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 18px;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }
    .icon-blue { background: linear-gradient(135deg, #e8f0fe 0%, #d2e3fc 100%); color: #1a73e8; }
    .icon-orange { background: linear-gradient(135deg, #fef7e0 0%, #fde293 100%); color: #f29900; }
    .icon-green { background: linear-gradient(135deg, #e6f4ea 0%, #ceead6 100%); color: #188038; }
    .icon-red { background: linear-gradient(135deg, #fce8e6 0%, #fad2cf 100%); color: #d93025; } 
    
    .stat-info h6 {
        font-size: 12px;
        color: #888;
        font-weight: 600;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-info h2 {
        font-size: 26px;
        font-weight: 800;
        color: #202124;
        margin: 0;
        line-height: 1.2;
    }

    .main-card {
        border-radius: 16px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.02);
        background: #fff;
        padding: 30px;
        margin-top: 25px;
    }
    
    .table-custom {
        margin-top: 15px;
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    .table-custom th {
        font-size: 12px;
        color: #888;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: 2px solid #eee;
        padding: 15px 10px;
    }
    .table-custom td {
        vertical-align: middle;
        padding: 18px 12px;
        font-size: 14px;
        color: #3c4043;
        background-color: #fff;
        border-top: 1px solid #f8f9fa;
        border-bottom: 1px solid #f8f9fa;
    }
    .table-custom td:first-child { border-left: 1px solid #f8f9fa; border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
    .table-custom td:last-child { border-right: 1px solid #f8f9fa; border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
    
    .table-custom tbody tr {
        box-shadow: 0 2px 6px rgba(0,0,0,0.01);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .table-custom tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        background-color: #fff;
    }
    
    .avatar-lokasi {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 15px;
    }
    
    .badge-kategori {
        background-color: #e8f0fe;
        color: #4285f4;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
    }
    .badge-status-verified {
        background-color: #e6f4ea;
        color: #34a853;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
    }
    .badge-status-pending {
        background-color: #fef7e0;
        color: #fbbc04;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
    }
    .badge-status-rejected {
        background-color: #fce8e6;
        color: #ea4335;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .btn-outline-action {
        border: 1px solid #eee;
        color: #666;
        background: transparent;
        border-radius: 8px;
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-outline-action:hover {
        background: #f8f9fa;
        color: #333;
    }
    .btn-outline-action.text-primary:hover { border-color: #4285f4; color: #4285f4; }
    .btn-outline-action.text-danger:hover { border-color: #ea4335; color: #ea4335; }
    .btn-outline-action.text-success:hover { border-color: #34a853; color: #34a853; }
    .btn-outline-action.text-warning:hover { border-color: #fbbc04; color: #fbbc04; }

    .rating-star {
        color: #fbbc04;
        margin-right: 5px;
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
        padding: 12px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
    }
    .search-input {
        border: none;
        background: transparent;
        outline: none;
        width: 300px;
        padding-left: 12px;
        color: #495057;
        font-size: 14px;
    }
    .toolbar-filters select {
        border: none;
        background: transparent;
        outline: none;
        color: #495057;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="bi bi-shop"></i>
            </div>
            <div class="stat-info">
                <h6>TOTAL LOKASI</h6>
                <h2><?= esc($total_tempat) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-orange">
                <i class="bi bi-chat-dots"></i>
            </div>
            <div class="stat-info">
                <h6>REVIEW MASUK</h6>
                <h2><?= esc($total_reviews) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-green">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-info">
                <h6>USER AKTIF</h6>
                <h2><?= esc($total_users) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-red">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h6>PENDING</h6>
                <h2><?= esc($total_pending) ?></h2>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashData('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" style="border-radius: 10px;">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- MAIN LOCATION CARD -->
<div class="main-card mt-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Manajemen Lokasi</h3>
            <p class="text-muted small mb-0">Kelola semua daftar produk UMKM kamu di sini.</p>
        </div>
        <a href="<?= base_url('admin/tempat/add') ?>" class="btn btn-warning fw-bold text-dark px-4 rounded-pill shadow-sm" style="background-color: #ffc107; border:none; height: 45px; display: flex; align-items: center;">
            <i class="bi bi-plus" style="font-size: 1.2rem;"></i> Tambah Lokasi Baru
        </a>
    </div>

    <!-- TOOLBAR -->
    <div class="toolbar">
        <div class="d-flex align-items-center">
            <i class="bi bi-search text-muted"></i>
            <input type="text" class="search-input" placeholder="Cari nama lokasi...">
        </div>
        <div class="d-flex align-items-center gap-3 toolbar-filters">
            <select>
                <option>Semua Kategori</option>
            </select>
            <select>
                <option>Status: Semua</option>
            </select>
            <span class="badge bg-secondary rounded-pill px-3 py-2 text-uppercase" style="opacity: 0.8;">TOTAL: <?= count($semua_tempat) ?> DATA</span>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-custom table-borderless">
            <thead>
                <tr>
                    <th>FOTO & NAMA TEMPAT</th>
                    <th>KATEGORI</th>
                    <th>RATING AVG</th>
                    <th>STATUS</th>
                    <th class="text-end pe-4">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($semua_tempat)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-5">Tidak ada data UMKM.</td></tr>
                <?php else: ?>
                    <?php foreach($semua_tempat as $t): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <!-- Placeholder Image Generator to mimic the mockup's avatars -->
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($t['nama']) ?>&background=random&color=fff&size=100&rounded=false&bold=true" class="avatar-lokasi" alt="<?= esc($t['nama']) ?>">
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 15px;"><?= esc($t['nama']) ?></div>
                                    <div class="text-muted" style="font-size: 13px;"><i class="bi bi-geo-alt"></i> <?= esc((strlen($t['alamat']) > 40) ? substr($t['alamat'], 0, 40) . '...' : $t['alamat']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-kategori"><?= esc($t['nama_kategori']) ?></span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">
                                <i class="bi bi-star-fill rating-star"></i> 4.5
                            </div>
                        </td>
                        <td>
                            <?php if($t['status'] == 'approved'): ?>
                                <span class="badge-status-verified"><i class="bi bi-check-circle"></i> Verified</span>
                            <?php elseif($t['status'] == 'rejected'): ?>
                                <span class="badge-status-rejected"><i class="bi bi-x-circle"></i> Rejected</span>
                            <?php else: ?>
                                <span class="badge-status-pending"><i class="bi bi-clock"></i> Pending</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-3">
                            <?php if($t['status'] == 'pending'): ?>
                                <form action="<?= base_url('admin/approve/'.$t['id']) ?>" method="POST" class="d-inline">
                                    <button type="submit" class="btn-outline-action text-success" title="Setujui"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form action="<?= base_url('admin/reject/'.$t['id']) ?>" method="POST" class="d-inline">
                                    <button type="submit" class="btn-outline-action text-danger" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                </form>
                            <?php else: ?>
                                <a href="<?= base_url('admin/tempat/edit/'.$t['id']) ?>" class="btn-outline-action text-primary" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <a href="<?= base_url('admin/tempat/delete/'.$t['id']) ?>" onclick="return confirm('Hapus tempat ini?')" class="btn-outline-action text-danger" title="Hapus"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
