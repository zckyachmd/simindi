<?php
  require_once 'config/start.php';
  require_once __DIR__ . '/vendor/autoload.php';
  use \Gumlet\ImageResize;

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: login.php");
      exit;
  }

  $id = base64_decode($_GET["id"]);

  if ($id == null) {
      header("location: javascript://history.go(-1)");
      exit;
  } else {
      $check_account = mysqli_query($connect, "SELECT * FROM accounts WHERE no_account = '$id'");
      $row = mysqli_fetch_assoc($check_account);

      if (isset($_POST["submit"])) {
          $username = strip_tags(strtolower(trim($_POST["username"])));
          $email = strip_tags(strtolower(trim($_POST["email"])));
          $password = mysqli_real_escape_string($connect, $_POST["password"]);

          $fileProfile = $_FILES["profile"]["name"];
          $sizeProfile = $_FILES["profile"]["size"];
          $errorProfile = $_FILES["profile"]["error"];
          $tmpProfile = $_FILES["profile"]["tmp_name"];

          if (PASSWORD_VERIFY($password, $row["password"])) {
              if ($errorProfile != 4) {
                  $ekstensiProfileValid = ["jpg", "jpeg", "png"];

                  $ektensiProfile = explode('.', $fileProfile);
                  $ektensiProfile = strtolower(end($ektensiProfile));

                  if (!in_array($ektensiProfile, $ekstensiProfileValid)) {
                      $error = "Jenis file tidak tidak diizinkan!";
                  }

                  if ($sizeProfile > 2097152) {
                      $error = "Ukuran file terlalu besar!";
                  }

                  $nameProfile = $_SESSION["no_account"] . "_" . uniqid() . "." . $ektensiProfile;

                  $image = new ImageResize($tmpProfile);
                  $image->quality_jpg = 80;
                  $image->crop(512, 512, true, ImageResize::CROPCENTER);
                  $image->save('assets/img/staff/'. $nameProfile);

                  if ($image == true) {
                      $query = "UPDATE accounts SET email = '$email', username = '$username', ava = '$nameProfile' WHERE no_account = '$id'";
                      mysqli_query($connect, $query);

                      unset($_SESSION["ava"]);
                      $_SESSION["ava"] = $nameProfile;
                  }
              } else {
                  $query = "UPDATE accounts SET email = '$email', username = '$username' WHERE no_account = '$id'";
                  mysqli_query($connect, $query);
              }

              if (mysqli_affected_rows($connect)) {
                  $result = $row["name"] . " berhasil diperbaharui [" . $row["no_account"] . "]";
              } else {
                  $error = $row["name"] . " gagal diperbaharui [" . $row["no_account"] . "]";
              }
          } else {
              $error = "Password Salah!";
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

    <title>Profile <?= $_SESSION["name"]; ?> | <?= title; ?></title>

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
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
              </ol>
            </nav>

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h4 mb-0 text-gray-800">Profile</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

              <!-- Area Chart -->
              <div class="col">
                <!-- Approach -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <i class="fab fa-github"></i>
                    Update Profile
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
                    <div class="container text-center">
                      <?php if ($row["ava"] != null) : ?>
                        <img src="<?= $base_url; ?>/assets/img/staff/<?= $_SESSION["ava"]; ?>" width="200px" height="200px" class="rounded-circle img-thumbnail" />
                      <?php else : ?>
                        <img src="<?= $base_url; ?>/assets/img/ava_default.png" width="200px" height="200px" class="rounded-circle img-thumbnail" />
                      <?php endif; ?>
                      <h3 class="display-6" style="margin-top: 15px"><?= $_SESSION["name"]; ?></h3>
                      <p><?= $_SESSION["role"]; ?></p>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                      <div class="form-row">
                        <div class="form-group col-md-8">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Zacky Achmad" value="<?= $row["name"]; ?>" disabled />
                        </div>
                        <div class="form-group col-md-4">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" id="username" name="username" placeholder="zckyachmd" value="<?= $row["username"]; ?>" required />
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="zckyachmd@gmail.com" value="<?= $row["email"]; ?>" required />
                        </div>
                        <div class="form-group col-md-6">
                          <label for="profile">Profile Picture</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="profile" name="profile">
                            <label class="custom-file-label" for="profile">Choose file</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required />
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

    <script>
      // Add the following code if you want the name of the file appear on select
      $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
    </script>
  </body>
</html>