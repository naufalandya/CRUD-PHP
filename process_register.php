<?php

require 'config.php';

$name = $_POST['name'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$role = 'siswa';

function shuffleStringBasedOnDateAndVariables($A, $B) {
    $todayDate = date('Ymd');
    $inputString = $todayDate . $A . $B;
    $charArray = str_split($inputString);
    $length = count($charArray);
    for ($i = $length - 1; $i > 0; $i--) {
        $j = mt_rand(0, $i);
        $temp = $charArray[$i];
        $charArray[$i] = $charArray[$j];
        $charArray[$j] = $temp;
    }
    $shuffledString = implode('', $charArray);
    $resultString = substr($shuffledString, 0, 8);
    return str_replace(' ', '', $resultString);
}

function isKodeExists($koneksi, $kode) {
    $result = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM students WHERE kode = '$kode'");
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

do {
    $kode = shuffleStringBasedOnDateAndVariables($name, $password);
} while (isKodeExists($koneksi, $kode));

// Pengecekan kelengkapan data
if (empty($username) || empty($password)) {
    header("location: register.php");
} else {
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);

    mysqli_query($koneksi, "INSERT INTO accounts(username, password, role, student_kode) VALUES ('$username', '$password', '$role', '$kode')");

    mysqli_query($koneksi, "INSERT INTO students (name, kode, class, year, email, address, username_student, birth_date, quote)
        VALUES ('$name', '$kode', 'Your Class', 'Your Year', 'siswa@example.com', 'Student Address', '$username', 'Your Birth Date', 'Your quote')");

    echo "<script>
    alert('Akun anda berhasil registrasi!');
    document.location.href = 'login.php';
    </script>";
}
