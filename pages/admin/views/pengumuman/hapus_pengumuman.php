<?php



$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");



if (!$conn) {

    die("Koneksi gagal: " . mysqli_connect_error());

}



$id_pengumuman = $_GET['id_pengumuman'];





$query_update = mysqli_query($conn, "DELETE FROM pengumuman

		   WHERE id_pengumuman = $id_pengumuman");



if ($query_update) {

    echo "<script>

                alert('Berhasil dihapus');

                window.history.back();

          </script>";

} else {

    echo "Gagal: " . mysqli_error($conn);

}



mysqli_close($conn); // Tutup koneksi setelah selesai

?>

