<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .submit-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: none;
        overflow: hidden;
    }
    .submit-header {
        background-color: #f8f9fa;
        padding: 25px 30px;
        border-bottom: 1px solid #eef0f8;
    }
    .submit-body {
        padding: 40px;
    }
    .form-label {
        font-weight: 600;
        color: #2c384e;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        background-color: #f9fafc;
        transition: all 0.3s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4154f1;
        box-shadow: 0 0 0 0.25rem rgba(65, 84, 241, 0.1);
        background-color: #fff;
    }
    .map-container-submit {
        height: 280px; 
        width: 100%; 
        border-radius: 16px; 
        border: 2px solid #f0f0f0;
        overflow: hidden;
    }
    .tag-checkbox-wrapper {
        background: #f9fafc;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 15px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mb-5">
    <div class="col-lg-10">
        <div class="submit-card">
            <div class="submit-header">
                <h4 class="fw-bold mb-1" style="color: #012970;">Ajukan Produk UMKM Baru</h4>
                <p class="text-muted mb-0 small">Bantu orang lain menemukan tempat makan terbaik di sekitarmu.</p>
            </div>
            <div class="submit-body">
                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger mb-4 rounded-3">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
                <form action="<?= base_url('kontributor/submit') ?>" method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Nama Tempat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" placeholder="Contoh: Warung Nasi Kucing Pak Gik" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" name="kategori_id" required>
                                    <option value="">Pilih Kategori UMKM...</option>
                                    <?php foreach($kategori as $k): ?>
                                        <option value="<?= $k['id'] ?>"><?= esc($k['nama_kategori']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label d-block">Fasilitas & Layanan (Tags)</label>
                                <div class="tag-checkbox-wrapper">
                                    <div class="row g-3">
                                        <?php foreach($tags as $t): ?>
                                        <div class="col-6 col-sm-4">
                                            <div class="form-check custom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="tags[]" value="<?= $t['id'] ?>" id="tag<?= $t['id'] ?>">
                                                <label class="form-check-label text-secondary small" for="tag<?= $t['id'] ?>">
                                                    <?= esc($t['nama_tag']) ?>
                                                </label>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control mb-2" name="alamat" id="alamat" rows="3" placeholder="Tuliskan alamat selengkap mungkin..." required style="resize: none;"></textarea>
                                
                                <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-bold" id="btnCariKoordinat">
                                    <i class="bi bi-geo-alt-fill me-1"></i> Deteksi Koordinat Peta
                                </button>
                                <small class="text-muted ms-2" style="font-size: 0.8rem;">(Wajib sebelum submit)</small>
                            </div>
                            <input type="hidden" name="lat" id="lat" required>
                            <input type="hidden" name="lng" id="lng" required>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Peta Titik Lokasi</label>
                                <div id="submitMap" class="map-container-submit"></div>
                                <small class="text-warning mt-2 d-block fw-bold"><i class="bi bi-info-circle"></i> Klik "Deteksi Koordinat Peta" agar titik muncul otomatis.</small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Deskripsi Tempat</label>
                                <textarea class="form-control" name="deskripsi" rows="3" placeholder="Ceritakan apa yang spesial dari tempat ini..." style="resize: none;"></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Upload Foto (Max 3 Foto)</label>
                                <input type="file" class="form-control form-control-lg" name="fotos[]" multiple accept="image/*" style="font-size: 0.9rem;">
                                <small class="text-muted mt-1 d-block">Format: JPG, PNG. Ukuran gambar akan di-resize otomatis.</small>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-5 text-muted opacity-25">
                    
                    <div class="d-flex justify-content-end gap-3">
                        <a href="<?= base_url('kontributor/dashboard') ?>" class="btn btn-light rounded-pill px-5 fw-bold text-secondary border">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Kirim untuk Dimoderasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('submitMap').setView([-6.9829, 110.4091], 13);
    var marker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Fitur Baru: Izinkan klik pada peta untuk menentukan lokasi manual
    map.on('click', function(e) {
        var latLng = e.latlng;
        document.getElementById('lat').value = latLng.lat;
        document.getElementById('lng').value = latLng.lng;
        
        var customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:#4154f1; width:20px; height:20px; border-radius:50%; border:3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);'></div>",
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        if(marker) {
            marker.setLatLng(latLng);
        } else {
            marker = L.marker(latLng, {icon: customIcon}).addTo(map);
        }
    });

    document.getElementById('btnCariKoordinat').addEventListener('click', function() {
        var alamat = document.getElementById('alamat').value;
        if(!alamat) {
            alert('Tolong isi alamat lengkapnya dulu ya!');
            return;
        }

        var btn = this;
        var originalText = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mencari...';
        btn.disabled = true;

        fetch('<?= base_url('kontributor/geocode') ?>?q=' + encodeURIComponent(alamat))
            .then(response => response.json())
            .then(data => {
                if(data.error) {
                    alert('Sistem otomatis (Nominatim) kesulitan mendeteksi alamat ini secara persis. \n\nSOLUSI: Silakan KLIK LANGSUNG PADA PETA untuk menentukan letak titik lokasinya secara manual.');
                } else {
                    document.getElementById('lat').value = data.lat;
                    document.getElementById('lng').value = data.lon;

                    var latLng = [data.lat, data.lon];
                    map.setView(latLng, 16);
                    
                    var customIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:#4154f1; width:20px; height:20px; border-radius:50%; border:3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);'></div>",
                        iconSize: [20, 20],
                        iconAnchor: [10, 10]
                    });

                    if(marker) {
                        marker.setLatLng(latLng);
                    } else {
                        marker = L.marker(latLng, {icon: customIcon}).addTo(map);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi gangguan jaringan saat mencari koordinat. Silakan KLIK LANGSUNG PADA PETA untuk menentukan titik manual.');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    });
</script>
<?= $this->endSection() ?>
