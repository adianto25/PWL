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

    /* Custom Social Buttons */
    .custom-social-btn {
      cursor: pointer;
      width: 50px;
      height: 50px;
      border-radius: 50px;
      border: none;
      background: linear-gradient(120deg, #833ab4, #fd1d1d, #fcb045);
      position: relative;
      z-index: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-left: 10px;
      transition: 0.1s;
      padding: 0;
    }
    .custom-social-btn svg {
      color: white;
      width: 30px;
      height: 30px;
      z-index: 9;
    }

    .custom-social-btn:nth-child(2) {
      background: linear-gradient(120deg, #02ff2c, #008a12);
    }

    .custom-social-btn:nth-child(3) {
      background: rgb(69, 187, 255);
    }

    .custom-social-btn:nth-child(4) {
      background: rgb(255, 33, 33);
    }

    .custom-social-btn:nth-child(5) {
      background: black;
    }

    .custom-social-btn:active {
      transform: scale(0.85);
    }

    .custom-social-btn::before {
      content: "";
      position: absolute;
      width: 55px;
      height: 55px;
      background-color: #212121;
      border-radius: 50px;
      z-index: -1;
      border: 0px solid rgba(255, 255, 255, 0.411);
      transition: 0.4s;
    }

    .custom-social-btn:hover::before {
      width: 0px;
      height: 0px;
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
                        <button class="custom-social-btn">
                          <svg viewBox="0 0 24 24" fill="none" height="24" width="24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-6 h-6 text-gray-800 dark:text-white">
                            <path clip-rule="evenodd" d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z" fill-rule="evenodd" fill="currentColor"></path>
                          </svg>
                        </button>
                        <button class="custom-social-btn">
                          <svg viewBox="0 0 24 24" fill="none" height="24" width="24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-6 h-6 text-gray-800 dark:text-white">
                            <path clip-rule="evenodd" d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z" fill-rule="evenodd" fill="currentColor"></path>
                            <path d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1.008 1.008 0 0 0-.34-.075c-.196 0-.362.098-.49.291-.146.217-.587.732-.723.886-.018.02-.042.045-.057.045-.013 0-.239-.093-.307-.123-1.564-.68-2.751-2.313-2.914-2.589-.023-.04-.024-.057-.024-.057.005-.021.058-.074.085-.101.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711-.158-.377-.366-.552-.655-.552-.027 0 0 0-.112.005-.137.005-.883.104-1.213.311-.35.22-.94.924-.94 2.16 0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537 1.412.564 2.081.63 2.461.63.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276.192-.534.243-1.117.115-1.329-.088-.144-.239-.216-.43-.308Z" fill="currentColor"></path>
                          </svg>
                        </button>
                        <button class="custom-social-btn">
                          <svg viewBox="0 0 24 24" fill="currentColor" height="24" width="24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-6 h-6 text-gray-800 dark:text-white">
                            <path clip-rule="evenodd" d="M22 5.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.343 8.343 0 0 1-2.605.981A4.13 4.13 0 0 0 15.85 4a4.068 4.068 0 0 0-4.1 4.038c0 .31.035.618.105.919A11.705 11.705 0 0 1 3.4 4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 6.1 13.635a4.192 4.192 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 2 18.184 11.732 11.732 0 0 0 8.291 20 11.502 11.502 0 0 0 19.964 8.5c0-.177 0-.349-.012-.523A8.143 8.143 0 0 0 22 5.892Z" fill-rule="evenodd"></path>
                          </svg>
                        </button>
                        <button class="custom-social-btn">
                          <svg viewBox="0 0 24 24" fill="currentColor" height="24" width="24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-6 h-6 text-gray-800 dark:text-white">
                            <path clip-rule="evenodd" d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z" fill-rule="evenodd"></path>
                          </svg>
                        </button>
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