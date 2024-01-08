<?php
// Koneksi Database
$koneksi = mysqli_connect("localhost:3308", "andya", "andya", "db_sekolah");

// membuat fungsi query dalam bentuk array
function query($query)
{
    // Koneksi database
    global $koneksi;

    $result = mysqli_query($koneksi, $query);

    // membuat varibale array
    $rows = [];

    // mengambil semua data dalam bentuk array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data)
{
    global $koneksi;

    $id_class = htmlspecialchars($data['id_class']);
    $day = htmlspecialchars($data['day']);
    $start_time = htmlspecialchars($data['start_time']);
    $end_time = htmlspecialchars($data['end_time']);
    $id_subject = htmlspecialchars($data['id_subject']);

    $sql = "INSERT INTO schedule(id_class, day, start_time, end_time, id_subject) VALUES ('$id_class', '$day', '$start_time', '$end_time', '$id_subject')";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}
function hapus($id)
{
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM schedule WHERE id_schedule = '$id'");
    return mysqli_affected_rows($koneksi);
}

function ubah($data)
{
    global $koneksi;

   // Sanitize and retrieve updated values
    $id_class = htmlspecialchars($data['id_class']);
    $day = htmlspecialchars($data['day']);
    $start_time = htmlspecialchars($data['start_time']);
    $end_time = htmlspecialchars($data['end_time']);
    $id_subject = htmlspecialchars($data['id_subject']);

    // Assuming you have an ID for the schedule, adjust the following line accordingly
    $id = $_GET['id_schedule'];

    $sql = "UPDATE schedule
            SET id_class='$id_class', day='$day', start_time='$start_time', 
                end_time='$end_time', id_subject='$id_subject'
            WHERE id_schedule='$id'";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}

