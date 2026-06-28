<!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?= base_url('/') ?>" class="logo d-flex align-items-center">
        <img src="<?= base_url()?>NiceAdmin/assets/img/logo-umkm.png" alt="">
        <span class="d-none d-lg-block">PrajaMukti</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="GET" action="<?= base_url('/') ?>">
        <input type="text" name="keyword" placeholder="Cari UMKM..." title="Cari nama atau alamat">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <!-- Cart Nav -->
        <?php if(session()->get('isLoggedIn')): ?>
        <?php
            $db = \Config\Database::connect();
            $userId = session()->get('user_id');
            // Cart count
            $cartCount = $db->table('keranjang')->where('user_id', $userId)->selectSum('jumlah')->get()->getRow()->jumlah ?? 0;
        ?>
        <li class="nav-item">
          <a class="nav-link nav-icon" href="<?= base_url('kontributor/keranjang') ?>">
            <i class="bi bi-cart3"></i>
            <?php if($cartCount > 0): ?>
            <span class="badge bg-danger badge-number"><?= $cartCount ?></span>
            <?php endif; ?>
          </a>
        </li><!-- End Cart Nav -->
        <?php endif; ?>

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <?php if(session()->get('isLoggedIn') && session()->get('role') != 'admin'): ?>
        <?php
            // Ambil daftar chat masuk yang belum dibaca (hanya untuk pesan terakhir dari setiap pengirim)
            $db = \Config\Database::connect();
            $userId = session()->get('user_id');
            
            $builder = $db->table('chats');
            $builder->select('chats.*, users.username');
            $builder->join('users', 'users.id = chats.pengirim_id');
            $builder->where('penerima_id', $userId);
            $builder->where('is_read', 0);
            $builder->orderBy('created_at', 'DESC');
            $unreadChatsAll = $builder->get()->getResultArray();
            
            // Filter unique per sender
            $unreadChats = [];
            $seenSenders = [];
            foreach($unreadChatsAll as $c) {
                if(!in_array($c['pengirim_id'], $seenSenders)) {
                    $unreadChats[] = $c;
                    $seenSenders[] = $c['pengirim_id'];
                }
            }
            $unreadCount = count($unreadChatsAll);
        ?>
        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <?php if($unreadCount > 0): ?>
            <span class="badge bg-success badge-number"><?= $unreadCount ?></span>
            <?php endif; ?>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              Anda punya <?= $unreadCount ?> pesan baru
              <a href="<?= base_url('kontributor/chat') ?>"><span class="badge rounded-pill bg-primary p-2 ms-2">Lihat semua</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <?php if(empty($unreadChats)): ?>
                <li class="message-item p-3 text-center text-muted small">
                    Tidak ada pesan baru
                </li>
            <?php else: ?>
                <?php foreach(array_slice($unreadChats, 0, 3) as $uc): ?>
                <li class="message-item">
                  <a href="<?= base_url('kontributor/chat/'.$uc['pengirim_id']) ?>">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold; font-size: 1.2rem;">
                        <?= strtoupper(substr($uc['username'], 0, 1)) ?>
                    </div>
                    <div>
                      <h4><?= esc($uc['username']) ?></h4>
                      <p><?= esc((strlen($uc['pesan']) > 30) ? substr($uc['pesan'],0,30).'...' : $uc['pesan']) ?></p>
                      <p><?= date('H:i', strtotime($uc['created_at'])) ?></p>
                    </div>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <?php endforeach; ?>
            <?php endif; ?>

            <li class="dropdown-footer">
              <a href="<?= base_url('kontributor/chat') ?>">Tampilkan semua obrolan</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->
        <?php endif; ?>

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?= base_url()?>NiceAdmin/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= session()->get('username'); ?> (<?= session()->get('role'); ?>)</span>
          </a><!-- End Profile Iamge Icon -->
              
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout') ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
