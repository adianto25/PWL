<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="pagetitle">
    <h1>Checkout Pembayaran</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('kontributor/dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('kontributor/keranjang') ?>">Keranjang</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Detail Transaksi</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Order ID:</span>
                        <span class="fw-bold"><?= $orderId ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Total Pembayaran:</span>
                        <span class="fw-bold text-success fs-5">Rp <?= number_format($grossAmount, 0, ',', '.') ?></span>
                    </div>

                    <div class="alert alert-info text-center" role="alert">
                        Silakan selesaikan pembayaran Anda dengan mengeklik tombol di bawah ini.
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button id="pay-button" class="btn btn-primary btn-lg" style="background-color: #115934; border-color: #115934;">
                            <i class="bi bi-wallet2 me-2"></i> Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TODO: Change to production URL for production mode -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?>"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('<?= $snapToken ?>', {
            // Optional
            onSuccess: function(result){
                // Langsung redirect ke fungsi cek status otomatis
                window.location.href = "<?= base_url('kontributor/checkout/status/' . $orderId) ?>";
            },
            // Optional
            onPending: function(result){
                alert("Menunggu pembayaran Anda!");
                window.location.href = "<?= base_url('kontributor/keranjang') ?>";
            },
            // Optional
            onError: function(result){
                alert("Pembayaran Gagal!");
                window.location.href = "<?= base_url('kontributor/keranjang') ?>";
            }
        });
    };
</script>

<?= $this->endSection() ?>
