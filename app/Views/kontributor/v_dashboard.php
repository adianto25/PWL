<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<p class="text-muted">Selamat datang, <?= esc(session()->get('username')) ?>!</p>

<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="p-3 bg-primary text-white rounded shadow-sm h-100 d-flex flex-column justify-content-center">
            <h5 class="mb-2">Tempat Disubmit</h5>
            <h2 class="fw-bold mb-0 display-6"><?= count($tempat_saya) ?></h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 bg-success text-white rounded shadow-sm h-100 d-flex flex-column justify-content-center">
            <h5 class="mb-2">Total Review</h5>
            <h2 class="fw-bold mb-0 display-6"><?= esc($total_review) ?></h2>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 mt-4 border-bottom pb-2">
    <h5 class="mb-0 fw-bold">Tempat Kuliner Saya</h5>
    <a href="<?= base_url('kontributor/submit') ?>" class="btn btn-primary rounded-pill btn-sm px-4 shadow-sm">+ Tambah Baru</a>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Nama Tempat</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Tanggal Submit</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($tempat_saya)): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada tempat yang Anda submit.</td></tr>
            <?php else: ?>
                <?php foreach($tempat_saya as $t): ?>
                <tr>
                    <td class="fw-bold"><?= esc($t['nama']) ?></td>
                    <td><span class="text-truncate d-inline-block" style="max-width: 250px;"><?= esc($t['alamat']) ?></span></td>
                    <td>
                        <?php if($t['status'] == 'approved'): ?>
                            <span class="badge bg-success px-2 py-1">Disetujui</span>
                        <?php elseif($t['status'] == 'rejected'): ?>
                            <span class="badge bg-danger px-2 py-1">Ditolak</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted small"><?= date('d M Y', strtotime($t['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
