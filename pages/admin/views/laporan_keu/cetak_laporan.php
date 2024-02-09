<?php
include "../../../../config/koneksi.php";
include "../../../../assets/fpdf/fpdf.php";
session_start();
$id_semester = $_GET['id_laporan'];


$query_lap = mysqli_query($conn, "SELECT 
        set_pembayaran.id_set,
        set_pembayaran.nim,
        set_pembayaran.id_jenisPembayaran,
        set_pembayaran.id_semester,
        set_pembayaran.jumlah_bayar,
        set_pembayaran.jumlah_yangdibayar,
        set_pembayaran.payment_tipe,
        jenis_pembayaran.id_jenisPembayaran,
        jenis_pembayaran.id_pembayaran,
        nama_pembayaran.id_pembayaran,
        nama_pembayaran.nama_pembayaran,
        mahasiswa.nama,
        mahasiswa.id_jurusan,
        jurusan.id_jurusan,
        jurusan.nama_jurusan,
        semester.id_semester,
        semester.nama_semester
        FROM set_pembayaran
        INNER JOIN mahasiswa ON set_pembayaran.nim = mahasiswa.nim 
        INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
        INNER JOIN jenis_pembayaran ON set_pembayaran.id_jenisPembayaran = jenis_pembayaran.id_jenisPembayaran 
        INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran
        INNER JOIN semester ON set_pembayaran.id_semester = semester.id_semester
        WHERE set_pembayaran.id_semester = $id_semester");

$data = mysqli_fetch_assoc($query_lap);



$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();


$lebar_halaman = 210; // Ganti dengan lebar halaman sesuai kebutuhan Anda
$lebar_gambar = 130;  // Ganti dengan lebar gambar sesuai kebutuhan Anda
$tinggi_gambar = 20; // Ganti dengan tinggi gambar sesuai kebutuhan Anda

$posisi_x = ($lebar_halaman - $lebar_gambar) / 2;

$pdf->Image('../../../../assets/img/logobaru.jpeg', $posisi_x, 8, $lebar_gambar, $tinggi_gambar);

// Set font dan ukuran untuk tulisan selanjutnya
$pdf->SetFont('Times','B',12);

// Menggeser posisi y ke bawah agar berada di bawah gambar
$posisi_y = 8 + $tinggi_gambar + 2; // Sesuaikan jarak sesuai kebutuhan

$pdf->SetXY($posisi_x, $posisi_y);

$pdf->Cell(140, 2, '', 'T', 1, 'l'); // 'T' adalah opsi untuk garis bawah

$pdf->Cell(200, 10, 'LAPORAN KEUANGAN MAHASISWA SEMESTER', 0, 1, 'C');
$pdf->Cell(200, 10, $data['nama_semester'], 0, 1, 'C');




// SET IDENTITAS "NAMA, NIM, TAHUN PERIODE"
$pdf->SetFont('Times','',12);

// Spasi antara identitas dan detail KRS
$pdf->Cell(10,7,'',0,1);

$pdf->SetFont('Times','B','9');
$pdf->Cell(8,5,'NO.',1,0,'C');
$pdf->Cell(20,5,'NIM',1,0,'C');
$pdf->Cell(75,5,'NAMA',1,0,'C');
$pdf->Cell(25,5,'TAGIHAN',1,0,'C');
$pdf->Cell(28,5,'PEMBAYARAN',1,0,'C');
$pdf->Cell(35,5,'SISA PEMBAYARAN',1,0,'C');

$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Times','',10);

// Mengambil data KRS
$query_lap = mysqli_query($conn, "SELECT 
        set_pembayaran.id_set,
        set_pembayaran.nim,
        set_pembayaran.id_jenisPembayaran,
        set_pembayaran.id_semester,
        set_pembayaran.jumlah_bayar,
        set_pembayaran.jumlah_yangdibayar,
        set_pembayaran.payment_tipe,
        jenis_pembayaran.id_jenisPembayaran,
        jenis_pembayaran.id_pembayaran,
        nama_pembayaran.id_pembayaran,
        nama_pembayaran.nama_pembayaran,
        mahasiswa.nama,
        mahasiswa.id_jurusan,
        jurusan.id_jurusan,
        jurusan.nama_jurusan,
        semester.id_semester,
        semester.nama_semester
        FROM set_pembayaran
        INNER JOIN mahasiswa ON set_pembayaran.nim = mahasiswa.nim 
        INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
        INNER JOIN jenis_pembayaran ON set_pembayaran.id_jenisPembayaran = jenis_pembayaran.id_jenisPembayaran 
        INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran
        INNER JOIN semester ON set_pembayaran.id_semester = semester.id_semester
        WHERE set_pembayaran.id_semester = $id_semester");

$query = "SELECT SUM(jumlah_bayar) as total_bayar, SUM(jumlah_yangdibayar) as total_terbayar FROM set_pembayaran WHERE id_semester = $id_semester";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil dijalankan
if (!$result) {
    die("Error dalam query: " . mysqli_error($conn));
}

// Ambil nilai dari hasil query
$row = mysqli_fetch_assoc($result);

// Ambil nilai total pembayaran
$total_bayar = $row['total_bayar'];
$total_terbayar = $row['total_terbayar'];


$total_sisa_bayar = $total_bayar - $total_terbayar;
// Tutup koneksi
mysqli_close($conn);





$no = 1;
while ($data = mysqli_fetch_assoc($query_lap)) {
    

$pdf->Cell(8,5,$no++,1,0,'C');
$pdf->Cell(20,5,$data['nim'],1,0,'C');
$pdf->Cell(75,5,$data['nama'],1,0,'C');
$pdf->Cell(25,5,'Rp. '.number_format($data['jumlah_bayar']),1,0,'C');
$pdf->Cell(28,5,'Rp. '.number_format($data['jumlah_yangdibayar']),1,0,'C');
$total = $data['jumlah_bayar'] - $data['jumlah_yangdibayar'];
$pdf->Cell(35,5,'Rp. '.number_format($total),1,0,'C');

$pdf->Ln();

}


$pdf->SetFont('Times','B','9');

$pdf->Cell(103,8,'TOTAL',1,0,'C');
$pdf->Cell(25,8,'Rp. '. number_format($total_bayar),1,0,'C'); 
$pdf->Cell(28,8,'Rp. '.number_format($total_terbayar),1,0,'C');
$pdf->Cell(35,8,'Rp. '.number_format($total_sisa_bayar),1,0,'C');   






$pdf->Cell(10,10,'',0,1);



// Tampilkan teks
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(300, 7, 'Manado, ' . date('d F Y'), 0, 1, 'C');
$pdf->Cell(10, 15, '', 0, 2);

// Set tebal garis
$pdf->SetLineWidth(0.5); // Sesuaikan ketebalan yang Anda inginkan

// Tampilkan teks dengan garis bawah
$pdf->Cell(300, 7, 'Admin Keu', 0, 4, 'C');
$pdf->Cell(175, 7, '', 0, 0); // Tambahkan 30 karakter spasi

// Kembalikan ketebalan garis ke nilai awal (jika diperlukan)
$pdf->SetLineWidth(0.2);











// $nama_dosen = 'DIRGHA RAHAYU ANUGERAH KAUNANG';



$pdf->Output();



?>
