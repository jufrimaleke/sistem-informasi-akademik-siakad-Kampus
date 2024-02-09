<?php

$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

// Mendapatkan nilai dari formulir
if (isset($_POST['tambah_setPembayaranPerMhs'])) {

    $tahunAkademik          = mysqli_real_escape_string($conn, $_POST['tahunAkademik']);
    $id_jenisPembayaran     = mysqli_real_escape_string($conn, $_POST['id_jenisPembayaran']);
    $tipe                   = mysqli_real_escape_string($conn, $_POST['tipe']);
    $jumlah_pembayaran      = mysqli_real_escape_string($conn, $_POST['jumlah_pembayaran']);
    $nim_mhs                = mysqli_real_escape_string($conn, $_POST['nim_mhs']);

    $query_ceknim = mysqli_query($conn, "SELECT set_pembayaran.nim, set_pembayaran.id_jenisPembayaran, set_pembayaran.id_semester FROM set_pembayaran WHERE set_pembayaran.nim = '$nim_mhs' AND set_pembayaran.id_jenisPembayaran = '$id_jenisPembayaran' AND set_pembayaran.id_semester = '$tahunAkademik'");

    if (mysqli_num_rows($query_ceknim) == 0) {

        $query_insert = mysqli_query($conn, "INSERT INTO set_pembayaran (nim, id_jenisPembayaran, id_semester, jumlah_bayar, payment_tipe) VALUES (
                  '$nim_mhs',
                  '$id_jenisPembayaran',
                  '$tahunAkademik',
                  '$jumlah_pembayaran',
                  '$tipe')");
        echo "<script>
                alert('Mahasiswa berhasil diset');
                window.history.back();
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Gagal diset, Mahasiswa sudah ada');
                window.history.back();
              </script>";
        exit;
    }
}


?>
