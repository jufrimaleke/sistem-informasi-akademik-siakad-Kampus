<?php
$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");
// $conn  = mysqli_connect("localhost","stiz4159_Adminsiakad","Siakadstie@56","stiz4159_siakad");

// Validasi parameter
if (isset($_GET['id_histori']) && isset($_GET['id_set']) && isset($_GET['return'])) {
    $id_histori = intval($_GET['id_histori']);
    $id_set = intval($_GET['id_set']);
    $return = mysqli_real_escape_string($conn, $_GET['return']);
} else {
    // Handle jika parameter tidak lengkap
    echo "Parameter tidak lengkap.";
    exit();
}

// Gunakan prepared statements untuk SELECT
$query_select = mysqli_prepare($conn, "SELECT * FROM histori_transaksi WHERE id_histori = ?");
mysqli_stmt_bind_param($query_select, "i", $id_histori);
mysqli_stmt_execute($query_select);
$result_select = mysqli_stmt_get_result($query_select);

// Validasi hasil query SELECT
if ($result_select) {
    $data = mysqli_fetch_assoc($result_select);

    // Ambil jumlah yang dibayar dari histori_transaksi
    $jumlah_histori_yang_dibayar = $data['jumlah_historiyangdibayar'];

    // Gunakan prepared statements untuk UPDATE set_pembayaran
    $query_update_set = mysqli_prepare($conn, "UPDATE set_pembayaran SET jumlah_yangdibayar = jumlah_yangdibayar - ? WHERE id_set = ?");
    
    // Periksa apakah prepared statement berhasil dibuat
    if ($query_update_set) {
        mysqli_stmt_bind_param($query_update_set, "ii", $jumlah_histori_yang_dibayar, $id_set);
        $result_update_set = mysqli_stmt_execute($query_update_set);
    } else {
        $result_update_set = false;
    }

    // Gunakan prepared statements untuk UPDATE histori_transaksi
    $query_update_histori = mysqli_prepare($conn, "UPDATE histori_transaksi SET `return` = ? WHERE id_histori = ?");
    
    // Periksa apakah prepared statement berhasil dibuat
    if ($query_update_histori) {
        mysqli_stmt_bind_param($query_update_histori, "ii", $return, $id_histori);
        $result_update_histori = mysqli_stmt_execute($query_update_histori);
    } else {
        $result_update_histori = false;
    }

    // Periksa hasil query UPDATE
    if ($result_update_set && $result_update_histori) {
        echo "<script>alert('Return berhasil'); window.history.back();</script>";
    } else {
        // Handle jika query UPDATE gagal
        echo "Gagal melakukan pembayaran.";
    }
} else {
    // Handle jika query SELECT gagal
    echo "Query SELECT gagal.";
}

// Tutup koneksi
mysqli_close($conn);
?>
