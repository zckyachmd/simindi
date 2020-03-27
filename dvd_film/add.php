<?php
  require_once '../config/start.php';

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: ../login.php");
      exit;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $judul = $_POST["judul"];
      $genre = $_POST["genre"];
      $director = $_POST["director"];
      $release = $_POST["release"];
      $durasi = $_POST["durasi"];
      $stock = $_POST["stock"];
      $petugas = $_SESSION["no_account"];

      $count_dvd = mysqli_query($connect, "SELECT count(*) AS no_dvd FROM dvd_film");
      $get_no_dvd = mysqli_fetch_array($count_dvd);
      $no_dvd = $get_no_dvd['no_dvd'] + 1;

      switch ($genre) {
        case "Action":
          $id_film = "2125" . $no_dvd;
        break;
        case "Adventure":
          $id_film = "2137" . $no_dvd;
        break;
        case "Comedy":
          $id_film = "2126" . $no_dvd;
        break;
        case "Crime":
          $id_film = "2120" . $no_dvd;
        break;
        case "Drama":
          $id_film = "2118" . $no_dvd;
        break;
        case "Romance":
          $id_film = "2128" . $no_dvd;
        break;
        case "Horor":
          $id_film = "2122" . $no_dvd;
        break;
        case "Sci-Fi":
          $id_film = "2123" . $no_dvd;
        break;
    }

      $check_judul = mysqli_query($connect, "SELECT * FROM dvd_film WHERE judul='$judul'");
      $row = mysqli_fetch_assoc($check_judul);

      if (mysqli_fetch_assoc($check_judul)) {
          $error = $judul . " telah terdaftar [" . $row["id_film"] . "]";
      } else {
          $query = "INSERT INTO dvd_film VALUE ('$id_film', '$judul', '$genre', '$director', '$release', '$durasi', '$stock', '$petugas', NOW())";
          mysqli_query($connect, $query);

          if (mysqli_affected_rows($connect) >= 1) {
              $result = $judul . " berhasil di terdaftar [" . $id_film . "]";
          } else {
              $error = $judul . " gagal di daftar [" . $id_film . "]";
          }
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

    <title>Add DVD Film | <?= title; ?></title>

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
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-5">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $base_url; ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= $base_url; ?>/dvd_film">DVD Film</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
              </ol>
            </nav>

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h4 mb-0 text-gray-800">DVD Film</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

              <!-- Area Chart -->
              <div class="col">
                <!-- Approach -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <i class="fas fa-fw fa-compact-disc"></i>
                    Add Data DVD Film
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
                    <form method="post">
                      <div class="form-row">
                        <div class="form-group col-md-10">
                          <label for="judul">Judul</label>
                          <input type="text" class="form-control" id="judul" name="judul"
                            placeholder="Avengers: Endgame" required>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="genre">Genre</label>
                          <select id="genre" name="genre" class="form-control" required>
                            <option value="">Choose...</option>
                            <option value="Action">Action</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Crime">Crime</option>
                            <option value="Drama">Drama</option>
                            <option value="Romance">Romance</option>
                            <option value="Horor">Horor</option>
                            <option value="Sci-Fi">Sci-Fi</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="director">Director</label>
                        <input type="text" class="form-control" id="director" name="director" placeholder="Anthony Russo, Joe Russo" required>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="release">Release Date</label>
                          <input type="date" class="form-control" id="release" name="release" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="durasi">Durasi</label>
                          <input type="number" class="form-control" id="durasi" name="durasi" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="stock">Stock</label>
                          <input type="number" class="form-control" id="stock" name="stock" required>
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