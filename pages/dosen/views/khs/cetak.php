<?php
session_start();
include "../../../../config/koneksi.php";
include "../../../../assets/fpdf/fpdf.php";
$nip = $_SESSION['dosen'];
$id_krs = $_SESSION['id_jadwal'];


$id_semester = $_SESSION['idsemester'];
$smt = mysqli_query($conn,"SELECT nama_semester FROM semester WHERE id_semester = '$id_semester'");
$d = mysqli_fetch_assoc($smt);


$jadwal = mysqli_query($conn, "SELECT * FROM jadwal
        INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
        INNER JOIN dosen ON jadwal.nip = dosen.nip
        INNER JOIN semester ON jadwal.id_semester = semester.id_semester
        INNER JOIN jurusan ON jadwal.id_jurusan = jurusan.id_jurusan
        WHERE jadwal.id_jadwal = $id_krs");

$row = mysqli_fetch_assoc($jadwal);

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

$pdf->Cell(200, 10, 'REKAPITULASI NILAI MAHASISWA', 0, 1, 'C');









// SET IDENTITAS "NAMA, NIM, TAHUN PERIODE"
$pdf->SetFont('Times','',12);
$pdf->Cell(40,5,'Nama dosen',0,0);
$pdf->Cell(3,5,':',0,0);
$pdf->Cell(100,5,$row['nama_dosen'],0,1); // Sesuaikan dengan nilai nama
//nim
$pdf->Cell(40,5,'Nip / Nidn',0,0);
$pdf->Cell(3,5,':',0,0);
$pdf->Cell(10,5,$nip,0,1); // Sesuaikan dengan nilai nim
//tahun akademik
$pdf->Cell(40,5,'T.A',0,0);
$pdf->Cell(3,5,':',0,0);
$pdf->Cell(100,5,$d['nama_semester'],0,1); // semester


//prodi
$pdf->Cell(40,5,'Program Studi',0,0);
$pdf->Cell(3,5,':',0,0);
$pdf->Cell(100,5,$row['nama_jurusan'],0,1); // semester

//prodi
$pdf->Cell(40,5,'Matakuliah',0,0);
$pdf->Cell(3,5,':',0,0);
$pdf->Cell(100,5,$row['nama_mk'],0,1); // semester

// Spasi antara identitas dan detail KRS
$pdf->Cell(10,7,'',0,1);

$pdf->SetFont('Times','B','9');
$pdf->Cell(10,5,'NO.',1,0,'C');
$pdf->Cell(30,5,'NIM',1,0,'C');
$pdf->Cell(100,5,'NAMA',1,0,'C');
$pdf->Cell(20,5,'NILAI_TGS',1,0,'C');
$pdf->Cell(30,5,'NILAI_UTS',1,0,'C');
$pdf->Cell(30,5,'NILAI_UAS',1,0,'C');
$pdf->Cell(30,5,'NILAI_AKHIR',1,0,'C');
$pdf->Cell(30,5,'NILAI_HURUF',1,0,'C');

$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Times','',10);

// Mengambil data KRS


  $khs = mysqli_query($conn, "SELECT * FROM khs
           INNER JOIN jadwal ON khs.id_jadwal = jadwal.id_jadwal
           INNER JOIN mahasiswa ON khs.nim = mahasiswa.nim
           WHERE khs.id_jadwal = $id_krs");

$no = 1;
while ($d = mysqli_fetch_array($khs)) {
    $pdf->Cell(10,5,$no++,1,0,'C');
    $pdf->Cell(30,5,$d['nim'],1,0,'C');
    $pdf->Cell(100,5,$d['nama'],1,0,'C');
    $pdf->Cell(20,5,$d['nilai_tgs'],1,0,'C');
    $pdf->Cell(30,5,$d['nilai_uts'],1,0,'C');
    $pdf->Cell(30,5,$d['nilai_uas'],1,0,'C');
    $pdf->Cell(30,5,$d['nilai_akhir'],1,0,'C');
    $pdf->Cell(30,5,$d['nilai_huruf'],1,0,'C');
    $pdf->Ln();

    
}





$pdf->Cell(10,10,'',0,1);

// Hitung panjang teks
$nama_dosen = $row['nama_dosen'];
$panjang_teks = $pdf->GetStringWidth($nama_dosen);

// Tampilkan teks
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(300, 7, 'Manado, ' . date('d F Y'), 0, 1, 'C');
$pdf->Cell(10, 15, '', 0, 2);

// Set tebal garis
$pdf->SetLineWidth(0.5); // Sesuaikan ketebalan yang Anda inginkan

// Tampilkan teks dengan garis bawah
$pdf->Cell(300, 7, $nama_dosen, 0, 4, 'C');
$pdf->Cell(175, 7, '', 0, 0); // Tambahkan 30 karakter spasi

// Kembalikan ketebalan garis ke nilai awal (jika diperlukan)
$pdf->SetLineWidth(0.2);











// $nama_dosen = 'DIRGHA RAHAYU ANUGERAH KAUNANG';



$pdf->Output();



?>
