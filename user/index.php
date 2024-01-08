<?php
require 'function.php';
session_start(); // Pastikan session_start() sudah dipanggil di awal skrip

// Cek apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
    echo "<script>
        window.alert('Anda belum login" .   "!');
        document.location.href = '../login';
      </script>";
    exit;
}

// Ambil informasi pengguna dari sesi
$username = $_SESSION['login'];

// Ambil data siswa berdasarkan nama pengguna
global $koneksi;
$query = "SELECT students.* 
          FROM students 
          JOIN accounts ON students.username_student = accounts.username 
          WHERE accounts.username = '$username'";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animasi Login -->
    <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
    <style type="text/css">
    </style>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <!-- Own CSS -->
    <link rel="stylesheet" href="./style.css">

    <title>SekolahKu</title>
</head>
<style>
    .custom-font  {
        font-size: 15px;
    }

    .custom-font th{
        font-size: 14px;
        padding: 8px 2px;
    }
</style>

<body>
    <!-- Tampilkan preloader -->
  </div>
</div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
        <div class="container">
            <a class="navbar-brand" href="index.php">SekolahKu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <?php 
                            if (!isset($_SESSION['login'])) {
                                echo '<a href="../login.php" class="nav-link">Login</a>';
                            } else {
                                echo '<a href="../user" class="nav-link">' . $_SESSION["login"] . '</a>';
                            }      
                        ?>                    
                    </li>
                    <li class="nav-item">
                        <?php 
                            if (isset($_SESSION['login'])) {
                                echo '<a href="../logout" class="nav-link">Logout</a>';
                            }  
                        ?>                    
                    </li>

                    <?php 

                        if (!isset($_SESSION['login']) || $_SESSION['role'] == 'admin') {
                            echo "<li class='nav-item'> <a class='nav-link' href='../dashboard'>Dashboard</a></li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Close Navbar -->

    <!-- Container -->
    <div class="container">
        <div class="row my-2">
            <div class="col-md">
                <?php foreach ($result as $student_data): ?>
                    <h3 class="text-center fw-bold text-uppercase"><?= $student_data['name']; ?></h3>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-md">
                <a href="export.php" target="_blank" class="btn btn-success ms-1"><i class="bi bi-file-earmark-spreadsheet-fill"></i>&nbsp;Ekspor ke Excel</a>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md">
                <table class=" custom-font table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Kode</th>
                            <th>Class</th>
                            <th>Year</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Birth Date</th>
                            <th>Quote</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $student_data['id']; ?></td>
                            <td><?php echo $student_data['name']; ?></td>
                            <td><?php echo $student_data['kode']; ?></td>
                            <td><?php echo $student_data['class']; ?></td>
                            <td><?php echo $student_data['year']; ?></td>
                            <td><?php echo $student_data['email']; ?></td>
                            <td><?php echo $student_data['address']; ?></td>
                            <td><?php echo $student_data['birth_date']; ?></td>
                            <td><?php echo $student_data['quote']; ?></td>
                            <td>
                            <a href="ubah.php?kode=<?= $student_data['kode']; ?>" class="btn btn-warning btn-sm" style="font-weight: 600;"><i class="bi bi-pencil-square"></i>&nbsp;Modify</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Close Container -->

    <!-- Modal Detail Data -->
    <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-uppercase" id="detail">Detail Data Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="detail-siswa">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Modal Detail Data -->

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Data Tables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Fungsi Table
            $('#data').DataTable();
            // Fungsi Table

            // Fungsi Detail
            $('.detail').click(function() {
                var dataSiswa = $(this).attr("data-id");
                $.ajax({
                    url: "detail.php",
                    method: "post",
                    data: {
                        dataSiswa,
                        dataSiswa
                    },
                    success: function(data) {
                        $('#detail-siswa').html(data);
                        $('#detail').modal("show");
                    }
                });
            });
            // Fungsi Detail
        });
    </script>
</body>

</html>