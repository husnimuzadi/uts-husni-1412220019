<?php 
// koneksi ke database
require 'functions.php';
$penerima_zis = query("SELECT * FROM penerima_zis");

  $jumlahDataPerhalaman = 5;
  $jumlahData = count(query("SELECT * FROM penerima_zis"));
  $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
  $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
  $awalData = ($jumlahDataPerhalaman * ($halamanAktif - 1));
  
  $penerima_zis = query("SELECT * FROM penerima_zis LIMIT $awalData,$jumlahDataPerhalaman");

  if (isset($_POST["cari"]) ) {
    $penerima_zis = cari_penerima_zis($_POST["kunci"]);
  }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Penerima ZIS</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Sistem ZIS Online</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?php
        $conn = mysqli_connect("localhost", "root", "", "husni-1412220019");
        $query = "SELECT * FROM user LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (!$result) {
          die("Error: " . mysqli_error($conn));
        }
        $user = mysqli_fetch_assoc($result);
        ?>
        <?php echo $user['username']; ?> <!-- Menampilkan username pengguna yang sedang login -->
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Keluar</a></li> <!-- Tambahkan link untuk logout -->
            </ul>
        </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                                <a class="nav-link" href="data-zis.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div>
                                  Data ZIS
                                </a>
                            <a class="nav-link" href="penerima_zis.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div>
                                Data Penerima ZIS
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Penerima ZIS</h1>
                        <a href="tambah-penerima.php" class="btn btn-primary mb-3">
                      <i class="fas fa-plus mr-2"></i>
                      Tambah Data
                    </a>
                    <form method="POST" action="">
                    <div class="input-group mb-4">
                    <input type="text" name="kunci" class="form-control" autofocus placeholder="Masukkan Keyword Pencarian" autocomplete="off" id="kunci">
                    <button class="btn btn-outline-primary" type="submit" name="cari" id="cari"><i class="fas fa-search"></i> Cari</button>

                    <!-- <img src="img/loader.gif" class="loader"> -->

                </div>
          <div class="card-body">
        <table class="table table-bordered">
          <thead align="center">
            <tr>
              <th>No.</th>
              <th>Nama Penerima</th>
              <th>Alamat</th>
              <th>Status Kelayakan</th>
              <th>Kebutuhan</th>
              <th>Kategori Penerima</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody align="center">
                <?php $i = 1; ?>
                <?php foreach ($penerima_zis as $row) : ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td><?php echo $row["nama_penerima"]; ?></td>
                    <td><?php echo $row["alamat"]; ?></td>
                    <td><?php echo $row["status_kelayakan"]; ?></td>
                    <td><?php echo $row["kebutuhan"]; ?></td>
                    <td><?php echo $row["kategori_penerima"]; ?></td>
                    <td>
                    <div class="btn-group" role="group">
                        <a href="ubah-penerima-zis.php?id_penerima=<?php echo $row["id_penerima"]; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Yakin Data Akan Diubah?');">Ubah</a> &nbsp;
                        <a href="hapus-penerima-zis.php?id_penerima=<?php echo $row["id_penerima"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Data Akan Dihapus?');">Hapus</a>
                    </div>
                </td>
                  </tr>
                  <?php $i++; ?>
                <?php endforeach; ?>
              </tbody>
        </table>
        <nav aria-label="Page navigation" class="page">
            <ul class="pagination justify-content-left">

                <?php if($halamanAktif > 1) : ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?>">&laquo;</a></li>
                <?php endif; ?>

                <?php for($id = 1; $id <= $jumlahHalaman; $id++) : ?>
                <li class="page-item <?= $id == $halamanAktif ? 'active' : '' ?>">
                    <a class="page-link" href="?halaman=<?= $id ?>"><?= $id ?></a>
                </li>
                <?php endfor; ?>

                <?php if($halamanAktif < $jumlahHalaman) : ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>">&raquo;</a></li>
                <?php endif; ?>

            </ul>
            </nav>
      </div>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
