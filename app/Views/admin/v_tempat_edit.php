<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
    <h5 class="mb-0 fw-bold">Edit Tempat Kuliner</h5>
    <a href="<?= base_url('admin') ?>" class="btn btn-secondary btn-sm rounded-pill px-3">Kembali</a>
</div>

<form action="<?= base_url('admin/tempat/update/'.$tempat['id']) ?>" method="POST" class="p-3">
    <div class="mb-3">
        <label class="form-label fw-bold">Nama Tempat</label>
        <input type="text" name="nama" class="form-control" value="<?= esc($tempat['nama']) ?>" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label fw-bold">Kategori</label>
        <select name="kategori_id" class="form-select" required>
            <?php foreach($kategori as $k): ?>
                <option value="<?= $k['id'] ?>" <?= $k['id'] == $tempat['kategori_id'] ? 'selected' : '' ?>><?= esc($k['nama_kategori']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Fasilitas (Tags)</label>
        <div class="row g-2">
            <?php foreach($tags as $t): ?>
            <div class="col-6 col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tags[]" value="<?= $t['id'] ?>" id="tag<?= $t['id'] ?>" <?= in_array($t['id'], $selected_tags) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="tag<?= $t['id'] ?>">
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

    <div class="mb-3">
        <label class="form-label fw-bold">Alamat</label>
        <textarea name="alamat" class="form-control" rows="2" required><?= esc($tempat['alamat']) ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Status Moderasi</label>
        <select name="status" class="form-select" required>
            <option value="pending" <?= $tempat['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="approved" <?= $tempat['status'] == 'approved' ? 'selected' : '' ?>>Disetujui</option>
            <option value="rejected" <?= $tempat['status'] == 'rejected' ? 'selected' : '' ?>>Ditolak</option>
        </select>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
    </div>
</form>
<?= $this->endSection() ?>
