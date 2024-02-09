<?php
session_start();
include "../../../../config/fungsi.php";
include "../../../../assets/fpdf/fpdf.php";
$nim = $_SESSION['mahasiswa'];
$mhs = $_SESSION['nama'];
$id_semester = $_SESSION['idsemester'];



// Mengambil data nama mahasiswa
$dataNama = mysqli_query($conn, "SELECT 
    mahasiswa.nim,
    mahasiswa.nama,
    mahasiswa.nip,
    mahasiswa.id_jurusan,
    mahasiswa.id_angkatan,
    dosen.nama_dosen,
    dosen.nip,
    jurusan.id_jurusan,
    jurusan.nama_jurusan 
    FROM mahasiswa INNER JOIN dosen ON mahasiswa.nip = dosen.nip
    INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan WHERE mahasiswa.nim = '$nim'");
 
$nama = mysqli_fetch_assoc($dataNama);

$kapro = mysqli_query($conn, "SELECT * FROM jurusan INNER JOIN dosen ON jurusan.nip = dosen.nip WHERE jurusan.id_jurusan = {$nama['id_jurusan']}");
$d_kapro = mysqli_fetch_assoc($kapro);

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

$pdf->Cell(200,10,'KARTU RENCANA STUDI ( KRS )',0,1,'C');








// SET IDENTITAS "NAMA, NIM, TAHUN PERIODE"
$pdf->SetFont('Times','',12);
$pdf->Cell(40,7,'Nama',0,0);
$pdf->Cell(3,7,':',0,0);
$pdf->Cell(100,7,$nama['nama'],0,1); // Sesuaikan dengan nilai nama
//nim
$pdf->Cell(40,7,'Nim',0,0);
$pdf->Cell(3,7,':',0,0);
$pdf->Cell(10,7,$nim,0,1); // Sesuaikan dengan nilai nim
//tahun akademik
$pdf->Cell(40,7,'T.A',0,0);
$pdf->Cell(3,7,':',0,0);
$pdf->Cell(100,7,$id_semester,0,1); // semester

//prodi
$pdf->Cell(40,7,'Program Studi',0,0);
$pdf->Cell(3,7,':',0,0);
$pdf->Cell(100,7,$nama['nama_jurusan'],0,1); // semester

// Spasi antara identitas dan detail KRS
$pdf->Cell(10,5,'',0,1);

$pdf->SetFont('Times','B','9');
$pdf->Cell(10,7,'NO.',1,0,'C');
$pdf->Cell(30,7,'KODE_MK',1,0,'C');
$pdf->Cell(100,7,'NAMA_MK',1,0,'C');
$pdf->Cell(20,7,'SKS',1,0,'C');
$pdf->Cell(30,7,'KELAS',1,0,'C');

$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Times','',10);

// Mengambil data KRS
$dataKRS = mysqli_query($conn, "SELECT * FROM khs 
    INNER JOIN jadwal ON khs.id_jadwal = jadwal.id_jadwal
    INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
    INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
    WHERE khs.nim = '$nim' AND khs.id_semester = '$id_semester'");

$no = 1;
$total_sks = 0;

while ($d = mysqli_fetch_array($dataKRS)) {
    $pdf->Cell(10,7,$no++,1,0,'C');
    $pdf->Cell(30,7,$d['kode_mk'],1,0,'C');
    $pdf->Cell(100,7,$d['nama_mk'],1,0,'C');
    $pdf->Cell(20,7,$d['sks'],1,0,'C');
    $pdf->Cell(30,7,$d['nama_kelas'],1,0,'C');
    $pdf->Ln();

    $total_sks += $d['sks']; // Menambahkan jumlah SKS
}

// SET BARIS PALING BAWAH JUMLAH SKS
$pdf->SetFont('Times','B','9');
$pdf->Cell(140,7,'Total SKS',1,0,'C');

$pdf->SetFont('Times','B','9');
$pdf->Cell(50,7,$total_sks,1,0,'C'); // Menggunakan total_sks di sini







$pdf->Cell(200,15,'',0,1,'C');


$mhs = mysqli_query($conn, "SELECT nim, nama, id_jurusan from mahasiswa WHERE nim = '$nim'");
$id_jurusan = mysqli_fetch_assoc($mhs);

$ketua = mysqli_query($conn, "SELECT * FROM jurusan INNER JOIN dosen ON jurusan.nip = dosen.nip WHERE jurusan.id_jurusan = '{$id_jurusan['id_jurusan']}'");

$d = mysqli_fetch_assoc($ketua);

$pdf->SetFont('Times','','12');
$pdf->Cell(90,7,'',0,0,'C');
$pdf->SetFont('Times','','12');
$pdf->Cell(90,7,'Manado,'.date('d F Y'),0,1,'C');




//BAGIAN DOSEN PEMBIMBING DAN MAHASISWA
$pdf->SetFont('Times','','12');
$pdf->Cell(90,7,'Dosen Pembimbing',0,0,'C');

$pdf->SetFont('Times','','12');
$pdf->Cell(90,7,'Mahasiswa',0,1,'C'); // Mahasiswa

$pdf->Cell(10,15,'',0,1);



// BAGIAN KAPRODI
$pdf->SetFont('Times','','12');
$pdf->Cell(90,7,$nama['nama_dosen'],0,0,'C');
$pdf->Cell(90,7,$nama['nama'],0,1,'C'); 
$pdf->Cell(90,7,'Nidn : '.$nama['nip'],0,0,'C');
$pdf->Cell(90,7,'Nim : '.$nama['nim'],0,0,'C');




$pdf->Cell(70,5,'',0,0);

$pdf->Cell(94,20,'',0,1,'C');






//Bagian Ketua Prodi
$kaprodi = mysqli_prepare($conn, "SELECT j.*, d.* FROM jurusan j
                                  INNER JOIN dosen d ON j.nip = d.nip
                                  WHERE j.id_jurusan = ?");
mysqli_stmt_bind_param($kaprodi, 's', $nama['id_jurusan']);
mysqli_stmt_execute($kaprodi);

$hasil_query = mysqli_stmt_get_result($kaprodi);
$kapro = mysqli_fetch_assoc($hasil_query);



$pdf->SetFont('Times', '', 12);
$pdf->Cell(190, 7,'Kaprodi', 0, 0, 'C');
$pdf->Cell(10,15,'',0,2);
$pdf->Cell(100, 10, '', 0, 1);

$pdf->Cell(190, 7, $kapro['nama_dosen'], 0, 1, 'C');
$pdf->Cell(190,7,'Nidn : '.$kapro['nip'],0,0,'C');






$pdf->Output();

?>

