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

function isUsernameExists($koneksi, $username) {
    $result = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM students WHERE username_student = '$username'");
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

// Membuat fungsi tambah
// Membuat fungsi tambah
function tambah($data)
{
    global $koneksi;
    $name = htmlspecialchars($data['name']);
    $class = htmlspecialchars($data['class']);
    $year = htmlspecialchars($data['year']);
    $email = htmlspecialchars($data['email']);
    $address = htmlspecialchars($data['address']);
    $birth_date = htmlspecialchars($data['birth_date']);
    $password = "newnormal";
    $role = "siswa";

    do {
        $kode = shuffleStringBasedOnDateAndVariables($name, $class);
    } while (isKodeExists($koneksi, $kode));

    do {
        $username_student = shuffleStringBasedOnDateAndVariables($name, $class);
    } while (isUsernameExists($koneksi, $username_student));

    $quote = htmlspecialchars($data['quote']);

    mysqli_query($koneksi, "INSERT INTO accounts(username, password, role, student_kode) VALUES ('$username_student', '$password', '$role', '$kode')");

    // Corrected SQL query
    $sql = "INSERT INTO students(name, class, year, email, address, birth_date, kode, username_student, quote) 
            VALUES ('$name', '$class', '$year', '$email', '$address', '$birth_date', '$kode', '$username_student', '$quote')";

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

