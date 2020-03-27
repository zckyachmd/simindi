<?php
  require_once '../config/start.php';

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: ../login.php");
      exit;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $id_member = $_POST["id_member"];
      $judul = $_POST["judul"];
      $petugas = $_SESSION["no_account"];

      $get_dvd = mysqli_query($connect, "SELECT * FROM dvd_film WHERE judul='$judul'");
      $dvd = mysqli_fetch_assoc($get_dvd);

      $count_dvd_film = mysqli_query($connect, "SELECT count(id_film) AS jumlah_film FROM meminjam WHERE judul_film='$judul'");
      $get_dvd_film = mysqli_fetch_array($count_dvd_film);

      $count_pengembalian = mysqli_query($connect, "SELECT count(waktu_pengembalian) AS pengembalian FROM meminjam WHERE judul_film='$judul'");
      $get_pengembalian = mysqli_fetch_array($count_pengembalian);

      $stock = $dvd["stock"] - ($get_dvd_film["jumlah_film"] - $get_pengembalian["pengembalian"]);

      if ($stock >= 1) {
          $get_member = mysqli_query($connect, "SELECT * FROM members WHERE no_member='$id_member'");
          $data_member = mysqli_fetch_assoc($get_member);

          $no_member = $data_member["no_member"];
          $nama_member = $data_member["nama_lengkap"];

          $get_film = mysqli_query($connect, "SELECT * FROM dvd_film WHERE judul='$judul'");
          $data_film = mysqli_fetch_assoc($get_film);

          $id_film = $data_film["id_film"];

          $count_peminjaman = mysqli_query($connect, "SELECT id AS no_acc FROM meminjam ORDER BY id DESC");
          $get_no_peminjaman = mysqli_fetch_array($count_peminjaman);
          $no_peminjam = $data_film["id_film"] . date("d") . ($get_no_peminjaman['no_acc'] + 1);

          $query = "INSERT INTO meminjam VALUE (NULL, '$no_peminjam', '$petugas', '$no_member', '$nama_member', '$id_film', '$judul', NOW(), NULL, NOW() + INTERVAL 3 DAY)";
          mysqli_query($connect, $query);

          if (mysqli_affected_rows($connect) >= 1) {
              echo "
                <script>
                  alert('$nama_member berhasil meminjam DVD Film $judul');
                  document.location.href = 'index.php';
                </script>
              ";
          } else {
              echo "
                <script>
                  alert('$nama_member gagal meminjam DVD Film $judul');
                  document.location.href = 'index.php';
                </script>
              ";
          }
      } else {
          echo "
            <script>
              alert('DVD Film [$judul] telah habis!');
              document.location.href = 'index.php';
            </script>
          ";
      }
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

    <title>Add Members | <?= title; ?></title>

    <link href="<?= $base_url; ?>/assets/img/simindi.png" rel="icon" type="image/png" />
    <!-- Custom fonts for this template-->
    <link href="<?= $base_url; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="<?= $base_url; ?>/assets/css/sb-admin-2.css" rel="stylesheet" />
  </head>
  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

      <!-- Sidebar -->
      <?php include_once $_SERVER["DOCUMENT_ROOT"] . '/assets/inc/sidebar.inc'; ?>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

          <!-- Navbar -->
          <?php include_once $_SERVER["DOCUMENT_ROOT"] . '/assets/inc/navbar.inc'; ?>
          <!-- End of Navbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-5">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $base_url; ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= $base_url; ?>/members">Members</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
              </ol>
            </nav>

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h4 mb-0 text-gray-800">Members</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

              <!-- Area Chart -->
              <div class="col">
                <!-- Approach -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <i class="fas fa-fw fa-folder-open"></i>
                    Add Data Members
                  </div>
                  <div class="card-body">
                    <?php if (isset($result)) : ?>
                    <div class="alert alert-success" role="alert">
                      <?= $result; ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php elseif (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                      <?= $error; ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php endif; ?>
                    <form class="needs-validation" novalidate method="post">
                      <div class="form-row">
                        <div class="form-group col-md-8">
                          <label for="id_member">ID Member</label>
                          <input type="text" class="form-control" id="id_member" name="id_member"
                            placeholder="231120191" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="judul">Judul Film</label>
                          <select id="judul" name="judul" class="form-control" required>
                            <option value="">Choose...</option>
                            <?php
                              $get_dvd_film = show("SELECT * FROM dvd_film");
                              foreach ($get_dvd_film as $dvd_film) :
                            ?>
                              <option value="<?= $dvd_film["judul"]; ?>">
                                <?= $dvd_film["judul"]; ?>
                              </option>
                            <?php
                              endforeach;
                            ?>
                          </select>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-dark btn-icon-split">
                        <span class="icon text-dark-50">
                          <i class="fas fa-paper-plane"></i>
                        </span>
                        <span class="text">Add</span>
                      </button>
                      <button type="reset" class="btn btn-danger ml-1">Reset</button>
                    </form>
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