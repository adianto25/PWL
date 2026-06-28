<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart3 text-primary"></i> Keranjang Belanja</h3>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(empty($keranjang)): ?>
        <div class="text-center py-5 bg-light rounded-4">
            <i class="bi bi-cart-x fs-1 text-muted d-block mb-3"></i>
            <h5 class="text-muted">Keranjang Anda masih kosong</h5>
            <a href="<?= base_url('kuliner') ?>" class="btn btn-primary mt-3 rounded-pill px-4">Cari Makanan</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <?php 
                $totalBelanja = 0;
                foreach($keranjang as $item): 
                    $subtotal = $item['harga'] * $item['jumlah'];
                    $totalBelanja += $subtotal;
                ?>
                <div class="card border-0 bg-light rounded-4 mb-3 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary mb-2"><?= esc($item['nama_warung']) ?></span>
                            <h5 class="fw-bold mb-1"><?= esc($item['nama_makanan']) ?></h5>
                            <p class="text-muted mb-0">Rp <?= number_format($item['harga'], 0, ',', '.') ?> x <?= $item['jumlah'] ?> porsi</p>
                        </div>
                        <div class="text-end">
                            <h5 class="fw-bold text-success mb-2">Rp <?= number_format($subtotal, 0, ',', '.') ?></h5>
                            <a href="<?= base_url('kontributor/keranjang/delete/'.$item['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus dari keranjang?')"><i class="bi bi-trash"></i> Hapus</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Harga</span>
                        <span class="fw-bold fs-5 text-dark">Rp <?= number_format($totalBelanja, 0, ',', '.') ?></span>
                    </div>
                    <hr>
                    <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold" onclick="alert('Fitur Checkout akan segera hadir!')"><i class="bi bi-bag-check"></i> Lanjut Checkout</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
