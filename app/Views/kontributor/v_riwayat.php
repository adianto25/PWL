<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-receipt text-primary"></i> Riwayat Transaksi</h3>

    <?php if(empty($riwayat)): ?>
        <div class="text-center py-5 bg-light rounded-4">
            <i class="bi bi-bag-x fs-1 text-muted d-block mb-3"></i>
            <h5 class="text-muted">Anda belum memiliki riwayat transaksi</h5>
            <a href="<?= base_url('kuliner') ?>" class="btn btn-primary mt-3 rounded-pill px-4">Belanja Sekarang</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <?php foreach($riwayat as $t): ?>
                    <div class="card mb-4 rounded-4 shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="bi bi-shop"></i> <?= esc($t['nama_warung'] ?? 'UMKM Lokal') ?> &nbsp;|&nbsp; <?= date('d M Y, H:i', strtotime($t['created_at'])) ?></span>
                                
                                <?php
                                $badgeClass = 'bg-warning text-dark';
                                $statusText = 'Belum Dibayar';
                                if ($t['transaction_status'] == 'success') {
                                    $badgeClass = 'bg-success';
                                    $statusText = 'Berhasil';
                                } else if ($t['transaction_status'] == 'failed') {
                                    $badgeClass = 'bg-danger';
                                    $statusText = 'Gagal/Dibatalkan';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?> px-3 py-2 rounded-pill"><?= $statusText ?></span>
                            </div>
                            <hr class="mb-0 mt-3 text-muted">
                        </div>
                        
                        <div class="card-body py-3">
                            <?php foreach($t['details'] as $detail): ?>
                            <div class="d-flex align-items-center mb-3">
                                <?php 
                                $fotoMenu = null;
                                if(isset($detail['foto']) && $detail['foto'] && $detail['foto'] != '') {
                                    $fotoMenu = base_url('uploads/'.$detail['foto']);
                                } else if(isset($t['foto_warung']) && $t['foto_warung']) {
                                    // Fallback ke foto profil warung jika makanan tidak ada fotonya
                                    $fotoMenu = base_url('uploads/'.$t['foto_warung']);
                                }
                                ?>
                                
                                <?php if($fotoMenu): ?>
                                    <img src="<?= $fotoMenu ?>" class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold"><?= esc($detail['nama_makanan']) ?></h6>
                                    <span class="text-muted small"><?= $detail['jumlah'] ?> barang x Rp <?= number_format($detail['harga'], 0, ',', '.') ?></span>
                                </div>
                                <div class="text-end">
                                    <span class="text-muted small">Total Harga</span><br>
                                    <span class="fw-bold">Rp <?= number_format($detail['harga'] * $detail['jumlah'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="card-footer bg-white border-top-0 pb-3 pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">Order ID: <?= $t['order_id'] ?></div>
                                <div class="d-flex align-items-center">
                                    <span class="text-muted me-3">Total Belanja: <strong class="fs-5 ms-1 text-primary">Rp <?= number_format($t['gross_amount'], 0, ',', '.') ?></strong></span>
                                    
                                    <?php if($t['transaction_status'] == 'pending'): ?>
                                        <a href="<?= base_url('kontributor/checkout') ?>" class="btn btn-warning rounded-pill px-4 fw-bold">Bayar Sekarang</a>
                                        <a href="<?= base_url('kontributor/checkout/status/'.$t['order_id']) ?>" class="btn btn-outline-secondary rounded-pill px-3 ms-2" title="Cek Status Manual"><i class="bi bi-arrow-clockwise"></i></a>
                                    <?php else: ?>
                                        <button class="btn btn-outline-primary rounded-pill px-4">Beli Lagi</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
