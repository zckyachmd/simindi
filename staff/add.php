<?php
  require_once '../config/start.php';

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: ../login.php");
      exit;
  }

  if ($_SESSION["role"] != "Admin") {
      header("location: javascript://history.go(-1)");
      exit;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = strip_tags(trim($_POST["name"]));
      $email = strip_tags(strtolower(trim($_POST["email"])));
      $username = strip_tags(strtolower(trim($_POST["username"])));
      $password = mysqli_real_escape_string($connect, $_POST["password"]);
      $confirm_password = mysqli_real_escape_string($connect, $_POST["confirm_password"]);
      $role = $_POST["role"];

      if ($password == $confirm_password) {
          $check_account = mysqli_query($connect, "SELECT * FROM accounts WHERE username='$username' OR email='$email'");
          $row = mysqli_fetch_assoc($check_account);

          if (mysqli_num_rows($check_account) <= 0) {
              $count_account = mysqli_query($connect, "SELECT count(*) AS no_acc FROM accounts ORDER BY id DESC");
              $get_no_account = mysqli_fetch_array($count_account);
              $no_acc = $get_no_account['no_acc'] + 1;

              if ($role == "Admin") {
                  $no_account = "ADM_" . $no_acc;
              } elseif ($role == "Staff") {
                  $no_account = "STF_" . $no_acc;
              }

              $password = PASSWORD_HASH($password, PASSWORD_DEFAULT);

              $query = "INSERT INTO accounts VALUE (NULL, '$no_account', '$name', '$email', '$username', '$password', '$role', NOW())";
              mysqli_query($connect, $query);

              if (mysqli_affected_rows($connect) >= 1) {
                  $result = $name . " berhasil didaftarkan [" . $no_account . "]";
              } else {
                  $error = $name . " gagal didaftarkan [" . $no_account . "]";
              }
          } else {
              $error = $name . " telah terdaftar [" . $row['no_account'] . "]";
          }
      } else {
          $error = "Password tidak cocok!";
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

  <title>Add Staff | <?= title; ?></title>

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
              <li class="breadcrumb-item"><a href="<?= $base_url; ?>/staff">Staff</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
          </nav>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Staff</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Area Chart -->
            <div class="col">
              <!-- Approach -->
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<i class="fab fa-github"></i>
									Add Data Staff
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
											<div class="form-group col-md-8">
												<label for="name">Name</label>
												<input type="text" class="form-control" id="name" name="name"
													placeholder="Zacky Achmad" required/>
											</div>
											<div class="form-group col-md-4">
												<label for="role">Roles</label>
												<select id="role" name="role" class="form-control" required/>
													<option value="">Choose...</option>
													<option value="Admin">Admin</option>
													<option value="Staff">Staff</option>
												</select>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="email">Email</label>
												<input type="email" class="form-control" id="email" name="email" placeholder="zckyachmd@gmail.com" required/>
											</div>
											<div class="form-group col-md-6">
												<label for="username">Username</label>
												<input type="text" class="form-control" id="username" name="username" placeholder="zckyachmd" required/>
											</div>
										</div>
										<div class="form-group">
											<label for="password">Password</label>
											<input type="password" class="form-control" id="password" name="password" required/>
										</div>
										<div class="form-group">
											<label for="confirm_password">Confirm Password</label>
											<input type="password" class="form-control" id="confirm_password" name="confirm_password" required/>
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