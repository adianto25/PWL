<?php
$hlm = "Home";
if(uri_string()!=""){
  $hlm = ucwords(uri_string());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UMKM - <?php echo $hlm ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url()?>NiceAdmin/assets/img/favicon.png" rel="icon">
  <link href="<?= base_url()?>NiceAdmin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url()?>NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url()?>NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url()?>NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url()?>NiceAdmin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?= base_url()?>NiceAdmin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?= base_url()?>NiceAdmin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url()?>NiceAdmin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url()?>NiceAdmin/assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <?= $this->renderSection('styles') ?>
  <style>
    /* --- GLOBAL PREMIUM PALETTE OVERRIDES --- */
    :root {
      --zia-olive: #042509; 
      --pine-green: #094217;
      --fun-green: #165F39; 
      --middle-green: #518F5C;
      --jaded-lime: #BCD5AC;
      --gold-accent: #D4AF37; /* Premium Gold */
    }
    
    body { 
        color: var(--zia-olive); 
        background-color: #FAFAFA;
        font-family: 'Poppins', sans-serif;
    }
    
    h1, h2, h3, h4, h5, h6, .text-dark {
      color: var(--zia-olive) !important;
      font-family: 'Poppins', sans-serif;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--middle-green) 0%, var(--fun-green) 100%) !important;
      border: none !important;
      color: white !important;
      box-shadow: 0 4px 15px rgba(17, 89, 52, 0.2);
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(17, 89, 52, 0.3);
      background: linear-gradient(135deg, var(--fun-green) 0%, var(--pine-green) 100%) !important;
    }

    .btn-outline-primary {
      color: var(--fun-green) !important;
      border: 2px solid var(--fun-green) !important;
      transition: all 0.3s ease;
      background: transparent !important;
    }
    .btn-outline-primary:hover {
      background-color: var(--fun-green) !important;
      color: white !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(17, 89, 52, 0.15);
    }

    .text-primary { color: var(--fun-green) !important; }
    .bg-primary { background-color: var(--fun-green) !important; }
    
    .alert-primary {
      background-color: var(--jaded-lime) !important;
      color: var(--pine-green) !important;
      border: none !important;
      border-radius: 12px;
    }
    
    a { color: var(--fun-green); transition: color 0.3s; }
    a:hover { color: var(--middle-green); }
    
    /* Navbar Enhancements */
    .header-nav .nav-link {
        position: relative;
        color: var(--zia-olive) !important;
        transition: color 0.3s ease;
    }
    .header-nav .nav-link:hover {
        color: var(--fun-green) !important;
    }
    .header-nav .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 50%;
        background-color: var(--fun-green);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    .header-nav .nav-link:hover::after {
        width: 80%;
    }
  </style>
</head>

<body> 
  <!-- ======= Header / Navbar ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 15px 0;">
    <div class="container-fluid px-4 px-lg-5 d-flex align-items-center justify-content-between">
      <a href="<?= base_url('/') ?>" class="logo d-flex align-items-center text-decoration-none">
        <img src="<?= base_url() ?>NiceAdmin/assets/img/logo-umkm.png" alt="Logo" style="max-height: 35px; margin-right: 10px;">
        <span class="d-none d-lg-block fw-bold fs-4" style="color: var(--zia-olive); letter-spacing: -1px;">PrajaMukti</span>
      </a>
      
      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center mb-0 list-unstyled gap-4">
          <li><a href="<?= base_url('/') ?>" class="nav-link text-dark fw-semibold px-2">Beranda</a></li>
          <li><a href="<?= base_url('/#kulinerSection') ?>" class="nav-link text-dark fw-semibold px-2">UMKM</a></li>
          <li><a href="<?= base_url('/#mapsSection') ?>" class="nav-link text-dark fw-semibold px-2">Maps</a></li>
          
          <?php if(session()->get('isLoggedIn')): ?>
            <?php $dashboardUrl = (session()->get('role') == 'admin') ? base_url('admin') : base_url('kontributor/dashboard'); ?>
            <li class="ms-3"><a href="<?= $dashboardUrl ?>" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">Dashboard</a></li>
          <?php else: ?>
            <li class="ms-3"><a href="<?= base_url('login') ?>" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">Login</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

	<main style="margin-top: 80px;">
	
	  <?= $this->renderSection('content') ?> 
	  
	</main><!-- End #main -->

    <!-- Footer -->
    <footer style="background-color: #1a1a1a; color: #e0e0e0; padding: 60px 0 30px; font-size: 14px;">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row g-4">
                <div class="col-lg-4 mb-4">
                    <a href="<?= base_url('/') ?>" class="d-flex align-items-center text-decoration-none mb-3">
                        <img src="<?= base_url() ?>NiceAdmin/assets/img/logo-umkm.png" alt="Logo" style="max-height: 40px; margin-right: 10px;">
                        <span class="fw-bold fs-3 text-white" style="letter-spacing: -1px;">PrajaMukti</span>
                    </a>
                    <p style="color: #a0a0a0; line-height: 1.6; padding-right: 20px;">
                        Membangun ekosistem UMKM dan produk lokal yang terintegrasi. Memudahkan Anda menjangkau PrajaMukti di sekitar Anda dengan informasi terpercaya dan akurat.
                    </p>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="text-white fw-bold mb-4">Alamat</h5>
                    <p style="color: #a0a0a0; line-height: 1.6;">
                        Jl. Indonesia Raya No.45, Jakarta Pusat, DKI Jakarta, Indonesia<br><br>
                        info@umkmlokal.com<br><br>
                        <span style="color: #f8c146; font-weight: 600;">+62 8128 008 0275</span>
                    </p>
                </div>
                <div class="col-lg-2 mb-4">
                    <h5 class="text-white fw-bold mb-4">Menu</h5>
                    <ul class="list-unstyled" style="line-height: 2.2;">
                        <li><a href="<?= base_url('/') ?>" class="text-decoration-none" style="color: #a0a0a0; transition: color 0.3s;">Beranda</a></li>
                        <li><a href="<?= base_url('/#kulinerSection') ?>" class="text-decoration-none" style="color: #a0a0a0; transition: color 0.3s;">UMKM</a></li>
                        <li><a href="<?= base_url('/#mapsSection') ?>" class="text-decoration-none" style="color: #a0a0a0; transition: color 0.3s;">Maps</a></li>
                        <li><a href="<?= base_url('login') ?>" class="text-decoration-none" style="color: #a0a0a0; transition: color 0.3s;">Login</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="text-white fw-bold mb-4">Hubungi Kami</h5>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; border: 1px solid #555; color: #fff; transition: all 0.3s;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; border: 1px solid #555; color: #fff; transition: all 0.3s;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; border: 1px solid #555; color: #fff; transition: all 0.3s;">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; border: 1px solid #555; color: #fff; transition: all 0.3s;">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-top mt-4 pt-4 text-center" style="border-color: #333 !important; color: #777;">
                &copy; <?= date('Y') ?> PrajaMukti. All Rights Reserved.
            </div>
        </div>
    </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url()?>NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?= base_url()?>NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url()?>NiceAdmin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?= base_url()?>NiceAdmin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?= base_url()?>NiceAdmin/assets/vendor/quill/quill.min.js"></script>
  <script src="<?= base_url()?>NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?= base_url()?>NiceAdmin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?= base_url()?>NiceAdmin/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url()?>NiceAdmin/assets/js/main.js"></script>

  <?= $this->renderSection('scripts') ?>
</body>

</html>