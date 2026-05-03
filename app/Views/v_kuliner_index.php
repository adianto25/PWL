<?= $this->extend('layout') ?>
<?php
/**
 * @var array<int, array<string, mixed>> $kategori
 * @var array<int, array<string, mixed>> $tags
 * @var array<int, array<string, mixed>> $tempat
 * @var mixed $pager
 */
?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-12">
        <div id="mainMap" style="height: 400px; width: 100%; border-radius: 8px;"></div>
    </div>
</div>

<div class="card mb-4 shadow-sm border-0">
    <div class="card-body bg-light rounded">
        <form id="filterForm" role="search" method="GET" action="<?= base_url('/') ?>">
            <div class="row g-3">
                <div class="col-md-3">
                    <input class="form-control" type="search" placeholder="Cari nama atau alamat..." name="keyword" value="<?= esc($_GET['keyword'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="kategori_id">
                        <option value="">Semua Kategori</option>
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= (isset($_GET['kategori_id']) && $_GET['kategori_id']==$k['id'])?'selected':'' ?>><?= esc($k['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="tag_id">
                        <option value="">Semua Tag</option>
                        <?php foreach($tags as $t): ?>
                            <option value="<?= $t['id'] ?>" <?= (isset($_GET['tag_id']) && $_GET['tag_id']==$t['id'])?'selected':'' ?>><?= esc($t['nama_tag']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="min_rating">
                        <option value="">Semua Rating</option>
                        <option value="4" <?= (isset($_GET['min_rating']) && $_GET['min_rating']=='4')?'selected':'' ?>>≥ 4 Bintang</option>
                        <option value="3" <?= (isset($_GET['min_rating']) && $_GET['min_rating']=='3')?'selected':'' ?>>≥ 3 Bintang</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="number" class="form-control" name="jarak" placeholder="Max Jarak (km)" value="<?= esc($_GET['jarak'] ?? '') ?>" min="0" step="0.1">
                        <button class="btn btn-primary" type="submit" onclick="return setLocation()">Cari</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="user_lat" id="user_lat" value="<?= esc($_GET['user_lat'] ?? '') ?>">
            <input type="hidden" name="user_lng" id="user_lng" value="<?= esc($_GET['user_lng'] ?? '') ?>">
        </form>
    </div>
</div>

<h5 class="fw-bold mb-3">Rekomendasi Kuliner</h5>

<div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
    <?php if(empty($tempat)): ?>
        <div class="col-12 text-center text-muted py-5">Tidak ada tempat kuliner yang sesuai pencarian.</div>
    <?php endif; ?>
    <?php foreach($tempat as $t): ?>
    <div class="col">
        <div class="card h-100 border-1 shadow-sm">
            <a href="<?= base_url('kuliner/detail/'.$t['id']) ?>">
                <?php $imgSrc = !empty($t['foto_utama']) ? base_url('uploads/'.$t['foto_utama']) : base_url('NiceAdmin/assets/img/card.jpg'); ?>
                <img src="<?= $imgSrc ?>" class="card-img-top" style="object-fit: cover; height: 200px;" alt="Foto Tempat" onerror="this.src='https://placehold.co/800x600?text=Foto+Kuliner'">
            </a>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                    <span class="badge bg-secondary"><?= esc($t['nama_kategori']) ?></span>
                    <span class="text-warning small" title="Rating <?= number_format($t['avg_rating'], 1) ?>">
                        <?= str_repeat('<i class="bi bi-star-fill"></i>', (int)round((float)$t['avg_rating'])) . str_repeat('<i class="bi bi-star text-muted"></i>', 5-(int)round((float)$t['avg_rating'])) ?>
                        <span class="text-dark fw-bold ms-1"><?= number_format($t['avg_rating'], 1) ?></span>
                    </span>
                </div>
                <a href="<?= base_url('kuliner/detail/'.$t['id']) ?>" class="text-dark text-decoration-none">
                    <h5 class="card-title fw-bold p-0 mb-2"><?= esc($t['nama']) ?></h5>
                </a>
                <p class="card-text text-muted small mb-3" style="min-height: 40px;"><?= esc($t['alamat']) ?></p>
                <?php if(isset($t['distance'])): ?>
                    <p class="text-danger small fw-bold mb-2"><i class="bi bi-geo-alt"></i> <?= number_format($t['distance'], 1) ?> km dari lokasi Anda</p>
                <?php endif; ?>
                <a href="<?= base_url('kuliner/detail/'.$t['id']) ?>" class="btn btn-outline-primary btn-sm w-100 rounded-pill">Lihat Detail</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-center mt-4">
    <?= $pager ?>
</div>

<script>
    var kulinerData = <?= json_encode($tempat) ?>;
    function setLocation() {
        if(document.querySelector('input[name="jarak"]').value && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos){
                document.getElementById('user_lat').value = pos.coords.latitude;
                document.getElementById('user_lng').value = pos.coords.longitude;
                document.getElementById('filterForm').submit();
            }, function(){
                alert("Gagal mendapatkan lokasi. Pastikan izin lokasi aktif.");
                document.getElementById('filterForm').submit();
            });
            return false; // stop form submission until we get location
        }
        return true;
    }
</script>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('mainMap').setView([-6.9829, 110.4091], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var bounds = [];
    kulinerData.forEach(function(item) {
        if(item.lat && item.lng) {
            var latLng = [item.lat, item.lng];
            var marker = L.marker(latLng).addTo(map);
            marker.bindPopup(`
                <b>${item.nama}</b><br>
                ${item.nama_kategori}<br>
                <a href="<?= base_url('kuliner/detail/') ?>${item.id}" class="btn btn-sm btn-primary mt-2">Detail</a>
            `);
            bounds.push(latLng);
        }
    });

    if(bounds.length > 0) {
        map.fitBounds(bounds);
    }
</script>
<?= $this->endSection() ?>
