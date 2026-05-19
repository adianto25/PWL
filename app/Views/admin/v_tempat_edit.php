<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<style>
    .photo-card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #dee2e6;
        position: relative;
    }
    .photo-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    .photo-card .btn-delete {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s;
    }
    .photo-card .btn-delete:hover {
        transform: scale(1.1);
        background: #dc3545;
    }
    .asset-preview-btn {
        cursor: pointer;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
    <h5 class="mb-0 fw-bold">Edit Tempat UMKM</h5>
    <a href="<?= base_url('admin') ?>" class="btn btn-secondary btn-sm rounded-pill px-3">Kembali</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <form action="<?= base_url('admin/tempat/update/'.$tempat['id']) ?>" method="POST" class="p-3 bg-white rounded shadow-sm border" enctype="multipart/form-data">
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger mb-4 rounded-3">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
            <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Data Informasi UMKM</h6>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Tempat</label>
                <input type="text" name="nama" class="form-control" value="<?= esc($tempat['nama']) ?>" required>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= $k['id'] == $tempat['kategori_id'] ? 'selected' : '' ?>><?= esc($k['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status Moderasi</label>
                    <select name="status" class="form-select" required>
                        <option value="pending" <?= $tempat['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= $tempat['status'] == 'approved' ? 'selected' : '' ?>>Disetujui</option>
                        <option value="rejected" <?= $tempat['status'] == 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Fasilitas (Tags)</label>
                <div class="row g-2">
                    <?php foreach($tags as $t): ?>
                    <div class="col-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tags[]" value="<?= $t['id'] ?>" id="tag<?= $t['id'] ?>" <?= in_array($t['id'], $selected_tags) ? 'checked' : '' ?>>
                            <label class="form-check-label text-secondary small" for="tag<?= $t['id'] ?>">
                                <?= esc($t['nama_tag']) ?>
                            </label>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required><?= esc($tempat['deskripsi']) ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" required><?= esc($tempat['alamat']) ?></textarea>
            </div>

            <h6 class="fw-bold text-primary mb-3 border-bottom pb-2 mt-4">Manajemen Foto (Maksimal 3)</h6>
            
            <!-- List Existing Photos -->
            <div class="mb-4">
                <label class="form-label fw-bold text-secondary small">Foto Saat Ini (<?= count($fotos) ?>/3)</label>
                <div class="row g-3">
                    <?php if(empty($fotos)): ?>
                        <div class="col-12">
                            <div class="alert alert-warning py-2 mb-0 small"><i class="bi bi-exclamation-triangle"></i> Tempat ini belum memiliki foto. Akan menggunakan foto gelap (placeholder) di halaman depan.</div>
                        </div>
                    <?php else: ?>
                        <?php foreach($fotos as $f): ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="photo-card shadow-sm">
                                <?php $src = (strpos($f['foto_path'], 'NiceAdmin') !== false) ? base_url($f['foto_path']) : base_url('uploads/'.$f['foto_path']); ?>
                                <img src="<?= $src ?>" alt="Foto Tempat">
                                <a href="<?= base_url('admin/foto/delete/'.$f['id']) ?>" class="btn-delete" onclick="return confirm('Hapus foto ini?')" title="Hapus Foto">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Add New Photos -->
            <?php if(count($fotos) < 3): ?>
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body p-3">
                        <label class="form-label fw-bold text-dark mb-3">Tambahkan Foto Baru</label>
                        
                        <div class="mb-3">
                            <label class="form-label small text-secondary fw-bold">Opsi 1: Upload dari Perangkat Anda</label>
                            <input type="file" class="form-control" name="foto_upload[]" multiple accept="image/*">
                            <small class="text-muted d-block mt-1">Anda bisa memilih maksimal <?= 3 - count($fotos) ?> gambar (JPG/PNG).</small>
                        </div>
                        
                        <div class="text-center my-2 text-muted fw-bold">ATAU</div>
                        
                        <div class="mb-2">
                            <label class="form-label small text-secondary fw-bold">Opsi 2: Pilih dari Aset Template (NiceAdmin)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-images text-primary"></i></span>
                                <select name="foto_asset" id="fotoAssetSelect" class="form-select">
                                    <option value="">-- Pilih Aset Gambar Default --</option>
                                    <?php foreach($available_assets as $asset): ?>
                                        <option value="<?= esc($asset) ?>"><?= esc($asset) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-outline-primary" id="btnPreviewAsset" title="Pratinjau Gambar">
                                    <i class="bi bi-eye"></i> Lihat
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">Gunakan opsi ini jika tidak ada foto asli agar tampilan tidak gelap.</small>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info py-2 small mb-4">
                    <i class="bi bi-info-circle-fill"></i> Batas maksimal 3 foto telah tercapai. Hapus salah satu foto terlebih dahulu untuk mengunggah atau memilih foto baru.
                </div>
            <?php endif; ?>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Simpan Semua Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Preview Asset -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="previewModalTitle">Pratinjau Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <img id="previewImage" src="" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('btnPreviewAsset').addEventListener('click', function() {
        var select = document.getElementById('fotoAssetSelect');
        var selectedFile = select.value;
        if (selectedFile) {
            var imgSrc = '<?= base_url('NiceAdmin/assets/img/') ?>' + selectedFile;
            document.getElementById('previewImage').src = imgSrc;
            document.getElementById('previewModalTitle').innerText = 'Pratinjau: ' + selectedFile;
            var myModal = new bootstrap.Modal(document.getElementById('previewModal'));
            myModal.show();
        } else {
            alert('Pilih nama gambar dari dropdown terlebih dahulu untuk melihat pratinjau.');
        }
    });
</script>
<?= $this->endSection() ?>
