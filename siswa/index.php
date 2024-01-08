<?php
session_start();
// Jika tidak bisa login maka balik ke login.php
// jika masuk ke halaman ini melalui url, maka langsung menuju halaman login
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>
                window.alert('Anda bukan admin!');
                document.location.href = '../index.php';
            </script>";
    exit;
}

// Memanggil atau membutuhkan file function.php
require 'function.php';

// Jika fungsi tambah jika data tersimpan, maka munculkan alert dibawah
if (isset($_POST['simpan'])) {
    if (tambah($_POST)) {
        echo "<script>
                alert('Data Mahasiswa berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>";
    } else {
        // Jika fungsi tambah jika data tidak tersimpan, maka munculkan alert dibawah
        echo "<script>
                alert('Data Mahasiswa gagal ditambahkan!');
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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <!-- Own CSS -->
    <link rel="stylesheet" href="css/style.css">

    <title>Sekolahku</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
        <div class="container">
            <a class="navbar-brand" href="index.php">Sekolahku</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout">Logout</a>
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
                <h3 class="fw-bold text-uppercase"><i class="bi bi-person-plus-fill"></i>&nbsp;Add Student</h3>
            </div>
            <hr>
        </div>
        <div class="row my-2">
            <div class="col-md">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="kode" class="form-label">Kode</label>
                    <input placeholder="This will be generated automatically" type="text" class="form-control w-50" id="kode" name="kode" readonly>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control w-50" id="name" name="name" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="class" class="form-label">Class</label>
                    <input type="text" class="form-control w-50" id="class" name="class" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Year Started</label>
                    <input type="text" class="form-control w-50" id="year" name="year" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control w-50" id="email" name="email" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control w-50" id="address" name="address" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="username_student" class="form-label">Username Students</label>
                    <input type="text" class="form-control w-50" id="username_student" name="username_student" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Birth Date</label>
                    <input type="date" class="form-control w-50" id="birth_date" name="birth_date" required>
                </div>
                <div class="mb-3">
                    <label for="quote" class="form-label">Quote</label>
                    <input type="text" class="form-control w-50" id="quote" name="quote" autocomplete="off" required>
                </div>
                    <hr>
                    <a href="index.php" class="btn btn-secondary">Return</a>
                    <button type="submit" class="btn btn-warning" name="simpan">Save</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Close Container -->

</body>

</html>