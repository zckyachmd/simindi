<?php
  require_once '../config/start.php';
  require_once '../config/functions.php';

  if (!isset($_SESSION["no_account"]) && !isset($_SESSION["name"]) && !isset($_SESSION["role"])) {
      header("Location: ../login.php");
      exit;
  }

  $check_update = mysqli_query($connect, "SELECT waktu_pendaftaran as waktu FROM members ORDER BY waktu DESC LIMIT 1");
  $get_update = mysqli_fetch_row($check_update)[0];
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

    <title>Members | <?= title; ?></title>

    <link href="<?= $base_url; ?>/assets/img/simindi.png" rel="icon" type="image/png" />

    <!-- Custom fonts for this template-->
    <link href="<?= $base_url; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="<?= $base_url; ?>/assets/css/sb-admin-2.css" rel="stylesheet" />

    <!-- Custom styles for this page -->
    <link href="<?= $base_url; ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />
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
                <li class="breadcrumb-item">Members</li>
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
                    Data Members
                  </div>
                  <div class="card-body">
                    <?php if (isset($_GET["result"])) : ?>
                    <div class="alert alert-success" role="alert">
                      <?= base64_decode($_GET["result"]); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($_GET["error"])) : ?>
                    <div class="alert alert-danger" role="alert">
                      <?= base64_decode($_GET["error"]); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th style="width: 5%">No</th>
                            <td>ID Member</td>
                            <td>Nama</td>
                            <td>JK</td>
                            <td>No KTP</td>
                            <td>Tanggal Lahir</td>
                            <td>Alamat</td>
                            <td>No HP</td>
                            <td>Email</td>
                            <?php if ($_SESSION["role"] == "Admin") :?>
                            <td>Register Date</td>
                            <td>Petugas</td>
                            <?php endif; ?>
                            <td style="width: 9%">Action</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $i = 1;
                            $get_members = show("SELECT * FROM members");
                            foreach ($get_members as $member) :
                          ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td>#<?= $member["no_member"]; ?></td>
                            <td><?= $member["nama_lengkap"]; ?></td>
                            <td><?= $member["jenis_kelamin"]; ?></td>
                            <td><?= $member["no_ktp"]; ?></td>
                            <td><?= $member["tgl_lahir"]; ?></td>
                            <td><?= $member["alamat"]; ?></td>
                            <td><?= $member["no_hp"]; ?></td>
                            <td><?= $member["email"]; ?></td>
                            <?php if ($_SESSION["role"] == "Admin") :?>
                            <td><?= $member["waktu_pendaftaran"]; ?></td>
                            <td><?= $member["no_petugas"]; ?></td>
                            <?php endif; ?>
                            <td>
                              <a href="update.php?id=<?= $member["id"]; ?>" class="btn btn-sm btn-info">
                                <span class="fas fa-pencil-alt"></span>
                              </a>
                              &nbsp;
                              <a href="delete.php?id=<?= $member["id"]; ?>" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger">
                                <span class="far fa-trash-alt"></span>
                              </a>
                            </td>
                          </tr>
                          <?php
                          $i++;
                          endforeach;
                          ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th style="width: 5%">No</th>
                            <td>ID Member</td>
                            <td>Nama</td>
                            <td>JK</td>
                            <td>No KTP</td>
                            <td>Tanggal Lahir</td>
                            <td>Alamat</td>
                            <td>No HP</td>
                            <td>Email</td>
                            <?php if ($_SESSION["role"] == "Admin") :?>
                            <td>Register Date</td>
                            <td>Petugas</td>
                            <?php endif; ?>
                            <td style="width: 9%">Action</td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer small text-muted">
                    Last Update <?= $get_update; ?>
                  </div>
                </div>
                <a href="add.php" class="btn btn-dark btn-icon-split mb-5">
                  <span class="icon text-dark-50">
                    <i class="fas fa-paper-plane"></i>
                  </span>
                  <span class="text">Add Member</span>
                </a>
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

    <!-- Page level plugins -->
    <script src="<?= $base_url; ?>/vendor/datatables/jquery.dataTables.js"></script>
    <script src="<?= $base_url; ?>/vendor/datatables/dataTables.bootstrap4.js"></script>
    </script>

    <!-- Page level custom scripts -->
    <script src="<?= $base_url; ?>/assets/js/demo/datatables-demo.js"></script>
  </body>
</html>