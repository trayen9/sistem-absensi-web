<?php
include "../config.php";


/* Data kelas */
$kelas = mysqli_query($koneksi, "SELECT * FROM kelas LIMIT 1");
$data_kelas = mysqli_fetch_assoc($kelas);

/* Statistik */
$total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mahasiswa"));
$hadir = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absensi WHERE status='Hadir'"));
$izin  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absensi WHERE status='Izin'"));
$sakit = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absensi WHERE status='Sakit'"));
$alpha = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absensi WHERE status='Alpha'"));

/* Data mahasiswa + absensi */
$data = mysqli_query($koneksi, "
    SELECT mahasiswa.nim, mahasiswa.nama_mahasiswa, absensi.status
    FROM mahasiswa
    LEFT JOIN absensi ON mahasiswa.nim = absensi.nim
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Absensi Mahasiswa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">

        <div class="header">
            <h1>📚 Sistem Absensi Mahasiswa</h1>
            <p>Universitas Pasundan - Semester Genap</p>
        </div>

        <div class="info-section">
            <div class="info-card">
                <label>Kelas</label>
                <p><?= $data_kelas['nama_kelas']; ?></p>
            </div>
            <div class="info-card">
                <label>Mata Kuliah</label>
                <p><?= $data_kelas['mata_kuliah']; ?></p>
            </div>
            <div class="info-card">
                <label>Dosen Pengampu</label>
                <p><?= $data_kelas['dosen']; ?></p>
            </div>
            <div class="info-card">
                <label>Waktu Perkuliahan</label>
                <p><?= $data_kelas['waktu_kuliah']; ?></p>
            </div>
        </div>

        <h2 class="section-title">Statistik Kehadiran</h2>
        <div class="stats">
            <div class="stat-card">
                <h3><?= $total ?></h3>
                <p>Total</p>
            </div>
            <div class="stat-card">
                <h3><?= $hadir ?></h3>
                <p>Hadir</p>
            </div>
            <div class="stat-card">
                <h3><?= $izin ?></h3>
                <p>Izin</p>
            </div>
            <div class="stat-card">
                <h3><?= $sakit ?></h3>
                <p>Sakit</p>
            </div>
            <div class="stat-card">
                <h3><?= $alpha ?></h3>
                <p>Alpha</p>
            </div>
        </div>


        <h2 class="section-title">Tambah Mahasiswa</h2>
        <form action="tambah_mahasiswa.php" method="post">
            <input type="text" name="nim" placeholder="NIM" required>
            <input type="text" name="nama" placeholder="Nama Mahasiswa" required>
            <button type="submit" class="btn-simpan">Tambah</button>
        </form>



        <h2 class="section-title">Daftar Kehadiran Mahasiswa</h2>

        <form action="simpan_absen.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($data)) {
                        $status = $row['status'];
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nim']; ?></td>
                            <td><?= $row['nama_mahasiswa']; ?></td>
                            <td>
                                <div class="radio-group">
                                    <?php
                                    $opsi = [
                                        'Hadir' => 'H',
                                        'Izin'  => 'I',
                                        'Alpha' => 'A',
                                        'Sakit' => 'S'
                                    ];
                                    foreach ($opsi as $key => $label) {
                                        $checked = ($status == $key) ? 'checked' : '';
                                    ?>
                                        <label class="radio-btn">
                                            <input type="radio"
                                                name="status[<?= $row['nim']; ?>]"
                                                value="<?= $key; ?>"
                                                <?= $checked; ?>>
                                            <span><?= $label; ?></span>
                                        </label>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" class="btn-simpan">Simpan Absensi</button>
        </form>

    </div>
</body>

</html>