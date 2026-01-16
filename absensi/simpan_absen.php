<?php
include "../config.php";

if (isset($_POST['status'])) {
    foreach ($_POST['status'] as $nim => $status) {
        mysqli_query($koneksi, "
            INSERT INTO absensi (nim, status)
            VALUES ('$nim', '$status')
            ON DUPLICATE KEY UPDATE status='$status'
        ");
    }
}

header("Location: index.php");
