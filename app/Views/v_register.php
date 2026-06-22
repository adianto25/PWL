<?= $this->extend('layout_clear') ?>
<?= $this->section('content') ?>
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="<?= base_url('/') ?>" class="logo d-flex align-items-center w-auto text-decoration-none">
                <img src="<?php echo base_url() ?>NiceAdmin/assets/img/logo-umkm.png" alt="Logo PrajaMukti" style="max-height: 40px; margin-right: 10px;">
                <span class="d-none d-lg-block fw-bold fs-4" style="color: #115934; letter-spacing: -1px;">PrajaMukti</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Daftar Akun Baru</h5>
                    <p class="text-center small">Masukkan data Anda untuk mendaftar</p>
                  </div>

                  <?php if (session()->getFlashData('failed')): ?>
                  <div class="col-12 alert alert-danger" role="alert">
                    <hr>
                    <p class="mb-0"><?= session()->getFlashData('failed') ?></p>
                  </div>
                  <?php endif; ?>

                  <?= form_open('register', 'class = "row g-3 needs-validation"') ?>

                  <div class="col-12">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" name="username" class="form-control" id="username" required>
                  </div>

                  <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                  </div>

                  <div class="col-12">
                      <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                      <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                  </div>

                  <div class="col-12 mt-4">
                      <?= form_submit('submit', 'Daftar Sekarang', ['class' => 'btn btn-primary w-100']) ?>
                  </div>
                  
                  <div class="col-12 text-center mt-3">
                      <p class="small mb-0">Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a></p>
                  </div>

                  <?= form_close() ?>

                </div>
              </div>

              <div class="credits">
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>

            </div>
          </div>
        </div>
</section>
<?= $this->endSection() ?>
