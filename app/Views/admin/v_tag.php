<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
    <h5 class="mb-0 fw-bold">Manajemen Tag</h5>
    <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Tag</button>
</div>

<?php if (session()->getFlashData('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="10%">ID</th>
                <th>Nama Tag</th>
                <th width="25%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($tags)): ?>
                <tr><td colspan="3" class="text-center text-muted py-4">Data tag belum ada.</td></tr>
            <?php endif; ?>
            <?php foreach($tags as $t): ?>
            <tr>
                <td><?= esc($t['id']) ?></td>
                <td class="fw-bold"><span class="badge bg-secondary">#<?= esc($t['nama_tag']) ?></span></td>
                <td>
                    <button class="btn btn-sm btn-warning rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editModal<?= $t['id'] ?>">Edit</button>
                    <a href="<?= base_url('admin/tag/delete/'.$t['id']) ?>" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Yakin hapus tag ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php foreach($tags as $t): ?>
<!-- Edit Modal -->
<div class="modal fade" id="editModal<?= $t['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?= base_url('admin/tag/edit/'.$t['id']) ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Tag</label>
                    <input type="text" name="nama_tag" class="form-control" value="<?= esc($t['nama_tag']) ?>" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?= base_url('admin/tag/add') ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Tag</label>
                    <input type="text" name="nama_tag" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah Tag</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
