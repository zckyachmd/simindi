<?php
  require_once 'config/start.php';

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: login.php");
      exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= description; ?>" />
    <meta name="keywords" content="<?= keywords; ?>" />
    <meta name="author" content="<?= author; ?>" />

    <title>About | <?= title; ?></title>

    <link href="<?= $base_url; ?>/assets/img/simindi.png" rel="icon" type="image/png" />

    <!-- Custom fonts for this template-->
    <link href="<?= $base_url; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"  rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="<?= $base_url; ?>/assets/css/sb-admin-2.css" rel="stylesheet" />
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
              <h1 class="h3 mb-0 text-gray-800">About</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

              <!-- Area Chart -->
              <div class="col">
                <!-- Approach -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= title; ?></h6>
                  </div>
                  <div class="card-body">
                    <p><?= title; ?> | Sistem Peminjaman DVD Film. Website yang ditujukan untuk membantu dalam
                      pencatatan administrasi peminjaman Film disebuah toko DVD.
                      <br /> Didasari dari kasus administrasi sebuah toko DVD Film yang masih konvensional yaitu dengan
                      mencatat di sebuah buku. Maka dari itu kami mencoba untuk memodernisasikan proses administasi
                      tersebut agar lebih teratur, jelas dan terperinci.</p>
                    <p class="mb-0">Proyek ini bertujuan untuk memenuhi tugas matakuliah Pemrograman Berbasis Website
                      dan Basis Data.
                      <br />Bagaskara Achmad Zaky (7708180096) | Prodi Teknologi Rekayasa Multimedia Fakultas Ilmu
                      Terapan - Telkom University
                    </p>
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