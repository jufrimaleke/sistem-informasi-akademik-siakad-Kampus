<?php 
include "../../../../config/fungsi.php";
if (isset($_POST["tambah"])) {
    $nama_pembaran     = $_POST['nama_pembaran'];
    $keterangan        = $_POST['keterangan'];
   
    
    $query = mysqli_query($conn, "INSERT INTO nama_pembayaran VALUES ('', '$nama_pembaran','$keterangan')");

    if ($query) {
        echo "<script>
                    alert('Data berhasil ditambahkan.');
                    window.history.back();
                </script>";
    } else {
        echo ("error " . mysqli_error($conn));
        die;
        echo "<script>
                    alert('Data gagal ditambahkan.');
                    window.history.back();
                </script>";
    }
}
