<?php
session_start();

// Memanggil atau membutuhkan file function.php
require 'function.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>
                window.alert('Anda bukan admin!');
                document.location.href = '../index.php';
            </script>";
    exit;
}

$result = mysqli_query($koneksi, "SELECT * FROM schedule_view");
$newData = mysqli_fetch_assoc($result);

// Check if the query was successful
if ($result) {
    // Fetch all rows as an associative array
    $newData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $newData[] = $row;
    }

} else {
    echo "Query failed: " . mysqli_error($koneksi);
}

if (isset($_POST['simpan'])) {
    if (tambah($_POST)) {
        // Setelah penyisipan data, ambil data yang baru ditambahkan dari tabel schedule
       
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
</style>

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
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
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
                <h3 class="fw-bold text-uppercase"><i class="bi bi-person-plus-fill"></i>&nbsp;Tambah Jadwal</h3>
            </div>
            <hr>
        </div>
        <div class="row my-2">
            <div class="col-md">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="id_class" class="form-label">ID Kelas</label>
                        <input type="number" class="form-control w-50" id="id_class" placeholder="Masukkan ID Kelas" min="1" name="id_class" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="day" class="form-label">Hari</label>
                        <input type="text" class="form-control form-control-md w-50" id="day" placeholder="Masukkan Hari" name="day" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Waktu Mulai</label>
                        <select class="form-select w-50" id="start_time" name="start_time" required>
                            <option value="07:30:00">07:30:00</option>
                            <option value="09:50:00">09:50:00</option>
                            <option value="12:10:00">12:10:00</option>
                            <!-- Tambahkan opsi jam lainnya sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">Waktu Selesai</label>
                        <select class="form-select w-50" id="end_time" name="end_time" required>
                            <option value="09:30:00">09:30:00</option>
                            <option value="11:50:00">11:50:00</option>
                            <option value="14:10:00">14:10:00</option>
                            <!-- Tambahkan opsi jam lainnya sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_subject" class="form-label">ID Mata Pelajaran</label>
                        <input type="number" class="form-control w-50" id="id_subject" placeholder="Masukkan ID Mata Pelajaran" min="1" name="id_subject" autocomplete="off" required>
                    </div>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </form>

            </div>
        </div>
    </div>
    <!-- Close Container -->


<div class="container">
    <div class="row my-3">
            <div class="col-md">
                <table id="data" class="custom-font table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>Class</th>
                            <th>Hari</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Mata Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($newData)): ?>
                            <?php foreach ($newData as $data): ?>
                                <tr>
                                    <td><?= $data['class_name']; ?></td>
                                    <td><?= $data['day']; ?></td>
                                    <td><?= $data['start_time']; ?></td>
                                    <td><?= $data['end_time']; ?></td>
                                    <td><?= $data['subject_name']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



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