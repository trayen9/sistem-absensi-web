<?php
include "../config.php";

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak");
}

$nim = $_POST['nim'];
$nama = $_POST['nama'];

mysqli_query($koneksi, "
    INSERT INTO mahasiswa (nim, nama_mahasiswa)
    VALUES ('$nim', '$nama')
");

header("Location: index.php");
