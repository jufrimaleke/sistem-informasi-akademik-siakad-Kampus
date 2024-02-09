<?php
$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

// Menggunakan intval untuk memastikan nilai dari $_GET['id_set'] adalah integer
$id_set = intval($_GET['id_set']);
$id_set = mysqli_real_escape_string($conn, $id_set);  // Menggunakan $id_set yang sudah di-cast sebagai integer
$nilai = 1;



$query_update = mysqli_prepare($conn, "UPDATE set_pembayaran SET approved = ? WHERE id_set = ?");
mysqli_stmt_bind_param($query_update, "si", $nilai, $id_set);  // Menggunakan "si" untuk ENUM
mysqli_stmt_execute($query_update);

if ($query_update) {
    mysqli_commit($conn);
    echo "<script>
            alert('Berhasil diapprove');
            window.history.back();
          </script>";
} else {
    echo "gagal" . mysqli_error($conn);
}

mysqli_close($conn);
?>
