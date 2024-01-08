<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();
// Session dihapus dan logout

header('location: ./');
    // kembali ke index.php