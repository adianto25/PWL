<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrajaMukti API Documentation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; color: #333; }
        .hero-doc { background: linear-gradient(135deg, #0f4625 0%, #165f39 100%); color: white; padding: 60px 0; text-align: center; }
        .card-endpoint { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; border-left: 5px solid #165f39; }
        .badge-method { width: 80px; font-size: 14px; padding: 8px; border-radius: 6px; }
        .method-get { background-color: #e3f2fd; color: #0d47a1; }
        .method-post { background-color: #e8f5e9; color: #1b5e20; border-left-color: #28a745 !important; }
        .method-put { background-color: #fff3e0; color: #e65100; border-left-color: #fd7e14 !important; }
        .method-delete { background-color: #ffebee; color: #b71c1c; border-left-color: #dc3545 !important; }
        pre { background-color: #212529; color: #e83e8c; padding: 15px; border-radius: 8px; }
    </style>
</head>
<body>

    <div class="hero-doc">
        <h1 class="fw-bold">📚 PrajaMukti API Documentation</h1>
        <p class="lead mb-0">Panduan integrasi Webservice (RESTful API) untuk Aplikasi PrajaMukti</p>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                
                <div class="card border-0 shadow-sm rounded-4 mb-5 p-4">
                    <h4 class="fw-bold text-success mb-3"><i class="bi bi-shield-lock-fill"></i> Autentikasi (API Key)</h4>
                    <p>Seluruh endpoint API (kecuali halaman dokumentasi ini) dilindungi menggunakan Token API. Anda diwajibkan mengirimkan token ini pada bagian <strong>Header HTTP</strong> dari request Anda.</p>
                    <div class="bg-light p-3 rounded border">
                        <code>Authorization: Bearer prajamukti-api-key-2026</code>
                    </div>
                </div>

                <h3 class="fw-bold mb-4">Daftar Endpoint API</h3>

                <!-- GET ALL -->
                <div class="card card-endpoint p-4 method-get">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge badge-method method-get me-3">GET</span>
                        <h5 class="fw-bold mb-0"><code>/api/kuliner</code></h5>
                    </div>
                    <p class="text-muted">Mengambil seluruh daftar data kuliner UMKM. Anda bisa mengirimkan query <code>lat</code>, <code>lng</code>, dan <code>radius</code> untuk pencarian berdasarkan jarak.</p>
                </div>

                <!-- GET DETAIL -->
                <div class="card card-endpoint p-4 method-get">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge badge-method method-get me-3">GET</span>
                        <h5 class="fw-bold mb-0"><code>/api/kuliner/{id}</code></h5>
                    </div>
                    <p class="text-muted">Mengambil detail data kuliner spesifik berdasarkan ID tempat kuliner.</p>
                </div>

                <!-- POST CREATE -->
                <div class="card card-endpoint p-4 method-post" style="border-left-color: #28a745;">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge badge-method method-post me-3">POST</span>
                        <h5 class="fw-bold mb-0"><code>/api/kuliner</code></h5>
                    </div>
                    <p class="text-muted">Menambahkan data kuliner baru. Wajib mengirimkan data formulir (nama, alamat, deskripsi, kategori_id, lat, lng).</p>
                </div>

                <!-- PUT UPDATE -->
                <div class="card card-endpoint p-4 method-put" style="border-left-color: #fd7e14;">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge badge-method method-put me-3">PUT</span>
                        <h5 class="fw-bold mb-0"><code>/api/kuliner/{id}</code></h5>
                    </div>
                    <p class="text-muted">Memperbarui data kuliner yang sudah ada berdasarkan ID.</p>
                </div>

                <!-- DELETE -->
                <div class="card card-endpoint p-4 method-delete" style="border-left-color: #dc3545;">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge badge-method method-delete me-3">DELETE</span>
                        <h5 class="fw-bold mb-0"><code>/api/kuliner/{id}</code></h5>
                    </div>
                    <p class="text-muted">Menghapus data kuliner berdasarkan ID.</p>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
