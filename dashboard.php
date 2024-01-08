<?php
session_start();
// Memanggil atau membutuhkan file function.php
require 'siswa/function.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>
                window.alert('Anda bukan admin!');
                document.location.href = 'index.php';
            </script>";
    exit;
}


// Menampilkan semua data dari table mahasiswa berdasarkan nim secara Descending
$students = query("SELECT * FROM students ORDER BY kode DESC");



$schedule = query("SELECT * FROM schedule_view");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animasi Login -->
    <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
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
    <link rel="stylesheet" href="css/style.css">

    <title>SekolahKu</title>
</head>

<body>
</div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
        <div class="container">
            <a class="navbar-brand" href="./">Sekolahku</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <?php 
                            if (!isset($_SESSION['login'])) {
                                echo '<a href="./login" class="nav-link">Login</a>';
                            } else {
                                echo '<a href="./user" class="nav-link">' . $_SESSION["login"] . '</a>';
                            }      
                        ?>                    
                    </li>

                    <li class="nav-item">
                        <?php 
                            if (isset($_SESSION['login'])) {
                                echo '<a href="./dashboard" class="nav-link">Dashboard</a>';
                            }  
                        ?>                    
                    </li>
                    <li class="nav-item">
                        <?php 
                            if (isset($_SESSION['login'])) {
                                echo '<a href="./logout" class="nav-link">Logout</a>';
                            }  
                        ?>                    
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Close Navbar -->

    <!-- Container -->
    <div class="container">
        <div class="row my-2">
            <div class="col-md">
                <h3 class="text-center fw-bold text-uppercase">Data Siswa Sekolahku</h3>
                <hr>
            </div>
        </div>
        <div class="col-md">
            </div>
        <div class="row my-2">
            <div class="col-md">
                <a href="./siswa" class="btn btn-primary" role="button">Add Data</a>
            </div>
           
        </div>
        <div class="row my-3">
            <div class="col-md">
                <table id="data" class="table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Year</th>
                            <th>Quote</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($students as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['kode']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['class']; ?></td>
                                <td><?= $row['year']; ?></td>
                                <td class="w-25"><?= $row['quote']; ?></td>
                                <td>
                                    <a href="./siswa/ubah.php?kode=<?= $row['kode']; ?>" class="btn btn-warning btn-sm" style="font-weight: 600;"><i class="bi bi-pencil-square"></i>&nbsp;Ubah</a> |

                                    <a href="./siswa/hapus.php?kode=<?= $row['kode']; ?>" class="btn btn-danger btn-sm" style="font-weight: 600;" onclick="return confirm('Apakah anda yakin ingin menghapus data <?= $row['name']; ?> ?');"><i class="bi bi-trash-fill"></i>&nbsp;Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="container">
    <div class="row my-3">
            <div class="col-md">
                <table id="data-ku" class="custom-font table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>id_schedule</th>
                            <th>Class</th>
                            <th>Hari</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Mata Pelajaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($schedule as $data): ?>
                                <tr>
                                    <td><?= $data['id_schedule']; ?></td>
                                    <td><?= $data['class_name']; ?></td>
                                    <td><?= $data['day']; ?></td>
                                    <td><?= $data['start_time']; ?></td>
                                    <td><?= $data['end_time']; ?></td>
                                    <td><?= $data['subject_name']; ?></td>
                                    <td>
                                    <a href="./schedule/ubah.php?id_schedule=<?= $data['id_schedule']; ?>" class="btn btn-warning btn-sm" style="font-weight: 600;"><i class="bi bi-pencil-square"></i>&nbsp;Ubah</a> |

                                    <a href="./schedule/hapus.php?id_schedule=<?= $data['id_schedule']; ?>" class="btn btn-danger btn-sm" style="font-weight: 600;" onclick="return confirm('Apakah anda yakin ingin menghapus data dengan id <?= $data['id_schedule']; ?> ?');"><i class="bi bi-trash-fill"></i>&nbsp;Hapus</a>
                                </td>
                                </tr>
                            <?php endforeach; ?>
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
            $('#data-ku').DataTable();
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