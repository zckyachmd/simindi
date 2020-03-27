<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $base_url; ?>">
    <div class="sidebar-brand-icon rotate-n-15">
      <img src="<?= $base_url; ?>/assets/img/clapper-board-icon.png" width="30px" height="30px">
    </div>
    <div class="sidebar-brand-text mx-3"><?= title;?></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?php if (($_SERVER["PHP_SELF"] == "/index.php")) : ?> active <?php endif; ?>">
    <a class="nav-link" href="<?= $base_url; ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <li class="nav-item <?php if (($_SERVER["PHP_SELF"] == "/profile.php")) : ?> active <?php endif; ?>">
    <a class="nav-link" href="<?= $base_url; ?>/profile.php?id=<?= base64_encode($_SESSION["no_account"]); ?>">
      <i class="fas fa-fw fa-user"></i>
      <span>Profile</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePeminjaman" aria-expanded="true"
      aria-controls="collapsePeminjaman">
      <i class="fas fa-fw fa-folder-open"></i>
      <span>Peminjaman</span>
    </a>
    <div id="collapsePeminjaman"
      class="collapse <?php if (($_SERVER["PHP_SELF"] == "/peminjaman") or ($_SERVER["PHP_SELF"] == "/peminjaman/index.php") or ($_SERVER["PHP_SELF"] == "/peminjaman/add.php") or ($_SERVER["PHP_SELF"] == "/peminjaman/update.php")) : ?> show <?php endif; ?>"
      aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item <?php if (($_SERVER["PHP_SELF"] == "/peminjaman") or ($_SERVER["PHP_SELF"] == "/peminjaman/index.php") or ($_SERVER["PHP_SELF"] == "/peminjaman/update.php")) : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/peminjaman">List Peminjaman</a>
        <a class="collapse-item <?php if ($_SERVER["PHP_SELF"] == "/peminjaman/add.php") : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/peminjaman/add.php">Add Peminjaman</a>
      </div>
    </div>
  </li>
  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDVD" aria-expanded="true"
      aria-controls="collapseDVD">
      <i class="fas fa-fw fa-compact-disc"></i>
      <span>DVD Film</span>
    </a>
    <div id="collapseDVD"
      class="collapse <?php if (($_SERVER["PHP_SELF"] == "/dvd_film") or ($_SERVER["PHP_SELF"] == "/dvd_film/index.php") or ($_SERVER["PHP_SELF"] == "/dvd_film/add.php") or ($_SERVER["PHP_SELF"] == "/dvd_film/update.php") or ($_SERVER["PHP_SELF"] == "/dvd_film/stock.php")) : ?> show <?php endif; ?>"
      aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item <?php if (($_SERVER["PHP_SELF"] == "/dvd_film") or ($_SERVER["PHP_SELF"] == "/dvd_film/index.php") or ($_SERVER["PHP_SELF"] == "/dvd_film/update.php")) : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/dvd_film">List Film</a>
        <a class="collapse-item <?php if ($_SERVER["PHP_SELF"] == "/dvd_film/stock.php") : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/dvd_film/stock.php">Stock Film</a>
        <a class="collapse-item <?php if ($_SERVER["PHP_SELF"] == "/dvd_film/add.php") : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/dvd_film/add.php">Add Film</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">
  <!-- Heading -->
  <div class="sidebar-heading">
    Accounts
  </div>
  <!-- Nav Item - Pages Collapse Menu -->
  <?php if ($_SESSION["role"] == "Admin") : ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaff" aria-expanded="true"
      aria-controls="collapseStaff">
      <i class="fab fa-github"></i>
      <span>Staff</span>
    </a>
    <div id="collapseStaff"
      class="collapse <?php if (($_SERVER["PHP_SELF"] == "/staff") or ($_SERVER["PHP_SELF"] == "/staff/index.php") or ($_SERVER["PHP_SELF"] == "/staff/add.php") or ($_SERVER["PHP_SELF"] == "/staff/update.php")) : ?> show <?php endif; ?>"
      aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item <?php if (($_SERVER["PHP_SELF"] == "/staff") or ($_SERVER["PHP_SELF"] == "/staff/index.php") or ($_SERVER["PHP_SELF"] == "/staff/update.php")) : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/staff">List Staff</a>
        <a class="collapse-item <?php if (($_SERVER["PHP_SELF"] == "/staff/add.php")) : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/staff/add.php">Add Staff</a>
      </div>
    </div>
  </li>
  <?php endif; ?>
  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMembers" aria-expanded="true"
      aria-controls="collapseMembers">
      <i class="fas fa-fw fa-users"></i>
      <span>Members</span>
    </a>
    <div id="collapseMembers"
      class="collapse <?php if (($_SERVER["PHP_SELF"] == "/members") or ($_SERVER["PHP_SELF"] == "/members/index.php") or ($_SERVER["PHP_SELF"] == "/members/add.php") or ($_SERVER["PHP_SELF"] == "/members/update.php")) : ?> show <?php endif; ?>"
      aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item <?php if (($_SERVER["PHP_SELF"] == "/members") or ($_SERVER["PHP_SELF"] == "/members/index.php") or ($_SERVER["PHP_SELF"] == "/members/update.php")) : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/members">List Members</a>
        <a class="collapse-item <?php if (($_SERVER["PHP_SELF"] == "/members/add.php")) : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/members/add.php">Add Member</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <!-- Nav Item - Pages Collapse Menu -->
  <?php if ($_SESSION["role"] == "Admin") : ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLog" aria-expanded="true"
      aria-controls="collapseLog">
      <i class="fas fa-fw fa-history"></i>
      <span>Logs</span>
    </a>
    <div id="collapseLog"
      class="collapse <?php if (($_SERVER["PHP_SELF"] == "/log_activity.php") or ($_SERVER["PHP_SELF"] == "/log_login.php")) : ?> show <?php endif; ?>"
      aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item <?php if ($_SERVER["PHP_SELF"] == "/log_activity.php") : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/log_activity.php">Log Activity</a>
        <a class="collapse-item <?php if ($_SERVER["PHP_SELF"] == "/log_login.php") : ?> active <?php endif; ?>"
          href="<?= $base_url; ?>/log_login.php">Log Login</a>
      </div>
    </div>
  </li>
  <?php endif; ?>
  <!-- Nav Item - About -->
  <li class="nav-item <?php if (($_SERVER["PHP_SELF"] == "/about.php")) : ?> active <?php endif; ?>">
    <a class="nav-link" href="<?= $base_url; ?>/about.php">
      <i class="fas fa-fw fa-info-circle"></i>
      <span>About</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <!-- Nav Item - Logout -->
  <li class="nav-item <?php if (($_SERVER["PHP_SELF"] == "/logout.php")) : ?> active <?php endif; ?>">
    <a class="nav-link" href="<?= $base_url; ?>/logout.php" data-toggle="modal" data-target="#logoutModal">
      <i class="fas fa-sign-out-alt"></i>
      <span>Logout</span></a>
  </li>
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>