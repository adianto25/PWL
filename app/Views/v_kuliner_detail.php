<?= $this->extend('layout_clear') ?>
<?php
/**
 * @var array<string, mixed> $tempat
 * @var array<int, array<string, mixed>> $reviews
 * @var array<int, int> $ratingCounts
 * @var int $totalReviews
 */
?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .hero-img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }
    
    .detail-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        padding: 30px;
        border: none;
        margin-bottom: 30px;
    }

    .badge-category {
        background-color: #BCD5AC;
        color: #042509;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        display: inline-block;
        margin-bottom: 15px;
    }

    .action-btn {
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .action-btn.btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    .review-summary-card {
        background: #fafbfe;
        border-radius: 16px;
        padding: 30px;
        border: 1px solid #eef0f8;
        display: flex;
        align-items: center;
        gap: 40px;
        margin-bottom: 30px;
    }

    .rating-big {
        text-align: center;
        min-width: 120px;
    }

    .rating-big h1 {
        font-size: 4rem;
        font-weight: 800;
        color: #042509;
        margin: 0;
        line-height: 1;
    }

    .rating-bars {
        flex-grow: 1;
    }

    .progress-custom {
        height: 10px;
        border-radius: 10px;
        background-color: #e9ecef;
    }

    .progress-bar-custom {
        background-color: #ffc107;
        border-radius: 10px;
    }

    .review-item {
        padding: 25px 0;
        border-bottom: 1px solid #eee;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .reviewer-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #165F39;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .map-sidebar {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        padding: 20px;
        border: none;
        position: sticky;
        top: 100px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-4">
<div class="row g-4">
    <div class="col-lg-8">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Main Image -->
        <?php 
            if (!empty($tempat['fotos']) && !empty($tempat['fotos'][0]['foto_path'])) {
                $f_path = $tempat['fotos'][0]['foto_path'];
                $imgSrc = (strpos($f_path, 'NiceAdmin') !== false) ? base_url($f_path) : base_url('uploads/'.$f_path);
            } else {
                $imgSrc = 'https://placehold.co/1200x500?text=Foto+UMKM';
            }
        ?>
        <img src="<?= $imgSrc ?>" class="hero-img" alt="Foto <?= esc($tempat['nama']) ?>" onerror="this.src='https://placehold.co/1200x500?text=Foto+UMKM'">
        
        <!-- Detail Info -->
        <div class="detail-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge-category"><?= esc($tempat['nama_kategori']) ?></span>
                <span class="text-muted small"><i class="bi bi-person-circle"></i> Ditambahkan oleh: <strong><?= esc($tempat['username']) ?></strong></span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fw-bold text-dark mb-2" style="font-size: 2.5rem; letter-spacing: -1px;"><?= esc($tempat['nama']) ?></h1>
                    <p class="text-muted fs-5 mb-0"><i class="bi bi-geo-alt text-primary"></i> <?= esc($tempat['alamat']) ?></p>
                </div>
                
                <?php if(session()->get('isLoggedIn')): ?>
                    <?php
                        $db = \Config\Database::connect();
                        $isFavorit = $db->table('favorit')
                                        ->where('user_id', session()->get('user_id'))
                                        ->where('tempat_id', $tempat['id'])
                                        ->countAllResults() > 0;
                    ?>
                    <div class="d-flex gap-2 flex-column flex-sm-row">
                        <form action="<?= base_url('kontributor/favorit/'.$tempat['id']) ?>" method="POST">
                            <button type="submit" class="btn action-btn <?= $isFavorit ? 'btn-danger' : 'btn-outline-danger' ?> w-100">
                                <i class="bi bi-heart<?= $isFavorit ? '-fill' : '' ?>"></i> <?= $isFavorit ? 'Difavoritkan' : 'Favorit' ?>
                            </button>
                        </form>
                        <form action="<?= base_url('kontributor/tutup/'.$tempat['id']) ?>" method="POST" onsubmit="return confirm('Laporkan tempat ini tutup permanen?')">
                            <button type="submit" class="btn action-btn btn-outline-warning text-dark w-100">
                                <i class="bi bi-exclamation-triangle"></i> Lapor Tutup
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if(!empty($tempat['tags'])): ?>
                <div class="d-flex gap-2 mb-4 flex-wrap">
                    <?php foreach($tempat['tags'] as $tag): ?>
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill"><i class="bi bi-tag"></i> <?= esc($tag['nama_tag']) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <hr class="text-muted opacity-25">
            
            <h5 class="fw-bold text-dark mb-3 mt-4">Tentang Tempat Ini</h5>
            <p class="text-secondary" style="line-height: 1.8; font-size: 1.05rem;"><?= nl2br(esc($tempat['deskripsi'])) ?></p>
        </div>

        <!-- Reviews Section -->
        <div class="detail-card">
            <h4 class="fw-bold mb-4 text-dark">Ulasan & Penilaian</h4>
            
            <?php if($totalReviews > 0): ?>
            <div class="review-summary-card">
                <div class="rating-big">
                    <h1><?= number_format($tempat['avg_rating'], 1) ?></h1>
                    <div class="text-warning fs-5 mb-1">
                        <?= str_repeat('<i class="bi bi-star-fill"></i>', (int)round((float)$tempat['avg_rating'])) . str_repeat('<i class="bi bi-star text-muted"></i>', 5-(int)round((float)$tempat['avg_rating'])) ?>
                    </div>
                    <p class="text-muted small fw-bold mb-0"><?= esc($totalReviews) ?> Ulasan</p>
                </div>
                
                <div class="rating-bars">
                    <?php for($star=5; $star>=1; $star--): ?>
                        <?php 
                            $count = $ratingCounts[$star];
                            $percentage = ($totalReviews > 0) ? ($count / $totalReviews) * 100 : 0;
                        ?>
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-secondary fw-bold small" style="width: 30px;"><?= $star ?> <i class="bi bi-star-fill text-warning"></i></div>
                            <div class="progress progress-custom flex-grow-1 mx-3">
                                <div class="progress-bar progress-bar-custom" role="progressbar" style="width: <?= $percentage ?>%"></div>
                            </div>
                            <div class="text-muted small fw-bold text-end" style="width: 30px;"><?= $count ?></div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="reviews-list mt-4">
                <?php if(empty($reviews)): ?>
                    <div class="text-center py-5 bg-light rounded-4">
                        <i class="bi bi-chat-left-text fs-1 text-muted mb-2 d-block"></i>
                        <h6 class="text-muted mb-0">Belum ada ulasan. Jadilah yang pertama!</h6>
                    </div>
                <?php else: ?>
                    <?php foreach($reviews as $r): ?>
                    <div class="review-item">

                        <div class="d-flex gap-3">
                            <div class="reviewer-avatar">
                                <?= strtoupper(substr(esc($r['username']), 0, 1)) ?>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0 text-dark"><?= esc($r['username']) ?></h6>
                                    <span class="text-muted small"><i class="bi bi-clock"></i> <?= date('d M Y', strtotime($r['created_at'])) ?></span>
                                </div>
                                <div class="text-warning small mb-2">
                                    <?php for($i=1; $i<=5; $i++) echo ($i <= $r['rating']) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star text-muted"></i>'; ?>
                                </div>
                                <p class="mb-2 text-secondary" style="line-height: 1.6;"><?= esc($r['review_text']) ?></p>
                                
                                <div class="d-flex gap-3">
                                    <?php if(session()->get('user_id') == $r['user_id'] && (time() - strtotime($r['created_at']) <= 86400)): ?>
                                        <button type="button" class="btn btn-link text-primary p-0 small fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#editReviewModal<?= $r['id'] ?>"><i class="bi bi-pencil"></i> Edit</button>
                                    <?php endif; ?>
                                    <?php if(session()->get('role') == 'admin'): ?>
                                        <a href="<?= base_url('admin/review/delete/'.$r['id']) ?>" onclick="return confirm('Hapus ulasan ini?')" class="text-danger small fw-bold text-decoration-none"><i class="bi bi-trash"></i> Hapus</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if(session()->get('user_id') == $r['user_id'] && (time() - strtotime($r['created_at']) <= 86400)): ?>
                    <!-- Modal Edit Review -->
                    <div class="modal fade" id="editReviewModal<?= $r['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="<?= base_url('kontributor/review/update/'.$r['id']) ?>" method="POST" class="modal-content border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Edit Ulasan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-secondary">Rating</label>
                                        <select name="rating" class="form-select form-select-lg" required style="border-radius: 12px;">
                                            <option value="5" <?= $r['rating']==5?'selected':'' ?>>★★★★★ (5) - Sangat Bagus</option>
                                            <option value="4" <?= $r['rating']==4?'selected':'' ?>>★★★★☆ (4) - Bagus</option>
                                            <option value="3" <?= $r['rating']==3?'selected':'' ?>>★★★☆☆ (3) - Biasa</option>
                                            <option value="2" <?= $r['rating']==2?'selected':'' ?>>★★☆☆☆ (2) - Kurang</option>
                                            <option value="1" <?= $r['rating']==1?'selected':'' ?>>★☆☆☆☆ (1) - Sangat Kurang</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-secondary">Ceritakan Pengalamanmu</label>
                                        <textarea name="review_text" class="form-control" rows="4" required style="border-radius: 12px;"><?= esc($r['review_text']) ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Tulis Ulasan Form -->
            <?php if(session()->get('isLoggedIn')): ?>
                <div class="mt-5 p-4 rounded-4" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                    <h5 class="fw-bold mb-3 text-dark">Bagikan Pengalaman Anda</h5>
                    <form action="<?= base_url('kontributor/review/'.$tempat['id']) ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-bold small">Pilih Rating</label>
                            <select name="rating" class="form-select" required style="border-radius: 10px;">
                                <option value="5">★★★★★ (5) - Sangat Bagus</option>
                                <option value="4">★★★★☆ (4) - Bagus</option>
                                <option value="3">★★★☆☆ (3) - Biasa</option>
                                <option value="2">★★☆☆☆ (2) - Kurang</option>
                                <option value="1">★☆☆☆☆ (1) - Sangat Kurang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-bold small">Ulasan Lengkap</label>
                            <textarea name="review_text" class="form-control" rows="4" placeholder="Bagaimana rasa makanannya? Suasananya? Pelayanannya?" required style="border-radius: 10px; resize: none;"></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Kirim Ulasan</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-primary mt-5 rounded-4 d-flex align-items-center gap-3">
                    <i class="bi bi-info-circle-fill fs-3"></i>
                    <div>
                        <strong>Ingin memberikan ulasan?</strong><br>
                        Silakan <a href="<?= base_url('/login') ?>" class="alert-link">login</a> terlebih dahulu untuk membagikan pengalaman Anda.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="map-sidebar">
            <h5 class="fw-bold text-dark mb-3">Peta Lokasi</h5>
            <div id="detailMap" style="height: 250px; width: 100%; border-radius: 12px; margin-bottom: 20px;"></div>
            
            <div class="d-flex align-items-center gap-2 text-muted small mb-3 bg-light p-2 rounded">
                <i class="bi bi-geo"></i> <span><?= esc($tempat['lat']) ?>, <?= esc($tempat['lng']) ?></span>
            </div>
            
            <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $tempat['lat'] ?>,<?= $tempat['lng'] ?>" target="_blank" class="btn btn-primary w-100 rounded-pill fw-bold" style="padding: 12px;">
                <i class="bi bi-cursor"></i> Dapatkan Petunjuk Arah
            </a>
        </div>
    </div>
</div>
</div> <!-- End Container Fluid -->

<script>
    var tempatDetail = <?= json_encode($tempat) ?>;
</script>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    if (tempatDetail.lat && tempatDetail.lng) {
        var map = L.map('detailMap').setView([tempatDetail.lat, tempatDetail.lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:#165F39; width:20px; height:20px; border-radius:50%; border:3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);'></div>",
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        L.marker([tempatDetail.lat, tempatDetail.lng], {icon: customIcon}).addTo(map)
            .bindPopup('<b style="color:#042509;">' + tempatDetail.nama + '</b>')
            .openPopup();
    } else {
        document.getElementById('detailMap').innerHTML = '<div class="d-flex h-100 justify-content-center align-items-center bg-light text-muted rounded-3 border">Koordinat tidak tersedia</div>';
    }
</script>
<?= $this->endSection() ?>
