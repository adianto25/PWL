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

    .kekinian-container {
        display: flex;
        flex-direction: column;
        gap: 7px;
        position: relative;
        color: #333;
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
            <div class="kekinian-container mb-4">
                <input required="" type="text" name="username" class="kekinian-input">
                <label class="kekinian-label">Username</label>
            </div>

            <div class="kekinian-container mb-4">
                <input required="" type="password" name="password" class="kekinian-input">
                <label class="kekinian-label">Password</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 login-btn text-white mt-2">Login Sekarang</button>
        <?= form_close() ?>

        <div class="text-center mt-4">
            <p class="small mb-0" style="color: #6c757d;">Belum punya akun? <a href="<?= base_url('register') ?>" style="color: #165F39; font-weight: 700; text-decoration: none;">Daftar di sini</a></p>
        </div>
    </div>
</section>

<?= $this->endSection() ?>