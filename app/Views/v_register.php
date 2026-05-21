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

                  <style>
                  .kekinian-container {
                      display: flex;
                      flex-direction: column;
                      gap: 7px;
                      position: relative;
                      color: #333;
                      margin-bottom: 20px;
                  }
                  
                  .kekinian-label {
                      font-size: 15px;
                      padding-left: 10px;
                      position: absolute;
                      top: 13px;
                      transition: 0.3s;
                      pointer-events: none;
                      color: #6c757d;
                  }
                  
                  .kekinian-input {
                      width: 100%;
                      height: 45px;
                      border: none;
                      outline: none;
                      padding: 0px 15px;
                      border-radius: 6px;
                      color: #333;
                      font-size: 15px;
                      background-color: transparent;
                      box-shadow: 3px 3px 10px rgba(0,0,0,0.1),
                      -1px -1px 6px rgba(255, 255, 255, 1);
                  }
                  
                  .kekinian-input:focus {
                      border: 2px solid transparent;
                      color: #333;
                      box-shadow: 3px 3px 10px rgba(0,0,0,0.1),
                      -1px -1px 6px rgba(255, 255, 255, 1),
                      inset 3px 3px 10px rgba(0,0,0,0.05),
                      inset -1px -1px 6px rgba(255, 255, 255, 0.5);
                  }
                  
                  .kekinian-input:valid ~ .kekinian-label,
                  .kekinian-input:focus ~ .kekinian-label {
                      transition: 0.3s;
                      padding-left: 2px;
                      transform: translateY(-32px);
                      color: #165F39;
                      font-weight: 600;
                      font-size: 13px;
                  }
                  
                  .kekinian-input:valid,
                  .kekinian-input:focus {
                      box-shadow: 3px 3px 10px rgba(0,0,0,0.1),
                      -1px -1px 6px rgba(255, 255, 255, 1),
                      inset 3px 3px 10px rgba(0,0,0,0.05),
                      inset -1px -1px 6px rgba(255, 255, 255, 0.5);
                  }
                  </style>

                  <div class="col-12 kekinian-container mt-2">
                      <input type="text" name="username" class="kekinian-input" required>
                      <label class="kekinian-label">Username</label>
                  </div>

                  <div class="col-12 kekinian-container">
                      <input type="password" name="password" class="kekinian-input" required>
                      <label class="kekinian-label">Kata Sandi</label>
                  </div>

                  <div class="col-12 kekinian-container">
                      <input type="password" name="confirm_password" class="kekinian-input" required>
                      <label class="kekinian-label">Konfirmasi Kata Sandi</label>
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
