<?php

require 'config.php';




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

// Memanggil atau membutuhkan file function.php

// Menampilkan semua data dari table mahasiswa berdasarkan nim secara Descending
$siswa = query("SELECT * FROM students ORDER BY kode DESC");
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

<style>
    .custom-font td {
        padding-right: 32px;
    }
</style>

<body>
  </div>
</div>
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
                        <a class="nav-link" aria-current="page" href="./">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <?php 
                           session_start();                           
                            if (!isset($_SESSION['login'])) {
                                echo '<a href="login.php" class="nav-link">Login</a>';
                            } else {
                                echo '<a href="user" class="nav-link">' . $_SESSION["login"] . '</a>';
                            }      
                        ?>                    
                    </li>

                    <?php 

                    if (isset($_SESSION['login']) && $_SESSION['role'] == 'admin') {
                        echo "<li class='nav-item'> <a class='nav-link' href='./dashboard'>Dashboard</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Close Navbar -->


<div class="container m-auto">
    <div class="row my-1">
        <div class="col-md p-0">
            <h3 class="text-center fw-bold text-uppercase mt-3 mb-3">Pusat Informasi</h3>
            <hr>
        </div>
    </div>

</div>



<div class="container">

    <div class="row my-3">
            <div class="col-md">
            <h3 class="text-left fw-bold text-capitalize mt-2 mb-2">Jadwal Sekolah</h3>
                <table id="data-schedule" class="custom-font table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>Class</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Subject</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($newData)): ?>
                            <?php foreach ($newData as $data): ?>
                                <tr>
                                    <td><?= $data['class_name']; ?></td>
                                    <td><?= $data['day']; ?></td>
                                    <td>
                                        <?= date('H:i', strtotime($data['start_time'])); ?> -
                                        <?= date('H:i', strtotime($data['end_time'])); ?>
                                    </td>
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
</div>

<div class="container">

    <div class="row my-3">
            <div class="col-md">
            <h3 class="text-left fw-bold text-capitalize mt-2 mb-2">Weekly Activities</h3>
                <table id="school-event" class="custom-font table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Activy</th>
                            <th>Time</th>
                            <th>Day</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>Gate Opened</td>
                            <td>4:50 - 6:45</td>
                            <td>Monday - Friday</td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Flag Ceremony</td>
                            <td>6:50 - 7:15</td>
                            <td>Monday</td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Games & Announcement</td>
                            <td>6:50 - 7:20</td>
                            <td>Tuesday</td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>Career Education</td>
                            <td>7:30 - 14.00</td>
                            <td>Monday - Thursday</td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>Religious Activities</td>
                            <td>6:50 - 7.45</td>
                            <td>Friday</td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>Physical Study & Games</td>
                            <td>8:15 - 10.30</td>
                            <td>Friday</td>
                        </tr>

                        <tr>
                            <td>7</td>
                            <td>Study Intensive & Counseling</td>
                            <td>9:00 - 11.40</td>
                            <td>Friday</td>
                        </tr>

                        <tr>
                            <td>8 </td>
                            <td>Study Intensive & Club</td>
                            <td>13:00 - 15.00</td>
                            <td>Friday</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
                        </div>
    <div class="container">
       
        <div class="row my-3">
            <div class="col-md">
            <h3 class="text-left fw-bold text-capitalize mt-2 mb-2">Data Siswa</h3>
                <table id="data" class="custom-font table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Year</th>
                            <th>Quote</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($siswa as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['kode']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['class']; ?></td>
                                <td><?= $row['year']; ?></td>
                                <td class="w-50"><?= $row['quote']; ?></td>
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
            $('#data-schedule').DataTable();
            $('#school-event').DataTable();
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