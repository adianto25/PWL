<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h4 class="fw-bold mb-0">Submit Tempat Kuliner Baru</h4>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('kontributor/submit') ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Tempat</label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select class="form-select" name="kategori_id" required>
                                    <option value="">Pilih Kategori...</option>
                                    <?php foreach($kategori as $k): ?>
                                        <option value="<?= $k['id'] ?>"><?= esc($k['nama_kategori']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Fasilitas (Tags)</label>
                                <div class="row g-2">
                                    <?php foreach($tags as $t): ?>
                                    <div class="col-6 col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tags[]" value="<?= $t['id'] ?>" id="tag<?= $t['id'] ?>">
                                            <label class="form-check-label" for="tag<?= $t['id'] ?>">
                                                <?= esc($t['nama_tag']) ?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="2" required></textarea>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2 rounded-pill px-3" id="btnCariKoordinat">
                                    <i class="bi bi-search"></i> Cari Koordinat
                                </button>
                            </div>
                                <input type="hidden" name="lat" id="lat" required>
                                <input type="hidden" name="lng" id="lng" required>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Peta Lokasi</label>
                                <div id="submitMap" style="height: 250px; width: 100%; border-radius: 8px; border: 1px solid #dee2e6;"></div>
                                <small class="text-muted mt-1 d-block">Klik "Cari Koordinat" setelah mengisi alamat untuk melihat titik peta.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Upload Foto (Max 3)</label>
                                <input type="file" class="form-control" name="fotos[]" multiple accept="image/*">
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= base_url('kontributor/dashboard') ?>" class="btn btn-light px-4 rounded-pill">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold rounded-pill">Submit Tempat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Inisialisasi peta di koordinat UDINUS (Semarang)
    var map = L.map('submitMap').setView([-6.9829, 110.4091], 13);
    var marker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    document.getElementById('btnCariKoordinat').addEventListener('click', function() {
        var alamat = document.getElementById('alamat').value;
        if(!alamat) {
            alert('Silakan isi alamat terlebih dahulu!');
            return;
        }

        var btn = this;
        btn.innerHTML = 'Mencari...';
        btn.disabled = true;

        // Panggil endpoint API internal kita yang me-request ke Nominatim
        fetch('<?= base_url('kontributor/geocode') ?>?q=' + encodeURIComponent(alamat))
            .then(response => response.json())
            .then(data => {
                if(data.error) {
                    alert(data.error);
                } else {
                    document.getElementById('lat').value = data.lat;
                    document.getElementById('lng').value = data.lon;

                    var latLng = [data.lat, data.lon];
                    map.setView(latLng, 16);
                    
                    if(marker) {
                        marker.setLatLng(latLng);
                    } else {
                        marker = L.marker(latLng).addTo(map);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mencari koordinat. Pastikan server merespons.');
            })
            .finally(() => {
                btn.innerHTML = '<i class="bi bi-search"></i> Cari Koordinat';
                btn.disabled = false;
            });
    });
</script>
<?= $this->endSection() ?>
