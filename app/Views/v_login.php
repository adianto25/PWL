<?= $this->extend('layout_clear') ?>
<?= $this->section('content') ?>
<?php
$username = [
    'name' => 'username',
    'id' => 'username',
    'class' => 'form-control'
];

$password = [
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control'
];
?>
<style>
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
        overflow: hidden;
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
        letter-spacing: -0.5px;
    }
    .login-logo p {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .custom-input {
        border-radius: 12px;
        padding: 12px 15px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: all 0.3s;
        font-size: 1rem;
        height: auto;
    }
    .custom-input:focus {
        background: #fff;
        border-color: #165F39;
        box-shadow: 0 0 0 4px rgba(22, 95, 57, 0.1);
    }
    
    .login-btn {
        background: linear-gradient(135deg, #518F5C 0%, #165F39 100%);
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1rem;
        box-shadow: 0 8px 20px rgba(22, 95, 57, 0.25);
        transition: all 0.3s;
    }
    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(22, 95, 57, 0.35);
        background: linear-gradient(135deg, #165F39 0%, #094217 100%);
    }

    .back-home {
        position: absolute;
        top: 30px;
        left: 30px;
        z-index: 10;
        color: white;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s;
    }
    .back-home:hover {
        color: #D4AF37;
    }
</style>

<section class="login-section">
    <div class="login-overlay"></div>
    
    <a href="<?= base_url('/') ?>" class="back-home">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>

    <div class="login-card">
        <div class="login-logo">
            <img src="<?= base_url() ?>NiceAdmin/assets/img/logo-umkm.png" alt="PrajaMukti Logo">
            <h3 class="fs-4">PrajaMukti</h3>
            <p>Silakan masuk untuk melanjutkan</p>
        </div>

        <?php if (session()->getFlashData('failed')): ?>
            <div class="alert alert-danger" style="border-radius: 12px; border:none; background:#fce8e6; color:#d93025; font-size:0.9rem;" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> <?= session()->getFlashData('failed') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashData('success')): ?>
            <div class="alert alert-success" style="border-radius: 12px; border:none; background:#e6f4ea; color:#188038; font-size:0.9rem;" role="alert">
                <i class="bi bi-check-circle me-2"></i> <?= session()->getFlashData('success') ?>
            </div>
        <?php endif; ?>

        <?= form_open('login', 'class="needs-validation"') ?>
            <div class="mb-4">
                <label class="form-label fw-semibold" style="color: #495057; font-size: 0.9rem;">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px; color: #165F39; padding: 0 15px;"><i class="bi bi-person fs-5"></i></span>
                    <input type="text" name="username" class="form-control custom-input border-start-0" style="border-radius: 0 12px 12px 0;" placeholder="Masukkan username" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold" style="color: #495057; font-size: 0.9rem;">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px; color: #165F39; padding: 0 15px;"><i class="bi bi-lock fs-5"></i></span>
                    <input type="password" name="password" class="form-control custom-input border-start-0" style="border-radius: 0 12px 12px 0;" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 login-btn text-white mt-2">Login Sekarang</button>
        <?= form_close() ?>

        <div class="text-center mt-4">
            <p class="small mb-0" style="color: #6c757d;">Belum punya akun? <a href="<?= base_url('register') ?>" style="color: #165F39; font-weight: 700; text-decoration: none;">Daftar di sini</a></p>
        </div>
    </div>
</section>

<?= $this->endSection() ?>