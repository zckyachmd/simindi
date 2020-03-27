<?php
  require_once '../config/start.php';

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: ../login.php");
      exit;
  }

  if (!isset($_GET["id"])) {
      header("location: javascript://history.go(-1)");
      exit;
  } else {
      $id = $_GET["id"];
      $check_dvd = mysqli_query($connect, "SELECT * FROM dvd_film WHERE id_film = '$id'");
      $row = mysqli_fetch_assoc($check_dvd);

      if (mysqli_num_rows($check_dvd) >= 1) {
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $judul = $_POST["judul"];
              $genre = $_POST["genre"];
              $director = $_POST["director"];
              $release = $_POST["release"];
              $durasi = $_POST["durasi"];
              $stock = $_POST["stock"];
              $petugas = $_SESSION["no_account"];

              $query = "UPDATE dvd_film SET judul = '$judul', genre = '$genre', director = '$director', release_date = '$release', durasi = '$durasi', stock = '$stock', no_petugas = '$petugas' WHERE id_film = '$id'";
              mysqli_query($connect, $query);

              if (mysqli_affected_rows($connect)) {
                  $get_result = "Data ". $judul . " berhasil di perbaharui [" . $row["id_film"] . "]";
                  $result = base64_encode($get_result);
                  header("Location: index.php?result=$result");
                  exit;
              } else {
                  $get_error = "Data ". $judul . " gagal di perbaharui [" . $row["id_film"] . "]";
                  $error = base64_encode($get_error);
                  header("Location: index.php?error=$error");
                  exit;
              }
          }
      } else {
          $get_error = "Data tidak di temukan!";
          $error = base64_encode($get_error);
          header("Location: index.php?error=$error");
          exit;
      }
  }
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

    <title>Update DVD Film | <?= title; ?></title>

    <link href="<?= $base_url; ?>/assets/img/simindi.png" rel="icon" type="image/png" />

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
                <li class="breadcrumb-item"><a href="<?= $base_url; ?>/dvd_film">DVD Film</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
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
                    Update Data DVD Film
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
                            placeholder="Avengers: Endgame" value="<?= $row["judul"]; ?>" required>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="genre">Genre</label>
                          <select id="genre" name="genre" class="form-control" required>
                            <option value="">Choose...</option>
                            <option value="Action" <?= $row["genre"] == "Action" ? "selected" : ""; ?>>Action</option>
                            <option value="Adventure" <?= $row["genre"] == "Adventure" ? "selected" : ""; ?>>Adventure</option>
                            <option value="Comedy" <?= $row["genre"] == "Comedy" ? "selected" : ""; ?>>Comedy</option>
                            <option value="Crime" <?= $row["genre"] == "Crime" ? "selected" : ""; ?>>Crime</option>
                            <option value="Drama" <?= $row["genre"] == "Drama" ? "selected" : ""; ?>>Drama</option>
                            <option value="Romance" <?= $row["genre"] == "Romance" ? "selected" : ""; ?>>Romance</option>
                            <option value="Horor" <?= $row["genre"] == "Horor" ? "selected" : ""; ?>>Horor</option>
                            <option value="Sci-Fi" <?= $row["genre"] == "Sci-Fi" ? "selected" : ""; ?>>Sci-Fi</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="director">Director</label>
                        <input type="text" class="form-control" id="director" name="director" placeholder="Anthony Russo, Joe Russo" value="<?= $row["director"]; ?>" required>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="release">Release Date</label>
                          <input type="date" class="form-control" id="release" name="release" value="<?= $row["release_date"]; ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="durasi">Durasi</label>
                          <input type="number" class="form-control" id="durasi" name="durasi" value="<?= $row["durasi"]; ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="stock">Stock</label>
                          <input type="number" class="form-control" id="stock" name="stock" value="<?= $row["stock"]; ?>" required>
                        </div>
                      </div>
                      <button type="submit" name="submit" class="btn btn-dark btn-icon-split">
                        <span class="icon text-dark-50">
                          <i class="fas fa-paper-plane"></i>
                        </span>
                        <span class="text">Update</span>
                      </button>
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