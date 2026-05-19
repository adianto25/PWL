<?= $this->extend('layout_clear') ?>
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
<link href="https://fonts.googleapis.com/css2?family=Playball&display=swap" rel="stylesheet">
<style>
    /* Override layout_clear.php header for Landing Page */
    main { margin-top: 0 !important; }
    
    #header {
        background: transparent !important;
        box-shadow: none !important;
        backdrop-filter: none !important;
        transition: all 0.4s ease;
    }
    
    #header.header-scrolled {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px) !important;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05) !important;
    }
    
    /* Logo and Links color adjustment */
    #header .logo span, #header .nav-link {
        color: white !important;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
        transition: color 0.4s ease;
    }
    
    #header.header-scrolled .logo span {
        color: #042509 !important;
        text-shadow: none;
    }
    
    #header.header-scrolled .nav-link {
        color: #042509 !important;
        text-shadow: none;
    }
    
    #header.header-scrolled .nav-link:hover {
        color: #165F39 !important;
    }

    #header .btn-outline-primary {
        border-color: white !important;
        color: white !important;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
    
    #header.header-scrolled .btn-outline-primary {
        border-color: #165F39 !important;
        color: #165F39 !important;
        text-shadow: none;
    }
    
    #header .btn-outline-primary:hover {
        background-color: white !important;
        color: #165F39 !important;
    }
    
    #header.header-scrolled .btn-outline-primary:hover {
        background-color: #165F39 !important;
        color: white !important;
    }
    .map-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        border: 4px solid #fff;
    }
    
    .filter-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.06);
        border: 1px solid rgba(255,255,255,0.4);
        padding: 25px;
        margin-bottom: 40px;
    }
    
    .filter-card .form-control, 
    .filter-card .form-select {
        border-radius: 12px;
        border: 1px solid #e0e4ec;
        padding: 12px 18px;
        background-color: #f8fafc;
        transition: all 0.3s;
    }
    
    .filter-card .form-control:focus, 
    .filter-card .form-select:focus {
        border-color: #165F39;
        box-shadow: 0 0 0 0.25rem rgba(22, 95, 57, 0.15);
        background-color: #fff;
    }

    .filter-btn {
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        background-color: #165F39;
        border: none;
        color: white;
        transition: all 0.3s;
    }

    .filter-btn:hover {
        background-color: #094217;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(9, 66, 23, 0.3);
    }

    .place-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s ease;
        background: #fff;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .place-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .place-img-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .place-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .place-card:hover .place-card-img {
        transform: scale(1.05);
    }

    .place-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(5px);
        color: #115934;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        z-index: 2;
    }

    .place-rating {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(4px);
        color: #fff;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
        z-index: 2;
    }

    .place-rating i {
        color: #ffc107;
    }

    .place-card-body {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .place-title {
        font-weight: 700;
        color: #042509;
        font-size: 1.2rem;
        margin-bottom: 10px;
        text-decoration: none;
    }

    .place-title:hover {
        color: #165F39;
    }

    .place-address {
        color: #888;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 15px;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .place-distance {
        color: #dc3545;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 15px;
    }

    .btn-detail {
        background-color: #f8f9fa;
        color: #115934;
        font-weight: 700;
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
        width: 100%;
        border: 1px solid #eee;
    }

    .btn-detail:hover {
        background-color: #115934;
        color: #fff;
        border-color: #115934;
    }
    
    .pagination-custom .pagination {
        gap: 5px;
    }
    .pagination-custom .page-item .page-link {
        border-radius: 8px;
        border: none;
        color: #555;
        padding: 8px 16px;
        font-weight: 500;
    }
    .pagination-custom .page-item.active .page-link {
        background-color: #165F39;
        color: white;
    }
    .pagination-custom .page-item.disabled .page-link {
        color: #adb5bd;
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- HERO SECTION (FULL WIDTH & HEIGHT) -->
<div class="hero-section text-center position-relative d-flex align-items-center justify-content-center" style="background: url('<?= base_url('NiceAdmin/assets/img/wallpaper (2).jpg') ?>') center/cover no-repeat; min-height: 100vh; width: 100%; padding: 0 20px; background-attachment: fixed;">
    <!-- Overlay Gradient for better readability using ZIA OLIVE and PINE GREEN -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(4,37,9,0.7) 0%, rgba(9,66,23,0.85) 100%);"></div>
    
    <div class="position-relative text-white" style="z-index: 1; padding-top: 80px; max-width: 900px;">
        <h2 class="mb-3" style="font-family: 'Playball', cursive; font-size: clamp(2.5rem, 5vw, 4rem); color: #D4AF37 !important; text-shadow: 2px 2px 8px rgba(0,0,0,0.4); line-height: 1;">Surga UMKM Lokal</h2>
        <h1 class="fw-bold mb-4" style="color: white !important; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); letter-spacing: -1px; font-size: clamp(2.5rem, 6vw, 4.5rem);">Temukan Rasa Terbaik di Sekitarmu</h1>
        <p class="mb-5 opacity-100" style="color: #e0e0e0 !important; max-width: 750px; margin: 0 auto; font-size: clamp(1.1rem, 2vw, 1.25rem); line-height: 1.7; text-shadow: 1px 1px 4px rgba(0,0,0,0.6);">Eksplorasi ribuan produk UMKM, kerajinan, dan layanan lokal yang direkomendasikan langsung oleh masyarakat.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="#kulinerSection" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-lg text-uppercase" style="padding-top: 16px; padding-bottom: 16px; letter-spacing: 1px; font-size: 1.1rem;">Eksplor Sekarang <i class="bi bi-arrow-down ms-2"></i></a>
        </div>
    </div>
</div>

<!-- MAIN CONTENT WRAPPER -->
<div class="container py-5">



    <!-- FILTER SECTION -->
<div class="filter-card">
    <form id="filterForm" role="search" method="GET" action="<?= base_url('/') ?>">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color:#e0e4ec;"><i class="bi bi-search text-muted"></i></span>
                    <input class="form-control border-start-0 ps-0" type="search" placeholder="Cari produk UMKM..." name="keyword" value="<?= esc($_GET['keyword'] ?? '') ?>" style="border-radius: 0 12px 12px 0;">
                </div>
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
                    <input type="number" class="form-control" name="jarak" placeholder="Jarak Maks (km)" value="<?= esc($_GET['jarak'] ?? '') ?>" min="0" step="0.1" style="border-radius: 12px 0 0 12px;">
                    <button class="filter-btn" type="submit" onclick="return setLocation()" style="border-radius: 0 12px 12px 0;">Cari</button>
                </div>
            </div>
        </div>
        <input type="hidden" name="user_lat" id="user_lat" value="<?= esc($_GET['user_lat'] ?? '') ?>">
        <input type="hidden" name="user_lng" id="user_lng" value="<?= esc($_GET['user_lng'] ?? '') ?>">
    </form>
</div>

<div id="kulinerSection" style="scroll-margin-top: 100px;"></div>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Rekomendasi UMKM Teratas</h4>
    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">Total: <?= count($tempat) ?> Ditemukan</span>
</div>

<!-- CARDS SECTION -->
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-5">
    <?php if(empty($tempat)): ?>
        <div class="col-12 w-100 text-center py-5">
            <div class="p-5 bg-white rounded-4 shadow-sm">
                <i class="bi bi-emoji-frown fs-1 text-muted mb-3 d-block"></i>
                <h5 class="fw-bold text-dark">Oops! Tidak Ditemukan</h5>
                <p class="text-muted">Tidak ada produk UMKM yang sesuai dengan kriteria pencarian Anda.</p>
                <a href="<?= base_url('/') ?>" class="btn btn-outline-primary rounded-pill mt-2 px-4">Reset Pencarian</a>
            </div>
        </div>
    <?php endif; ?>
    
    <?php foreach($tempat as $t): ?>
    <div class="col">
        <div class="place-card">
            <div class="place-img-wrapper">
                <span class="place-badge"><?= esc($t['nama_kategori']) ?></span>
                <span class="place-rating">
                    <i class="bi bi-star-fill"></i> <?= number_format($t['avg_rating'], 1) ?>
                </span>
                <a href="<?= base_url('kuliner/detail/'.$t['id']) ?>">
                    <?php 
                        if (!empty($t['foto_utama'])) {
                            $f_path = $t['foto_utama'];
                            $imgSrc = (strpos($f_path, 'NiceAdmin') !== false) ? base_url($f_path) : base_url('uploads/'.$f_path);
                        } else {
                            $imgSrc = 'https://placehold.co/800x600?text=Foto+Kuliner';
                        }
                    ?>
                    <img src="<?= $imgSrc ?>" class="place-card-img" alt="<?= esc($t['nama']) ?>" onerror="this.src='https://placehold.co/800x600?text=Foto+Kuliner'">
                </a>
            </div>
            <div class="place-card-body">
                <a href="<?= base_url('kuliner/detail/'.$t['id']) ?>" class="place-title">
                    <?= esc($t['nama']) ?>
                </a>
                <p class="place-address"><i class="bi bi-geo-alt me-1 text-muted"></i> <?= esc($t['alamat']) ?></p>
                
                <?php if(isset($t['distance'])): ?>
                    <div class="place-distance">
                        <i class="bi bi-cursor-fill"></i> Berjarak <?= number_format($t['distance'], 1) ?> km dari Anda
                    </div>
                <?php else: ?>
                    <!-- Spacer to keep layout aligned when distance isn't present -->
                    <div class="mb-3" style="height: 20px;"></div>
                <?php endif; ?>
                
                <a href="<?= base_url('kuliner/detail/'.$t['id']) ?>" class="btn-detail mt-auto">
                    Lihat Detail Lengkap
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-center pagination-custom mt-4 mb-5">
    <?= $pager ?>
</div>

    <div id="mapsSection" style="scroll-margin-top: 100px;"></div>
    <!-- MAP SECTION -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Lokasi UMKM di Peta</h4>
                <p class="text-muted mb-0">Temukan produk UMKM terdekat dari lokasimu</p>
            </div>
            <div class="map-container shadow-lg" style="border: none;">
                <div id="mainMap" style="height: 450px; width: 100%;"></div>
            </div>
        </div>
    </div>

</div> <!-- End Container Fluid -->

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
            return false;
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
            
            // Custom Popup Styling
            var popupContent = `
                <div style="text-align: center; min-width: 150px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 5px; color: #042509;">${item.nama}</div>
                    <span style="background: #BCD5AC; color: #042509; padding: 2px 8px; border-radius: 12px; font-size: 11px; display: inline-block; margin-bottom: 10px; font-weight:600;">${item.nama_kategori}</span><br>
                    <a href="<?= base_url('kuliner/detail/') ?>${item.id}" style="background: #165F39; color: #fff; padding: 5px 15px; border-radius: 20px; text-decoration: none; font-size: 12px; display: inline-block;">Lihat Detail</a>
                </div>
            `;
            marker.bindPopup(popupContent);
            bounds.push(latLng);
        }
    });

    if(bounds.length > 0) {
        map.fitBounds(bounds, {padding: [50, 50]});
    }

    // Scroll Header Effect
    window.addEventListener('scroll', function() {
        const header = document.getElementById('header');
        if (window.scrollY > 50) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
    });
</script>
<?= $this->endSection() ?>
