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

      if (mysqli_num_rows($check_dvd) == 1) {
          mysqli_query($connect, "DELETE FROM dvd_film WHERE id_film = '$id'");

          if (mysqli_affected_rows($connect) > 0) {
              $get_result = "Berhasil menghapus Film " . $row['judul'] . " [" . $row['id_film'] . "]";
              $result = base64_encode($get_result);
              header("Location: index.php?result=$result");
              exit;
          } else {
              $get_error = "Gagal menghapus Film " . $row['judul'] . " [" . $row['id_film'] . "]";
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
