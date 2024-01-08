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

$kode = $_GET['kode'];

// Retrieve the student data using the provided $kode
$students = query("SELECT * FROM students WHERE kode = '$kode'")[0];

// Check if the logged-in user has the permission to edit this data
if ($_SESSION['kode'] !== $kode) {
    header('location: ./');
    exit;
}

// Jika fungsi ubah ljika data terubah, maka munculkan alert dibawah
if (isset($_POST['ubah'])) {
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data siswa berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
    } else {
        // Jika fungsi ubah jika data tidak terubah, maka munculkan alert dibawah
        echo "<script>
                alert('Data mahasiswa gagal diubah!');
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

    <title>SekolahKu</title>
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
                <h3 class="fw-bold text-uppercase"><i class="bi bi-pencil-square"></i>&nbsp;Ubah Data Mahasiswa</h3>
            </div>
            <hr>
        </div>
        <div class="row my-2">
            <div class="col-md">
                <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="kode" class="form-label">Kode</label>
                    <input type="text" class="form-control w-50" id="kode" value="<?= $students['kode']; ?>" name="kode" readonly>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control w-50" id="name" value="<?= $students['name'];  ?>" name="name" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="class" class="form-label">Class</label>
                    <select class="form-select w-50" id="class" name="class" autocomplete="off" required>
                        <?php
                        $selectedClass = $students['class']; // Mengambil nilai kelas yang dipilih sebelumnya

                        // Daftar opsi kelas sesuai dengan kriteria
                        $classOptions = array(
                            "X Science 1", "X Science 2", "X Science 3", "X Science 4", "X Science 5", "X Science 6",
                            "X Social 7", "X Social 8", "X Social 9", "X Social 10",
                            
                            "XI Science 1", "XI Science 2", "XI Science 3", "XI Science 4", "XI Science 5", "XI Science 6",
                            "XI Social 7", "XI Social 8", "XI Social 9", "XI Social 10",
                            
                            "XII Science 1", "XII Science 2", "XII Science 3", "XII Science 4", "XII Science 5", "XII Science 6",
                            "XII Social 7", "XII Social 8", "XII Social 9", "XII Social 10"
                        );

                        // Membuat opsi untuk setiap kelas
                        foreach ($classOptions as $option) {
                            $isSelected = ($option == $selectedClass) ? 'selected' : '';
                            echo "<option value='$option' $isSelected>$option</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="year" class="form-label">Year Started</label>
                    <input type="text" class="form-control w-50" id="year" value="<?= $students['year'];  ?>" name="year" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control w-50" id="email" value="<?= $students['email'];  ?>" name="email" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control w-50" id="address" name="address" rows="3" required><?= $students['address']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="username_student" class="form-label">Username Students</label>
                    <input type="text" class="form-control w-50" id="username_student" value="<?= $students['username_student'];  ?>" name="username_student" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Birth Date</label>
                    <input type="date" class="form-control w-50" id="birth_date" value="<?= $students['birth_date'];  ?>" name="birth_date" required>
                </div>
                <div class="mb-3">
                    <label for="quote" class="form-label">Quote</label>
                    <input type="text" class="form-control w-50" id="quote" value="<?= $students['quote'];  ?>" name="quote" autocomplete="off" required>
                </div>
                    <hr>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-warning" name="ubah">Modify</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Close Container -->

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>