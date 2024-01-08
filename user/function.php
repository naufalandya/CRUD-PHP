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

// Membuat fungsi tambah
function tambah($data)
{
    global $koneksi;
    $name = htmlspecialchars($data['name']);
    $class = htmlspecialchars($data['class']);
    $year = htmlspecialchars($data['year']);
    $email = htmlspecialchars($data['email']);
    $address = htmlspecialchars($data['address']);
    $username_students = htmlspecialchars($data['username_students']);
    $birth_date = htmlspecialchars($data['birth_date']);
    $kode = htmlspecialchars($data['kode']);
    $quote = htmlspecialchars($data['quote']);
    
    $sql = "INSERT INTO students(name, class, kode, year, email, address, username_students, birth_date, quote) VALUES ('$name',  '$kode',  '$class', '$year', '$email', '$address', '$username_students', '$birth_date','$quote')";
    
    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi hapus
function hapus($kode)
{
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM students WHERE kode = '$kode'");
    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi ubah
function ubah($data)
{
    global $koneksi;
    // Sanitize and retrieve updated values
    $kode = htmlspecialchars($data['kode']);
    $name = htmlspecialchars($data['name']);
    $class = htmlspecialchars($data['class']);
    $year = htmlspecialchars($data['year']);
    $email = htmlspecialchars($data['email']);
    $address = htmlspecialchars($data['address']);
    $username_student = htmlspecialchars($data['username_student']);
    $birth_date = htmlspecialchars($data['birth_date']);
    $quote = htmlspecialchars($data['quote']);

    $sql = "UPDATE students 
            SET name='$name', class='$class', year='$year', email='$email', 
                address='$address', username_student='$username_student', 
                birth_date='$birth_date', quote='$quote'
            WHERE kode='$kode' ";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}

