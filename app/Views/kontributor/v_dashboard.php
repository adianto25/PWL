<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<style>
    /* Contributor Specific Personal Styling */
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

    .welcome-banner {
        background: linear-gradient(135deg, #4154f1 0%, #2a3eb1 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(65, 84, 241, 0.2);
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        bottom: -80px;
        right: 100px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .welcome-text h2 {
        font-weight: 800;
        margin-bottom: 10px;
        font-size: 2rem;
    }

    .personal-stats {
        display: flex;
        gap: 20px;
    }

    .stat-pill {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 15px 25px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.2);
        transition: transform 0.3s;
    }

    .stat-pill:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.3);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .stat-pill h3 {
        margin: 0;
        font-weight: 800;
        font-size: 2rem;
    }

    .stat-pill span {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        font-weight: 600;
    }

    /* Grid Layout instead of Table */
    .kontributor-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .kontributor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }

    .k-card-header {
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 1px solid #f5f5f5;
    }

    .k-card-avatar {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
    }

    .k-card-title {
        font-weight: 700;
        color: #2c384e;
        margin-bottom: 3px;
        font-size: 1.1rem;
        line-height: 1.2;
    }

    .k-card-date {
        font-size: 0.8rem;
        color: #888;
    }

    .k-card-body {
        padding: 20px;
        flex-grow: 1;
    }

    .k-card-address {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .k-card-footer {
        padding: 15px 20px;
        background: #fafbfe;
        border-top: 1px solid #f5f5f5;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Status Badges */
    .status-capsule {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .status-approved { background-color: #e6f4ea; color: #34a853; }
    .status-pending { background-color: #fef7e0; color: #fbbc04; }
    .status-rejected { background-color: #fce8e6; color: #ea4335; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- WELCOME BANNER (Personalized Studio Look) -->
<div class="welcome-banner flex-column flex-md-row gap-4 gap-md-0">
    <div class="welcome-text">
        <p class="mb-1 text-white-50 fw-bold text-uppercase tracking-wide">Studio Kontributor</p>
        <h2>Halo, <?= esc(session()->get('username')) ?>! 👋</h2>
        <p class="mb-0 opacity-75">Mari terus berkontribusi dan bagikan rekomendasi produk UMKM terbaikmu ke semua orang.</p>
    </div>
    <div class="personal-stats">
        <div class="stat-pill">
            <h3><?= count($tempat_saya) ?></h3>
            <span>Kontribusi</span>
        </div>
        <div class="stat-pill">
            <h3><?= esc($total_review) ?></h3>
            <span>Ulasan</span>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Karya & Kontribusi Saya</h3>
        <p class="text-muted small mb-0">Etalase produk UMKM yang telah Anda unggah.</p>
    </div>
    <a href="<?= base_url('kontributor/submit') ?>" class="btn btn-warning fw-bold text-dark px-4 rounded-pill shadow-sm" style="background-color: #ffc107; border:none;">
        <i class="bi bi-plus-circle me-1"></i> Tambah Tempat
    </a>
</div>

<!-- CARD GRID LAYOUT (Replacing the Table) -->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
    <?php if(empty($tempat_saya)): ?>
        <div class="col-12 w-100 text-center py-5">
            <div class="p-5 bg-white rounded-4 shadow-sm border border-light">
                <i class="bi bi-camera fs-1 text-muted d-block mb-3"></i>
                <h5 class="fw-bold text-dark">Belum Ada Karya</h5>
                <p class="text-muted">Anda belum membagikan data UMKM apapun. Yuk, mulai sekarang!</p>
                <a href="<?= base_url('kontributor/submit') ?>" class="btn btn-primary rounded-pill px-4 mt-2">Buat Kontribusi Pertama</a>
            </div>
        </div>
    <?php else: ?>
        <?php foreach($tempat_saya as $t): ?>
        <div class="col">
            <div class="kontributor-card">
                <div class="k-card-header">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($t['nama']) ?>&background=random&color=fff&size=120&rounded=true&bold=true" class="k-card-avatar" alt="<?= esc($t['nama']) ?>">
                    <div>
                        <div class="k-card-title"><?= esc($t['nama']) ?></div>
                        <div class="k-card-date"><i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($t['created_at'])) ?></div>
                    </div>
                </div>
                <div class="k-card-body">
                    <div class="k-card-address">
                        <i class="bi bi-geo-alt text-primary me-1"></i> <?= esc($t['alamat']) ?>
                    </div>
                </div>
                <div class="k-card-footer">
                    <span class="text-muted small fw-bold">Status Verifikasi:</span>
                    <?php if($t['status'] == 'approved'): ?>
                        <span class="status-capsule status-approved"><i class="bi bi-check-circle-fill"></i> Disetujui</span>
                    <?php elseif($t['status'] == 'rejected'): ?>
                        <span class="status-capsule status-rejected"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                    <?php else: ?>
                        <span class="status-capsule status-pending"><i class="bi bi-clock-fill"></i> Tertunda</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
