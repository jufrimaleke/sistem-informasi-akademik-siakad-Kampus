<?php

$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");


// Mendapatkan nilai dari formulir
if (isset($_POST['ubah_setpembayaran'])) {
    $tahunAkademik          = mysqli_real_escape_string($conn, $_POST['tahunAkademik']);
    $id_jenisPembayaran     = mysqli_real_escape_string($conn, $_POST['id_jenisPembayaran']);
    $tipe                   = mysqli_real_escape_string($conn, $_POST['tipe']);
    $jumlah_pembayaran1      = mysqli_real_escape_string($conn, $_POST['jumlah_pembayaran']);
    $id_set                 = mysqli_real_escape_string($conn, $_POST['id_set']);
    $nim                    = mysqli_real_escape_string($conn, $_POST['nim']);


    $jumlah_pembayaran = str_replace(',', '', $jumlah_pembayaran1);


    $query_update = mysqli_query($conn, "UPDATE set_pembayaran SET
                   nim                  = '$nim',
                   id_jenisPembayaran   = '$id_jenisPembayaran',
                   id_semester          = '$tahunAkademik',
                   jumlah_bayar         = '$jumlah_pembayaran',
                   jumlah_yangdibayar   = '',
                   payment_tipe         = '$tipe'
                   WHERE id_set = '$id_set'");

    if ($query_update) {
        echo "<script>
        		alert('Ubah set berhasil');
        		window.history.back();
        		</script>";
    } else {
        echo "<script>alert('Ubah set gagal')
        window.history.back();</script>: " . mysqli_error($conn);
    }
}

?>

