<?php

$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

// Mendapatkan nilai dari formulir
$tahunAkademik = $_POST['tahunAkademik'];
$id_jenisPembayaran = $_POST['id_jenisPembayaran'];
$jumlah_pembayaran = $_POST['jumlah_pembayaran'];
$jrs = $_POST['jrs'];
$angkatan = $_POST['angkatan'];
$tipe = $_POST['tipe'];

$jumlah_pembayaran = str_replace(',', '', $jumlah_pembayaran);

// Membuat query untuk mendapatkan nim mahasiswa
$queryMahasiswa = "SELECT nim FROM mahasiswa WHERE id_jurusan = $jrs AND id_angkatan = $angkatan";
$resultMahasiswa = mysqli_query($conn, $queryMahasiswa);

$errorDetected = false;  // Tambahkan variabel untuk melacak apakah terdapat kesalahan

if ($resultMahasiswa) {
    // Mengecek apakah ada baris hasil
    if (mysqli_num_rows($resultMahasiswa) > 0) {
        while ($row = mysqli_fetch_assoc($resultMahasiswa)) {
            // Proses data mahasiswa
            $nim = $row['nim'];
           
            $queryCheckNim = "SELECT nim FROM set_pembayaran WHERE nim = ? AND id_jenisPembayaran = ? AND id_semester = ?";
            $stmtCheckNim = mysqli_prepare($conn, $queryCheckNim);
            mysqli_stmt_bind_param($stmtCheckNim, "iss", $nim, $id_jenisPembayaran, $tahunAkademik);
            mysqli_stmt_execute($stmtCheckNim);
            mysqli_stmt_store_result($stmtCheckNim);

            if (mysqli_stmt_num_rows($stmtCheckNim) == 0) {
                // Nim belum ada di tabel set_pembayaran, maka bisa dimasukkan
                $queryPembayaran = "INSERT INTO set_pembayaran (nim, id_jenisPembayaran, id_semester, jumlah_bayar, payment_tipe) VALUES (?, ?, ?, ?, ?)";
                $stmtPembayaran = mysqli_prepare($conn, $queryPembayaran);
                mysqli_stmt_bind_param($stmtPembayaran, "siiss", $nim, $id_jenisPembayaran, $tahunAkademik, $jumlah_pembayaran, $tipe);
                $resultPembayaran = mysqli_stmt_execute($stmtPembayaran);

                if (!$resultPembayaran) {
                    echo "Gagal mengeksekusi query pembayaran: " . mysqli_error($conn);
                    $errorDetected = true; // Set nilai errorDetected menjadi true
                }
            }
        }
    } else {
        // Tidak ada data yang diambil
        echo "<script>
                alert('Tidak ada data mahasiswa yang diproses!');
                window.history.back();
             </script>"; 
        $errorDetected = true; // Set nilai errorDetected menjadi true
    }
    
    // Tambahkan notifikasi kesalahan jika diperlukan
    if (!$errorDetected) {
        // Menutup koneksi setelah loop selesai
        mysqli_close($conn);

        // Tidak ada kesalahan, tampilkan notifikasi berhasil
        echo "<script>
                alert('Data berhasil diset!');
                window.history.back();
             </script>";
    }
} else {
    echo "Gagal mengambil NIM mahasiswa: " . mysqli_error($conn);
}



 ?>