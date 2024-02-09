<?php
include "../../../../config/fungsi.php";

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['tambah'])) {
    $nama_pengumuman = mysqli_real_escape_string($conn, $_POST['nama_pengumuman']);
    $jenis_pengumuman = mysqli_real_escape_string($conn, $_POST['jenis_pengumuman']);
    $tujuan_pengumuman = mysqli_real_escape_string($conn, $_POST['tujuan_pengumuman']);
    $isi_pengumuman = mysqli_real_escape_string($conn, $_POST['isi_pengumuman']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // Mendapatkan status aktif saat ini
    $query_active = mysqli_query($conn, "SELECT id_pengumuman,status_post FROM pengumuman WHERE status_post = '1'");
    $active_row = mysqli_fetch_assoc($query_active);
    $id_active = $active_row['id_pengumuman'];

    // Mengubah status aktif menjadi nonaktif jika ada pengumuman aktif
    if (!empty($id_active)) {
        $query_update = mysqli_query($conn, "UPDATE pengumuman SET status_post = '0' WHERE id_pengumuman = $id_active");
    }

    // Menambahkan pengumuman baru dengan status aktif
    $new_status = 1; // Status aktif
    $query_insert = mysqli_query($conn, "INSERT INTO pengumuman 
        VALUES (
            '',
            '$nama_pengumuman',
            '$jenis_pengumuman', 
            '$tujuan_pengumuman', 
            '$isi_pengumuman',
            '$new_status',
            '$date')");

    if ($query_insert) {
        echo "<script>
                alert('Data BERHASIL ditambahkan: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    } else {
        echo "<script>
                alert('Data GAGAL ditambahkan: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }
}

mysqli_close($conn); // Tutup koneksi setelah selesai
?>
