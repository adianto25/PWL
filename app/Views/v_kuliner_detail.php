<?= $this->extend('layout') ?>
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
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8">
        <div class="mb-4">
            <img src="<?= base_url('uploads/'.$tempat['foto_path']) ?>" class="img-fluid rounded mb-3 w-100" style="object-fit: cover; max-height: 400px;" alt="Foto" onerror="this.src='https://via.placeholder.com/1200x500?text=Foto+Kuliner'">
            <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
                <span class="badge bg-primary px-3 py-2"><?= esc($tempat['nama_kategori']) ?></span>
                <span class="text-muted small">Ditambahkan oleh: <?= esc($tempat['username']) ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h2 class="fw-bold mb-1"><?= esc($tempat['nama']) ?></h2>
                    <p class="text-muted mb-0">📍 <?= esc($tempat['alamat']) ?></p>
                </div>
                <?php if(session()->get('isLoggedIn')): ?>
                    <?php
                        $db = \Config\Database::connect();
                        $isFavorit = $db->table('favorit')
                                        ->where('user_id', session()->get('user_id'))
                                        ->where('tempat_id', $tempat['id'])
                                        ->countAllResults() > 0;
                    ?>
                    <div class="d-flex gap-2">
                        <form action="<?= base_url('kontributor/favorit/'.$tempat['id']) ?>" method="POST">
                            <button type="submit" class="btn btn-sm <?= $isFavorit ? 'btn-danger' : 'btn-outline-danger' ?> rounded-pill px-3">
                                <i class="bi bi-heart<?= $isFavorit ? '-fill' : '' ?>"></i> Favorit
                            </button>
                        </form>
                        <form action="<?= base_url('kontributor/tutup/'.$tempat['id']) ?>" method="POST" onsubmit="return confirm('Laporkan tempat ini tutup permanen?')">
                            <button type="submit" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3">
                                <i class="bi bi-exclamation-triangle"></i> Tutup
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            <hr>
            <h5 class="fw-bold">Deskripsi</h5>
            <p><?= esc($tempat['deskripsi']) ?></p>
        </div>

        <div class="mb-4 mt-5 border-top pt-4">
            <h4 class="fw-bold mb-4">Ulasan & Penilaian (<?= esc($totalReviews) ?>)</h4>
            
            <?php if($totalReviews > 0): ?>
            <div class="row mb-4 align-items-center bg-light p-3 rounded mx-0">
                <div class="col-md-4 text-center border-end">
                    <h1 class="display-3 fw-bold text-dark mb-0"><?= number_format($tempat['avg_rating'], 1) ?></h1>
                    <div class="text-warning fs-4 mb-1">
                        <?= str_repeat('<i class="bi bi-star-fill"></i>', (int)round((float)$tempat['avg_rating'])) . str_repeat('<i class="bi bi-star text-muted"></i>', 5-(int)round((float)$tempat['avg_rating'])) ?>
                    </div>
                    <p class="text-muted small mb-0"><?= esc($totalReviews) ?> Ulasan</p>
                </div>
                <div class="col-md-8 px-4">
                    <?php for($star=5; $star>=1; $star--): ?>
                        <?php 
                            $count = $ratingCounts[$star];
                            $percentage = ($totalReviews > 0) ? ($count / $totalReviews) * 100 : 0;
                        ?>
                        <div class="d-flex align-items-center mb-1">
                            <div class="text-muted small" style="width: 25px;"><?= $star ?> <i class="bi bi-star-fill text-warning"></i></div>
                            <div class="progress flex-grow-1 mx-2" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="text-muted small text-end" style="width: 30px;"><?= $count ?></div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if(empty($reviews)): ?>
                <p class="text-muted">Belum ada ulasan untuk tempat ini.</p>
            <?php else: ?>
                <?php foreach($reviews as $r): ?>
                <div class="mb-3 border-bottom pb-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-bold mb-1"><?= esc($r['username']) ?></h6>
                        <span class="text-warning">
                            <?php for($i=1; $i<=5; $i++) echo ($i <= $r['rating']) ? '★' : '☆'; ?>
                        </span>
                    </div>
                    <p class="mb-0 small"><?= esc($r['review_text']) ?></p>
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        <small class="text-muted"><?= date('d M Y H:i', strtotime($r['created_at'])) ?></small>
                        <div class="d-flex gap-3">
                            <?php if(session()->get('user_id') == $r['user_id'] && (time() - strtotime($r['created_at']) <= 86400)): ?>
                                <button type="button" class="btn btn-link text-warning p-0 small text-decoration-none" data-bs-toggle="modal" data-bs-target="#editReviewModal<?= $r['id'] ?>"><i class="bi bi-pencil"></i> Edit</button>
                            <?php endif; ?>
                            <?php if(session()->get('role') == 'admin'): ?>
                                <a href="<?= base_url('admin/review/delete/'.$r['id']) ?>" onclick="return confirm('Hapus ulasan ini?')" class="text-danger small text-decoration-none"><i class="bi bi-trash"></i> Hapus</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if(session()->get('user_id') == $r['user_id'] && (time() - strtotime($r['created_at']) <= 86400)): ?>
                <!-- Modal Edit Review -->
                <div class="modal fade" id="editReviewModal<?= $r['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="<?= base_url('kontributor/review/update/'.$r['id']) ?>" method="POST" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Ulasan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Rating</label>
                                    <select name="rating" class="form-select" required>
                                        <option value="5" <?= $r['rating']==5?'selected':'' ?>>★★★★★ (5) - Sangat Bagus</option>
                                        <option value="4" <?= $r['rating']==4?'selected':'' ?>>★★★★☆ (4) - Bagus</option>
                                        <option value="3" <?= $r['rating']==3?'selected':'' ?>>★★★☆☆ (3) - Biasa</option>
                                        <option value="2" <?= $r['rating']==2?'selected':'' ?>>★★☆☆☆ (2) - Kurang</option>
                                        <option value="1" <?= $r['rating']==1?'selected':'' ?>>★☆☆☆☆ (1) - Sangat Kurang</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ulasan</label>
                                    <textarea name="review_text" class="form-control" rows="3" required><?= esc($r['review_text']) ?></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

                <?php endforeach; ?>
            <?php endif; ?>

            <?php if(session()->get('isLoggedIn')): ?>
                <div class="mt-4 p-4 bg-light rounded-3 border">
                    <h6 class="fw-bold mb-3">Tulis Ulasan Anda</h6>
                    <form action="<?= base_url('kontributor/review/'.$tempat['id']) ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating</label>
                            <select name="rating" class="form-select" required>
                                <option value="5">★★★★★ (5) - Sangat Bagus</option>
                                <option value="4">★★★★☆ (4) - Bagus</option>
                                <option value="3">★★★☆☆ (3) - Biasa</option>
                                <option value="2">★★☆☆☆ (2) - Kurang</option>
                                <option value="1">★☆☆☆☆ (1) - Sangat Kurang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ulasan</label>
                            <textarea name="review_text" class="form-control" rows="3" placeholder="Bagaimana pengalaman Anda makan di sini?" required></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Kirim Ulasan</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-info mt-4 mb-0">
                    Silakan <a href="<?= base_url('/login') ?>" class="alert-link">login</a> untuk menulis ulasan.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="sticky-top bg-light p-3 rounded border" style="top: 80px;">
            <div id="detailMap" style="height: 300px; width: 100%; border-radius: 8px;"></div>
            <div class="text-center mt-3">
                <h6 class="fw-bold">Lokasi Peta</h6>
                <p class="small text-muted mb-3"><?= esc($tempat['lat']) ?>, <?= esc($tempat['lng']) ?></p>
                <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $tempat['lat'] ?>,<?= $tempat['lng'] ?>" target="_blank" class="btn btn-primary w-100 rounded-pill">
                    Petunjuk Arah
                </a>
            </div>
        </div>
    </div>
</div>

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

        L.marker([tempatDetail.lat, tempatDetail.lng]).addTo(map)
            .bindPopup('<b>' + tempatDetail.nama + '</b>')
            .openPopup();
    } else {
        document.getElementById('detailMap').innerHTML = '<div class="d-flex h-100 justify-content-center align-items-center bg-light text-muted">Koordinat tidak tersedia</div>';
    }
</script>
<?= $this->endSection() ?>
