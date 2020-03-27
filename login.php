<?php
  require_once 'config/start.php';

  if (count($_COOKIE) > 1) {
      $accounts = show("SELECT * FROM accounts");
      foreach ($accounts as $account) {
          if (isset($_COOKIE['key']) == hash('sha256', $account["username"])) {
              $_SESSION["no_account"] = $account["no_account"];
              $_SESSION["name"] = $account["name"];
              $_SESSION["role"] = $account["role"];
              $_SESSION["ava"] = $row["ava"];

              header("Location: index.php");
              exit;
          }
      }
  } else {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $email = strip_tags(strtolower(trim($_POST["email"])));
          $password = mysqli_real_escape_string($connect, $_POST["password"]);

          $check_accounts = mysqli_query($connect, "SELECT * FROM accounts WHERE email='$email' OR username='$email'");
          $row = mysqli_fetch_assoc($check_accounts);

          if (mysqli_num_rows($check_accounts) == 1) {
              if (PASSWORD_VERIFY($password, $row["password"])) {
                  $_SESSION["no_account"] = $row["no_account"];
                  $_SESSION["name"] = $row["name"];
                  $_SESSION["role"] = $row["role"];
                  $_SESSION["ava"] = $row["ava"];

                  if (isset($_POST["remember"])) {
                      setcookie("key", hash('sha256', $row['username']), time() + (60 * 60 * 24 * 30));
                  }

                  $get_no_account = $row["no_account"];
                  $get_name = $row["name"];
                  $get_ip = $_SERVER['REMOTE_ADDR'];

                  $query = "INSERT INTO log_login VALUE (NULL, '$get_no_account', '$get_name', '$get_ip', NOW())";
                  mysqli_query($connect, $query);

                  header("Location: index.php");
                  exit;
              } else {
                  $error = "Username / Password Salah!";
              }
          } else {
              $error = "Akun tidak terdaftar!";
          }
      }
  }

  if (isset($_SESSION["no_account"]) && isset($_SESSION["name"]) && isset($_SESSION["role"])) {
      header("Location: index.php");
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

    <title>Login | <?= title; ?></title>

    <link href="assets/img/simindi.png" rel="icon" type="image/png" />
    <!-- Custom fonts for this template-->
    <link href="<?= $base_url; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="<?= $base_url; ?>/assets/css/sb-admin-2.css" rel="stylesheet" />
  </head>
  <body class="bg-gradient-info my-5">
    <div class="container">
      <!-- Outer Row -->
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9 my-5">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <!-- Nested Row within Card Body -->
              <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Welcome to <?= title; ?></h1>
                    </div>
                    <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                      <?= $error; ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php endif; ?>
                    <form method="POST" class="user">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="email"
                          placeholder="Enter Email Address" required/>
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control form-control-user" name="password"
                          placeholder="Password" required/>
                      </div>
                      <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                          <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                          <label class="custom-control-label" for="remember">Remember Me</label>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-info btn-user btn-block">Login</button>
                    </form>
                    <hr>
                    <div class="text-center">
                      <a class="small" href="#">Forgot Password?</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= $base_url; ?>/vendor/jquery/jquery.js"></script>
    <script src="<?= $base_url; ?>/vendor/bootstrap/js/bootstrap.bundle.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= $base_url; ?>/vendor/jquery-easing/jquery.easing.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= $base_url; ?>/assets/js/sb-admin-2.js"></script>
  </body>
</html>
