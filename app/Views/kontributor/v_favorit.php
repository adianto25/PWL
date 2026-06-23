<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<style>
    /* Styling khusus halaman favorit kontributor */
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

    .favorit-banner {
        background: linear-gradient(135deg, #e91e63 0%, #9c27b0 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(233, 30, 99, 0.2);
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .favorit-banner::after {
        content: '\F415'; /* bootstrap icon heart */
        font-family: bootstrap-icons;
        font-size: 15rem;
        position: absolute;
        top: -50px;
        right: -30px;
        color: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }

    .welcome-text h2 {
        font-weight: 800;
        margin-bottom: 10px;
        font-size: 2rem;
        position: relative;
        z-index: 2;
    }

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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- BANNER -->
<div class="favorit-banner flex-column flex-md-row gap-4 gap-md-0">
    <div class="welcome-text">
        <p class="mb-1 text-white-50 fw-bold text-uppercase tracking-wide">Koleksi Tersimpan</p>
        <h2>Tempat Favorit Saya 💖</h2>
        <p class="mb-0 opacity-75">Daftar UMKM kuliner yang paling Anda sukai dan simpan.</p>
    </div>
</div>

<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Daftar Favorit (<?= count($favorit_saya) ?>)</h3>
        <p class="text-muted small mb-0">Kuliner pilihan terbaik versi Anda.</p>
    </div>
    <a href="<?= base_url('/') ?>" class="btn btn-outline-primary fw-bold rounded-pill px-4 shadow-sm">
        <i class="bi bi-search me-1"></i> Cari UMKM Lain
    </a>
</div>

<!-- CARD GRID LAYOUT -->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
    <?php if(empty($favorit_saya)): ?>
        <div class="col-12 w-100 text-center py-5">
            <div class="p-5 bg-white rounded-4 shadow-sm border border-light">
                <i class="bi bi-heart-break fs-1 text-muted d-block mb-3"></i>
                <h5 class="fw-bold text-dark">Belum Ada Favorit</h5>
                <p class="text-muted">Anda belum menambahkan tempat kuliner manapun ke daftar favorit.</p>
                <a href="<?= base_url('/') ?>" class="btn btn-primary rounded-pill px-4 mt-2">Mulai Eksplorasi</a>
            </div>
        </div>
    <?php else: ?>
        <?php foreach($favorit_saya as $t): ?>
        <div class="col">
            <div class="kontributor-card">
                <div class="k-card-header">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($t['nama']) ?>&background=random&color=fff&size=120&rounded=true&bold=true" class="k-card-avatar" alt="<?= esc($t['nama']) ?>">
                    <div>
                        <div class="k-card-title"><?= esc($t['nama']) ?></div>
                        <div class="text-muted small">
                            <?php if($t['status'] == 'approved'): ?>
                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Terverifikasi</span>
                            <?php else: ?>
                                <span class="text-warning"><i class="bi bi-clock-fill"></i> Tertunda</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="k-card-body">
                    <div class="k-card-address">
                        <i class="bi bi-geo-alt text-primary me-1"></i> <?= esc($t['alamat']) ?>
                    </div>
                </div>
                <div class="k-card-footer">
                    <a href="<?= base_url('kuliner/detail/'.$t['id']) ?>" class="btn btn-sm btn-light border fw-bold text-dark w-100 rounded-pill">
                        <i class="bi bi-eye me-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
