
<?php

$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");


if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$id_pengumuman = $_GET['id_pengumuman'];
$status = 0;

$query_update = mysqli_query($conn, "UPDATE pengumuman SET
            status_post = '$status'
            WHERE id_pengumuman = $id_pengumuman");

if ($query_update) {
    echo "<script>
                alert('Berhasil dinonaktifkan');
                window.history.back();
          </script>";
} else {
    echo "Gagal: " . mysqli_error($conn);
}

mysqli_close($conn); // Tutup koneksi setelah selesai
?>
