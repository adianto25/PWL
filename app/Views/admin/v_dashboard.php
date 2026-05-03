<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<p class="text-muted">Selamat datang di panel administrasi KulinerKampus.</p>

<div class="row mb-4">
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="p-3 bg-primary text-white rounded shadow-sm h-100">
            <h6 class="text-uppercase fw-bold opacity-75">Total Tempat</h6>
            <h2 class="fw-bold mb-0 display-6"><?= esc($total_tempat) ?></h2>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="p-3 bg-warning text-dark rounded shadow-sm h-100">
            <h6 class="text-uppercase fw-bold opacity-75">Menunggu Moderasi</h6>
            <h2 class="fw-bold mb-0 display-6"><?= esc($total_pending) ?></h2>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="p-3 bg-success text-white rounded shadow-sm h-100">
            <h6 class="text-uppercase fw-bold opacity-75">Total Pengguna</h6>
            <h2 class="fw-bold mb-0 display-6"><?= esc($total_users) ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="p-3 bg-info text-white rounded shadow-sm h-100">
            <h6 class="text-uppercase fw-bold opacity-75">Total Ulasan</h6>
            <h2 class="fw-bold mb-0 display-6"><?= esc($total_reviews) ?></h2>
        </div>
    </div>
</div>

<?php if (session()->getFlashData('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<h5 class="fw-bold mt-4 mb-3 border-bottom pb-2">Manajemen Tempat Kuliner</h5>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Nama Tempat</th>
                <th>Kategori</th>
                <th>Kontributor</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($semua_tempat)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data tempat kuliner.</td></tr>
            <?php else: ?>
                <?php foreach($semua_tempat as $t): ?>
                <tr>
                    <td class="fw-bold"><?= esc($t['nama']) ?></td>
                    <td><span class="badge bg-secondary"><?= esc($t['nama_kategori']) ?></span></td>
                    <td><span class="text-primary fw-bold">@<?= esc($t['username']) ?></span></td>
                    <td><span class="text-truncate d-inline-block" style="max-width: 200px;"><?= esc($t['alamat']) ?></span></td>
                    <td>
                        <?php if($t['status'] == 'approved'): ?>
                            <span class="badge bg-success px-2 py-1">Disetujui</span>
                        <?php elseif($t['status'] == 'rejected'): ?>
                            <span class="badge bg-danger px-2 py-1">Ditolak</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($t['status'] == 'pending'): ?>
                            <div class="d-flex gap-2">
                                <form action="<?= base_url('admin/approve/'.$t['id']) ?>" method="POST">
                                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">Setujui</button>
                                </form>
                                <form action="<?= base_url('admin/reject/'.$t['id']) ?>" method="POST">
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm">Tolak</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('kuliner/detail/'.$t['id']) ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">Lihat</a>
                                <a href="<?= base_url('admin/tempat/edit/'.$t['id']) ?>" class="btn btn-warning btn-sm rounded-pill px-3">Edit</a>
                                <a href="<?= base_url('admin/tempat/delete/'.$t['id']) ?>" onclick="return confirm('Hapus tempat ini?')" class="btn btn-danger btn-sm rounded-pill px-3">Hapus</a>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
