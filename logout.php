<?php
  require_once 'config/start.php';

  if (count($_SESSION) >= 1) {
      $get_account = $_SESSION["no_account"];
      $check_username = mysqli_query($connect, "SELECT * FROM accounts WHERE no_account = '$get_account'");
      $row = mysqli_fetch_assoc($check_username);

      setcookie("key", hash('sha256', $row['username']), time() - (60 * 60 * 24 * 30));

      unset($_SESSION["no_account"]);
      unset($_SESSION["name"]);
      unset($_SESSION["role"]);
      unset($_SESSION["ava"]);
      session_destroy();
  }

  header("Location: login.php");
  exit;
