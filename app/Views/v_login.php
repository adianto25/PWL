<?= $this->extend('layout_clear') ?>
<?= $this->section('content') ?>

<?php
// Mendefinisikan atribut input dan mendukung validasi HTML5
$username_attr = [
    'name'        => 'username',
    'id'          => 'username',
    'class'       => 'form-control custom-input border-start-0',
    'placeholder' => ' ', /* Wajib spasi kosong untuk floating label */
    'required'    => 'required',
    'minlength'   => '5',
    'value'       => old('username'),
];

$password_attr = [
    'name'        => 'password',
    'id'          => 'password',
    'class'       => 'form-control custom-input border-start-0',
    'placeholder' => ' ', /* Wajib spasi kosong untuk floating label */
    'required'    => 'required',
    'minlength'   => '7',
];
?>

<style>
    /* Desain Wallpaper dan Overlay Estetik */
    .login-section {
        background: url('<?= base_url('NiceAdmin/assets/img/wallpaper (1).jpg') ?>') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .login-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(4,37,9,0.8) 0%, rgba(9,66,23,0.9) 100%);
        z-index: 1;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 24px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.5);
        z-index: 2;
        width: 100%;
        max-width: 450px;
        padding: 40px;
        animation: fadeIn 0.8s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-logo {
        text-align: center;
        margin-bottom: 30px;
    }
    .login-logo img {
        width: 60px;
        margin-bottom: 15px;
    }
    .login-logo h3 {
        font-weight: 800;
        color: #165F39;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    /* Floating Label & Refined Neumorphism */
    .float-container {
      position: relative;
      width: 100%;
      margin-bottom: 35px;
    }

    .float-container .float-label {
      font-size: 15px;
      padding-left: 55px; /* Offset for icon */
      position: absolute;
      top: 15px;
      color: #888;
      transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      pointer-events: none;
      font-weight: 500;
      margin: 0;
    }

    .float-input-wrapper {
      display: flex;
      border-radius: 12px;
      background-color: #f8f9fa;
      box-shadow: 4px 4px 10px rgba(0,0,0,0.06),
                  -4px -4px 10px rgba(255,255,255,1);
      transition: all 0.3s;
    }
    
    .float-input-wrapper:focus-within {
      box-shadow: inset 4px 4px 8px rgba(0,0,0,0.05), 
                  inset -4px -4px 8px rgba(255,255,255,1);
    }

    .float-input-wrapper .input-group-text {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      color: #165F39;
      padding-left: 20px;
    }

    .float-input-wrapper .custom-input {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      padding: 15px 15px 15px 0; 
      color: #333;
      font-size: medium;
      font-weight: 600;
    }

    .float-input-wrapper .custom-input:focus {
      outline: none !important;
      box-shadow: none !important;
    }

    /* The floating action */
    .float-input-wrapper .custom-input:not(:placeholder-shown) ~ .float-label,
    .float-input-wrapper .custom-input:focus ~ .float-label {
      padding-left: 5px;
      transform: translateY(-38px);
      font-size: 14px;
      color: #165F39;
      font-weight: 700;
      text-shadow: 1px 1px 0px rgba(255,255,255,0.8);
    }
    
    .login-btn {
        background: linear-gradient(135deg, #518F5C 0%, #165F39 100%);
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        color: white;
        box-shadow: 0 8px 20px rgba(22, 95, 57, 0.25);
        transition: all 0.3s;
    }

    .back-home {
        position: absolute; top: 30px; left: 30px; z-index: 10;
        color: white; text-decoration: none; font-weight: 600;
        display: flex; align-items: center; gap: 8px;
    }
</style>

<section class="login-section">
    <div class="login-overlay"></div>
    
    <a href="<?= base_url('/') ?>" class="back-home">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>

    <div class="login-card">
        <div class="login-logo">
            <img src="<?= base_url('NiceAdmin/assets/img/logo-umkm.png') ?>" alt="Logo">
            <h3 class="fs-4">PrajaMukti</h3>
            <p class="text-muted small">Silakan masuk untuk melanjutkan</p>
        </div>

        <?php if (session()->getFlashData('failed')): ?>
            <div class="alert alert-danger" style="border-radius: 12px; border:none; background:#fce8e6; color:#d93025; font-size:0.9rem;" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> 
                <strong>Gagal:</strong> <?= session()->getFlashData('failed') ?>
            </div>
        <?php endif; ?>

        <?= form_open('login', 'class="needs-validation"') ?>
            <div class="float-container">
                <div class="float-input-wrapper">
                    <span class="input-group-text"><i class="bi bi-person fs-5"></i></span>
                    <?= form_input($username_attr) ?>
                    <label class="float-label">Username</label>
                </div>
                <div class="invalid-feedback" style="position: absolute; bottom: -22px; padding-left: 5px;">Username wajib diisi (Min. 5 Karakter)</div>
            </div>

            <div class="float-container">
                <div class="float-input-wrapper">
                    <span class="input-group-text"><i class="bi bi-lock fs-5"></i></span>
                    <?= form_password($password_attr) ?>
                    <label class="float-label">Password</label>
                </div>
                <div class="invalid-feedback" style="position: absolute; bottom: -22px; padding-left: 5px;">Password wajib diisi (Min. 7 Karakter)</div>
            </div>

            <button type="submit" class="btn w-100 login-btn mt-2">Login Sekarang</button>
        <?= form_close() ?>

        <div class="text-center mt-4">
            <p class="small mb-0" style="color: #6c757d;">Belum punya akun? 
                <a href="<?= base_url('register') ?>" style="color: #165F39; font-weight: 700; text-decoration: none;">Daftar di sini</a>
            </p>
        </div>
    </div>
</section>

<?= $this->endSection() ?>