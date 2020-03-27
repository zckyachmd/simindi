<?php
  require_once '../config/start.php';

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: ../login.php");
      exit;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = strip_tags(trim($_POST["name"]));
      $jenis_kelamin = $_POST["jenis_kelamin"];
      $no_ktp = strip_tags(trim($_POST["no_ktp"]));
      $tgl_lahir = strip_tags(trim($_POST["tgl_lahir"]));
      $alamat = strip_tags(trim($_POST["alamat"]));
      $no_hp = strip_tags(trim($_POST["no_hp"]));
      $email = strip_tags(strtolower(trim($_POST["email"], null)));
      $petugas = $_SESSION["no_account"];

      $check_ktp = mysqli_query($connect, "SELECT no_ktp FROM members WHERE no_ktp='$no_ktp'");
      $check_email = mysqli_query($connect, "SELECT email FROM members WHERE email='$email'");

      if (mysqli_num_rows($check_ktp) >= 1) {
          $error = "No KTP telah terdaftar [" . $no_ktp . "]";
      } elseif (strlen($no_ktp) != 13) {
          $error = "No KTP tidak sesuai! [" . $no_ktp . "]";
      } else {
          if (mysqli_num_rows($check_email) >= 1) {
              $error = "Email telah terdaftar [" . $email . "]";
          } else {
              $birthday  = new DateTime($tgl_lahir);
              $now = new DateTime();
              $umur = $now->diff($birthday);

              if (($umur->y) < 17) {
                  $error = "Umur " . $name . " kurang dari 17 tahun";
              } else {
                  $count_account = mysqli_query($connect, "SELECT count(*) AS no_acc FROM members ORDER BY id DESC");
                  $get_no_account = mysqli_fetch_array($count_account);
                  $no_acc = ($get_no_account['no_acc'] + 1) . date("dmy");

                  if ($email == null) {
                      $query = "INSERT INTO members VALUE (NULL, $no_acc, '$name', '$jenis_kelamin', '$no_ktp', '$tgl_lahir', '$alamat', '$no_hp', NULL, '$petugas', NOW())";
                      mysqli_query($connect, $query);
                  } else {
                      $query = "INSERT INTO members VALUE (NULL, $no_acc, '$name', '$jenis_kelamin', '$no_ktp', '$tgl_lahir', '$alamat', '$no_hp', '$email', '$petugas', NOW())";
                      mysqli_query($connect, $query);
                  }
                  echo mysqli_error($connect);

                  if (mysqli_affected_rows($connect) >= 1) {
                      $result = $name . " berhasil di terdaftar [" . $no_ktp . "]";
                  } else {
                      $error = $name . " gagal di daftar [" . $no_ktp . "]";
                  }
              }
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

    <title>Add Members | <?= title; ?></title>

    <link href="<?= $base_url; ?>/assets/img/simindi.png" rel="icon" type="image/png" />

    <!-- Custom fonts for this template-->
    <link href="<?= $base_url; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="<?= $base_url; ?>/assets/css/sb-admin-2.css" rel="stylesheet"/>
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
                    <i class="fas fa-fw fa-users"></i>
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
                    <form method="post">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="name">Nama Lengkap</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Zacky" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="no_ktp">No KTP</label>
                          <input type="number" class="form-control" id="no_ktp" name="no_ktp"
                            placeholder="1234567890123" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat"
                          placeholder="Jln. Kenangan No. Terlupakan" required></textarea>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="tgl_lahir">Tanggal Lahir</label>
                          <input type="date" data-date-format="DD-MM-YYYY" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="jenis_kelamin">Jenis Kelamin</label>
                          <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                            <option value="">Choose...</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="no_hp">No Handphone</label>
                          <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="085314069191" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="zckyachmd@gmail.com">
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