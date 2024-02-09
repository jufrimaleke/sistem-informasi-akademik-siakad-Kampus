<?php

$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");


// Mendapatkan nilai dari formulir
if (isset($_POST['bayar'])) {
    $transaksi = mysqli_real_escape_string($conn, $_POST['transaksi']);
    $id_set = mysqli_real_escape_string($conn, $_POST['id_set']);
    $d = mysqli_real_escape_string($conn, $_POST['d']);
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $id_tahunAkademik = mysqli_real_escape_string($conn, $_POST['id_tahunAkademik']);

    // Hilangkan tanda koma dari nilai transaksi
    $transaksi = str_replace(',', '', $transaksi);

    // Ambil nilai dari jumlah_yangdibayar dari database
    $query_terbayar = mysqli_query($conn, "SELECT id_jenisPembayaran,jumlah_bayar,jumlah_yangdibayar FROM set_pembayaran WHERE id_set = '$id_set'");
    $data_terbayar = mysqli_fetch_assoc($query_terbayar);

    // Pastikan data yang diambil adalah numerik
    $jumlah_yangdibayar_db = is_numeric($data_terbayar['jumlah_yangdibayar']) ? $data_terbayar['jumlah_yangdibayar'] : 0;

    $jumlah_bayar = is_numeric($data_terbayar['jumlah_bayar']) ? $data_terbayar['jumlah_bayar'] : 0;

    $data_id = $data_terbayar['id_jenisPembayaran'];



    // Hitung total pembayaran
    $total = $jumlah_yangdibayar_db + $transaksi;

    if ($transaksi <= $jumlah_bayar) {
       // Lakukan update ke tabel pertama (set_pembayaran)
        $query_update = mysqli_query($conn, "UPDATE set_pembayaran SET
                       jumlah_yangdibayar   = '$total',
                       update_date_pembayaran = '$d'
                       WHERE id_set = '$id_set'");

        // Lakukan insert ke tabel kedua (histori_transaksi)
        if ($query_update) {
            $query_insert_histori = mysqli_query($conn, "INSERT INTO histori_transaksi (nim, update_date, id_tahunAkademik, jumlah_historiyangdibayar,id_jenisPembayaran,id_set) 
                VALUES ('$nim', '$d', '$id_tahunAkademik','$transaksi','$data_id','$id_set')");
            
            if ($query_insert_histori) {
                echo "<script>
                    alert('Pembayaran berhasil');
                    window.history.back();
                    </script>";
            } else {
                echo "<script>alert('Pembayaran berhasil, tetapi gagal menyimpan ke histori_transaksi')
                    window.history.back();</script>: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('Pembayaran gagal')
                window.history.back();</script>: " . mysqli_error($conn);
        }


    }else{
       echo "<script>alert('Pembayaran gagal. Jumlah pembayaran melebihi batas pembayaran')
                    window.history.back();</script>: " . mysqli_error($conn);
    }


    
}



?>

