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
      $check_member = mysqli_query($connect, "SELECT * FROM members WHERE id = '$id'");
      $row = mysqli_fetch_assoc($check_member);

      if (mysqli_num_rows($check_member) >= 1) {
          mysqli_query($connect, "DELETE FROM members WHERE id = '$id'");

          if (mysqli_affected_rows($connect) > 0) {
              $get_result = $row["nama_lengkap"] . " berhasil di hapus akun! [" . $row['no_member'] . "]";
              $result = base64_encode($get_result);
              header("Location: index.php?result=$result");
              exit;
          } else {
              $get_error = $row["nama_lengkap"] . " gagal di hapus akun! [" . $row['no_member'] . "]";
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
