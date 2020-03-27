<?php
  require_once 'config/start.php';

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: login.php");
      exit;
  }

  $check_members = mysqli_query($connect, "SELECT * FROM members");
  $get_members = mysqli_num_rows($check_members);

  $check_dvd = mysqli_query($connect, "SELECT * FROM dvd_film");
  $get_dvd = mysqli_num_rows($check_dvd);

  $check_peminjaman = mysqli_query($connect, "SELECT * FROM meminjam");
  $get_peminjaman = mysqli_num_rows($check_peminjaman);

  $check_pengembalian = mysqli_query($connect, "SELECT * FROM meminjam WHERE waktu_pengembalian IS NOT NULL");
  $get_pengembalian = mysqli_num_rows($check_pengembalian);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= description; ?>">
    <meta name="keywords" content="<?= keywords; ?>" />
    <meta name="author" content="<?= author; ?>">

    <title>Dashboard | <?= title; ?></title>

    <link href="assets/img/simindi.png" rel="icon" type="image/png" />

    <!-- Custom fonts for this template-->
    <link href="<?= $base_url; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="<?= $base_url; ?>/assets/css/sb-admin-2.css" rel="stylesheet">
  </head>
  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/inc/sidebar.inc"; ?>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

          <!-- Navbar -->
          <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/inc/navbar.inc"; ?>
          <!-- End of Navbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">DVD Film</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?= $get_dvd; ?> Film
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-fw fa-compact-disc fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Members</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?= $get_members; ?> People
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Peminjaman</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?= $get_peminjaman; ?> Disk
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-sign-out-alt fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Pending Requests Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pengembalian</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?= $get_pengembalian; ?> Disk
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-sign-in-alt fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <i class="fas fa-table"></i>
                    Top Recent Update
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th style="width: 5%">No</th>
                            <th>Judul</th>
                            <th>Genre</th>
                            <th>Release Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $i = 1;
                            $get_dvd_film = show("SELECT * FROM dvd_film ORDER BY waktu_menambahkan DESC LIMIT 5");
                            foreach ($get_dvd_film as $dvd_film) :
                          ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td><?= $dvd_film["judul"]; ?></td>
                            <td><?= $dvd_film["genre"]; ?></td>
                            <td><?= $dvd_film["release_date"]; ?></td>
                          </tr>
                          <?php
                            $i++;
                            endforeach;
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/inc/footer.inc"; ?>
        <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="<?= $base_url; ?>/vendor/jquery/jquery.js"></script>
    <script src="<?= $base_url; ?>/vendor/bootstrap/js/bootstrap.bundle.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= $base_url; ?>/vendor/jquery-easing/jquery.easing.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= $base_url; ?>/assets/js/sb-admin-2.js"></script>
  </body>
</html>