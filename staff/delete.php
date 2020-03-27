<?php
  require_once '../config/start.php';

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: ../login.php");
      exit;
  }

  if ($_SESSION["role"] != "Admin" or !isset($_GET["id"])) {
      header("location: javascript://history.go(-1)");
      exit;
  } else {
      $id = $_GET["id"];
      $check_account = mysqli_query($connect, "SELECT * FROM accounts WHERE id = '$id'");
      $row = mysqli_fetch_assoc($check_account);

      if (mysqli_num_rows($check_account) > 0) {
          $no_account = $row["no_account"];
          mysqli_query($connect, "DELETE FROM accounts WHERE id = '$id'");

          if (mysqli_affected_rows($connect) > 0) {
              $get_result = $row['name'] . " berhasil di hapus ! [" . $row['no_account'] . "]";
              $result = base64_encode($get_result);
              header("Location: index.php?result=$result");
              exit;
          } else {
              $get_error = $row['name'] . " gagal di hapus ! [" . $row['no_account'] . "]";
              $error = base64_encode($get_error);
              header("Location: index.php?error=$error");
              exit;
          }
      } else {
          $get_error = "Data tidak di temukan!";
          $error = base64_encode($get_error);
          header("Location: index.php?error=$error");
          exit;
      }
  }
