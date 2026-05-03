<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
    <h5 class="mb-0 fw-bold">Manajemen Kategori</h5>
    <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Kategori</button>
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
                <th>Nama Kategori</th>
                <th width="25%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($kategori)): ?>
                <tr><td colspan="3" class="text-center text-muted py-4">Data kategori belum ada.</td></tr>
            <?php endif; ?>
            <?php foreach($kategori as $k): ?>
            <tr>
                <td><?= esc($k['id']) ?></td>
                <td class="fw-bold"><?= esc($k['nama_kategori']) ?></td>
                <td>
                    <button class="btn btn-sm btn-warning rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editModal<?= $k['id'] ?>">Edit</button>
                    <a href="<?= base_url('admin/kategori/delete/'.$k['id']) ?>" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php foreach($kategori as $k): ?>
<!-- Edit Modal -->
<div class="modal fade" id="editModal<?= $k['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?= base_url('admin/kategori/edit/'.$k['id']) ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" value="<?= esc($k['nama_kategori']) ?>" required>
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
        <form action="<?= base_url('admin/kategori/add') ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah Kategori</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
