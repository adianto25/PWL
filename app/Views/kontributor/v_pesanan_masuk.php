<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card main-card">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4"><i class="bi bi-shop text-primary"></i> Pesanan Masuk (Omzet Saya)</h5>
        
        <?php if(empty($transaksi)): ?>
            <div class="text-center py-5 bg-light rounded-4">
                <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">Belum ada pesanan yang masuk ke warung Anda.</h5>
                <p class="text-muted">Ayo promosikan terus UMKM Anda!</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped datatable align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Tanggal Masuk</th>
                            <th>Pembeli</th>
                            <th>Warung Saya</th>
                            <th>Total Omzet</th>
                            <th>Status Bayar</th>
                            <th>Rincian Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach($transaksi as $t): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><span class="fw-bold"><?= $t['order_id'] ?></span></td>
                            <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                            <td><i class="bi bi-person-circle text-muted"></i> <?= esc($t['nama_pembeli']) ?></td>
                            <td><?= esc($t['nama_warung']) ?></td>
                            <td class="fw-bold text-success">Rp <?= number_format($t['gross_amount'], 0, ',', '.') ?></td>
                            <td>
                                <?php
                                $badgeClass = 'bg-warning text-dark';
                                $statusText = 'Pending';
                                if ($t['transaction_status'] == 'success') {
                                    $badgeClass = 'bg-success';
                                    $statusText = 'Lunas';
                                } else if ($t['transaction_status'] == 'failed') {
                                    $badgeClass = 'bg-danger';
                                    $statusText = 'Gagal';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $t['id'] ?>">
                                    <i class="bi bi-card-list"></i> Lihat Daftar Makanan
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Detail Pesanan -->
                        <div class="modal fade" id="modalDetail<?= $t['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow">
                                    <div class="modal-header bg-light border-bottom-0">
                                        <h5 class="modal-title fw-bold">Detail Pesanan: <?= $t['order_id'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <h6 class="text-muted mb-3">Pesanan dari: <strong><?= esc($t['nama_pembeli']) ?></strong></h6>
                                        <ul class="list-group list-group-flush mb-4 border rounded-3 p-2 bg-light">
                                            <?php foreach($t['details'] as $detail): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-2">
                                                <div>
                                                    <h6 class="mb-0 fw-bold"><i class="bi bi-chevron-right text-primary small"></i> <?= esc($detail['nama_makanan']) ?></h6>
                                                    <small class="text-muted ms-3">Harga Satuan: Rp <?= number_format($detail['harga'], 0, ',', '.') ?></small>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge bg-secondary rounded-pill fs-6"><?= $detail['jumlah'] ?>x</span><br>
                                                    <span class="fw-bold text-dark mt-1 d-block">Rp <?= number_format($detail['harga'] * $detail['jumlah'], 0, ',', '.') ?></span>
                                                </div>
                                            </li>
                                            <hr class="my-1 text-muted">
                                            <?php endforeach; ?>
                                        </ul>
                                        <div class="d-flex justify-content-between align-items-center bg-success text-white p-3 rounded-3 shadow-sm">
                                            <span class="fw-bold">Total Pembayaran</span>
                                            <h4 class="fw-bold mb-0">Rp <?= number_format($t['gross_amount'], 0, ',', '.') ?></h4>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0">
                                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
