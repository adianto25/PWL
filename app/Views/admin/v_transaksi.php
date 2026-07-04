<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card main-card">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4">Data Transaksi Keseluruhan</h5>
        
        <div class="table-responsive">
            <table class="table table-hover table-striped datatable align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Warung</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach($transaksi as $t): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><span class="fw-bold"><?= $t['order_id'] ?></span></td>
                        <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                        <td><?= esc($t['username']) ?></td>
                        <td><?= esc($t['nama_warung'] ?? 'UMKM Lokal') ?></td>
                        <td class="fw-bold text-success">Rp <?= number_format($t['gross_amount'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $badgeClass = 'bg-warning text-dark';
                            $statusText = 'Pending';
                            if ($t['transaction_status'] == 'success') {
                                $badgeClass = 'bg-success';
                                $statusText = 'Berhasil';
                            } else if ($t['transaction_status'] == 'failed') {
                                $badgeClass = 'bg-danger';
                                $statusText = 'Gagal';
                            }
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info text-white rounded-pill" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $t['id'] ?>">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail Transaksi -->
                    <div class="modal fade" id="modalDetail<?= $t['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Detail Pesanan: <?= $t['order_id'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group list-group-flush mb-3">
                                        <?php foreach($t['details'] as $detail): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <div>
                                                <h6 class="mb-0 fw-bold"><?= esc($detail['nama_makanan']) ?></h6>
                                                <small class="text-muted"><?= $detail['jumlah'] ?> x Rp <?= number_format($detail['harga'], 0, ',', '.') ?></small>
                                            </div>
                                            <span class="fw-bold">Rp <?= number_format($detail['harga'] * $detail['jumlah'], 0, ',', '.') ?></span>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div class="d-flex justify-content-between border-top pt-3">
                                        <span class="fw-bold">Total Pembayaran</span>
                                        <h5 class="fw-bold text-success mb-0">Rp <?= number_format($t['gross_amount'], 0, ',', '.') ?></h5>
                                    </div>
                                    <div class="mt-3">
                                        <span class="text-muted small">Metode: <?= strtoupper($t['payment_type'] ?? 'Belum dipilih') ?></span>
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0">
                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
