<?php
session_start();
// Jika tidak bisa login maka balik ke login.php
// jika masuk ke halaman ini melalui url, maka langsung menuju halaman login
if (!isset($_SESSION['login'])) {
    header('location: ../login.php');
    exit;
}

// Memanggil atau membutuhkan file function.php
require 'function.php';

// Mengambil data dari nim dengan fungsi get
$id = $_GET['id_schedule'];

// Fetch schedule data
$schedule = query("SELECT * FROM schedule WHERE id_schedule = '$id'")[0];

$subjects = query("SELECT * FROM subjects");
$classes = query("SELECT * FROM class");

// Jika fungsi ubah ljika data terubah, maka munculkan alert dibawah
if (isset($_POST['ubah'])) {
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data schedule berhasil diubah!');
                document.location.href = '../dashboard.php';
            </script>";
    } else {
        // Jika fungsi ubah jika data tidak terubah, maka munculkan alert dibawah
        echo "<script>
                alert('Data schedule gagal diubah!');
            </script>";
    }
}


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

    <title>Tambah Data</title>
</head>

<body>
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
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
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
                <h3 class="fw-bold text-uppercase"><i class="bi bi-pencil-square"></i>&nbsp;Modify</h3>
            </div>
            <hr>
        </div>
        <div class="row my-2">
            <div class="col-md">
            <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="id_class" class="form-label">ID Class</label>
                <input type="text" class="form-control w-50" id="id_class" value="<?= $schedule['id_class'];?>" name="id_class" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="day" class="form-label">Day</label>
                <input type="text" class="form-control w-50" id="day" value="<?= $schedule['day'] ?? ''; ?>" name="day" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control w-50" id="start_time" value="<?= $schedule['start_time'] ?? ''; ?>" name="start_time" required>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" class="form-control w-50" id="end_time" value="<?= $schedule['end_time'] ?? ''; ?>" name="end_time" required>
            </div>
            <div class="mb-3">
                <label for="subject_id" class="form-label">Subject Id</label>
                <input type="text" class="form-control w-50" id="subject_id" placeholder="Science : 1 && Social 2" name="id_subject" autocomplete="off" required>
            </div>
                <!-- Add other fields as needed -->

                <!-- Keep the rest of your form as is -->
                <hr>
                <a href="../dashboard" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-warning" name="ubah">Ubah</button>
            </form>`

            </div>
        </div>
    </div>


    <div class="container">
        <h3>Detail Subject</h3>
    <div class="row my-3">
            <div class="col-md">
                <table id="data-subject" class="custom-font table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>id_subjects</th>
                            <th>subject_name</th>
                            <th>id_field</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><?= $subject['id_subject']; ?></td>
                                <td><?= $subject['subject_name']; ?></td>
                                <td><?= $subject['id_field']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <h3>Detail Class</h3>
    <div class="row my-3">
            <div class="col-md">
                <table id="data-class" class="custom-font table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>id_class</th>
                            <th>class name</th>
                            <th>id_field</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($classes as $class): ?>
                            <tr>
                                <td><?= $class['id_class']; ?></td>
                                <td><?= $class['class_name']; ?></td>
                                <td><?= $class['id_field']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Close Container -->

    <!-- Bootstrap -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<!-- Data Tables -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Fungsi Table
        $('#data-subject').DataTable();
        $('#data-class').DataTable();
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