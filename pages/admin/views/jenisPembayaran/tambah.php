<?php
include "../../../../config/fungsi.php";

if (isset($_POST["tambah_jenis"])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $semester = $_POST['semester'];
    $tipe = $_POST['tipe'];
    $biaya = $_POST['biaya'];
    $deadline = $_POST['deadline']; // Ambil nilai waktu deadline

    // Hapus karakter selain angka dan titik desimal
    $clean_biaya = preg_replace("/[^0-9.]/", "", $biaya);

    $query = mysqli_query($conn, "INSERT INTO jenis_pembayaran VALUES (
        '', 
        '$id_pembayaran',
        '$semester',
        '$deadline',
        '$tipe',
         '$clean_biaya')"); // Sertakan nilai waktu deadline dalam query

    if ($query) {
        echo "<script>
                    alert('Data berhasil ditambahkan.');
                    window.history.back();
                </script>";
    } else {
        echo ("<p>Error: " . mysqli_error($conn) . "</p>");
        die;
        echo "<script>
                    alert('Data gagal ditambahkan.');
                    window.history.back();
                </script>";
    }
}
?>
