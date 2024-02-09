<?php
session_start();
include "../../../../assets/fpdf/fpdf.php";
$nim = $_SESSION['mahasiswa'];
// $id_semester = $_SESSION['idsemester'];

$conn = mysqli_connect("localhost", "root", "", "siakadstiks");

// Mengambil data nama mahasiswa
$dataNama = mysqli_query($conn, "SELECT * FROM mahasiswa INNER JOIN dosen ON mahasiswa.nip = dosen.nip
    INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan WHERE nim = '$nim'");

$nama = mysqli_fetch_assoc($dataNama);

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

// SET HEADER TEXT "CETAK KRS"
// Tambahkan gambar sebelah kiri teks
$pdf->Image('../../../../assets/img/Logo2.png', 10, 10, 25); // Ganti 'path_to_image.jpg' dengan path gambar Anda dan tentukan koordinat dan ukuran gambar yang sesuai

$pdf->SetFont('Times','B',12);
$pdf->Cell(80); // Spasi untuk memindahkan teks ke kanan agar tidak bertabrakan dengan gambar
$pdf->Cell(40,7,'YAYASAN PEMBANGUNAN INDONESIA',0,1,'C');
$pdf->Cell(200,7,'SEKOLAH TINGGI ILMU KESEJAHTERAAN SOSIAL MANADO',0,1,'C');
$pdf->SetFont('Times','',12);
$pdf->Cell(200,7,'Jl. Toar No 68, Mahakeret Barat',0,1,'C');
$pdf->Cell(200,7,'Kecamatan Wenang, Kota Manado Sulawesi Utara',0,1,'C');
$pdf->Cell(190, 2, '', 'T',1,'C'); // 'T' adalah opsi untuk garis bawah
$pdf->SetFont('Times','B',14);
$pdf->Cell(200,20,'T R A N S K R I P  N I L A I  S E M E N T A R A',0,1,'C');







// SET IDENTITAS "NAMA, NIM, TAHUN PERIODE"
$pdf->SetFont('Times','',12);
$pdf->Cell(50,5,'Nama',0,0);
$pdf->Cell(3,5,':',0,0);
$pdf->Cell(100,5,$nama['nama'],0,1); // Sesuaikan dengan nilai nama

$pdf->Cell(50, 5, 'Tempat dan Tanggal Lahir', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->Cell(100, 5, $nama['tempat_lahir'] . ', ' . $nama['tgl_lahir'], 0, 1);


//nim
$pdf->Cell(50,5,'Nim',0,0);
$pdf->Cell(3,5,':',0,0);
$pdf->Cell(10,5,$nim,0,1); // Sesuaikan dengan nilai nim
//tahun akademik

//prodi
$pdf->Cell(50,5,'Program Studi',0,0);
$pdf->Cell(3,5,':',0,0);
$pdf->Cell(100,5,$nama['nama_jurusan'],0,1); // semester

// Spasi antara identitas dan detail KRS
$pdf->Cell(10,15,'',0,1);

$pdf->SetFont('Times','B','9');
$pdf->Cell(10,7,'NO.',1,0,'C');
$pdf->Cell(30,7,'KODE_MK',1,0,'C');
$pdf->Cell(70,7,'NAMA_MK',1,0,'C');
$pdf->Cell(20,7,'SKS',1,0,'C');
$pdf->Cell(20,7,'BOBOT',1,0,'C');
$pdf->Cell(30,7,'NILAI',1,0,'C');

$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Times','',10);

// Mengambil data KRS
$dataKRS = mysqli_query($conn, "SELECT * FROM khs 
    INNER JOIN jadwal ON khs.id_jadwal = jadwal.id_jadwal
    INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
    INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
    WHERE khs.nim = '$nim'");

$no = 1;
$total_sks = 0;
$tot_nk = 0;

while ($d = mysqli_fetch_array($dataKRS)) {
    $bobot = 0;

    if ($d['nilai_huruf'] == 'A') {
        $bobot = 4;
    } elseif ($d['nilai_huruf'] == 'B') {
        $bobot = 3;
    } elseif ($d['nilai_huruf'] == 'C') {
        $bobot = 2;
    } elseif ($d['nilai_huruf'] == 'D') {
        $bobot = 1;
    } elseif ($d['nilai_huruf'] == 'E') {
        $bobot = 0;
    }

    $pdf->Cell(10, 7, $no++, 1, 0, 'C');
    $pdf->Cell(30, 7, $d['kode_mk'], 1, 0, 'C');
    $pdf->Cell(70, 7, $d['nama_mk'], 1, 0, 'C');
    $pdf->Cell(20, 7, $d['sks'], 1, 0, 'C');
    $pdf->Cell(20, 7, $bobot * $d['sks'], 1, 0, 'C');
    $pdf->Cell(30, 7, $d['nilai_huruf'], 1, 0, 'C');
    $pdf->Ln();

    $total_sks += $d['sks']; //total semua sks
    $tot_nk += $bobot * $d['sks']; //jadi bobot dikalikan sks contoh nilai A = 4 dikalikan coontohnya 3 sks = 12
}

$ips = $tot_nk / $total_sks; //jumlkah keseluruhan nilai bobot dibahagi jumlah sks
$hasilIps = number_format($ips, 2, '.', '');

// Set baris paling bawah jumlah SKS
$pdf->SetFont('Times', 'B', '9');
$pdf->Cell(110, 7, 'Total SKS', 1, 0);
$pdf->Cell(70, 7, $total_sks, 1, 1, 'C');

// Set baris total IPS
$pdf->Cell(110, 7, 'Total IPK', 1, 0);
$pdf->Cell(70, 7, $hasilIps, 1, 1, 'C');






// $pdf->Cell(10, 15, '', 0, 1);
// $pdf->SetFont('Times', '', 12);
// $pdf->Cell(300, 7, 'Manado, ' . date('d F Y'), 0, 1, 'C');
// $yPosBeforeKetua = $pdf->GetY(); // Simpan posisi Y sebelum menambah cell "Ketua"
// $pdf->Cell(600, 7, 'Ketua,', 0, 0);
// $pdf->SetY($yPosBeforeKetua); // Set posisi Y ke posisi sebelumnya
// $pdf->Cell(10, 15, '', 0, 2);
// $pdf->Cell(300, 7, $nama['nama'], 0, 1, 'C');




$pdf->Cell(200,20,'',0,1,'C');






$ketua = mysqli_query($conn, "SELECT * FROM ketua");
$d = mysqli_fetch_assoc($ketua);
$kaprodi = mysqli_query($conn, "SELECT * FROM kaprodi");
$kapro = mysqli_fetch_assoc($kaprodi);
// SET IDENTITAS "NAMA, NIM, TAHUN PERIODE"
$pdf->SetFont('Times','',12);

$pdf->Cell(125,5,'',0,0);
$pdf->Cell(100,5,'Manado,' . date('d F Y'),0,1); // Sesuaikan dengan nilai nama
$pdf->SetFont('Times','B',12);
$pdf->Cell(20, 5, '', 0, 0);
$pdf->Cell(30, 5, $kapro['jabatan'], 0, 0);
$pdf->Cell(94, 5, '', 0, 0);
$pdf->Cell(100, 8, $d['jabatan'],0, 1);


$pdf->SetFont('Times','B',12);
$pdf->Cell(70,5,'',0,0);
$pdf->Cell(94,20,'',0,1,'C');
$pdf->Cell(120,5,$kapro['nama_kaprodi'],0,0);

$pdf->Cell(10,5,$d['nama_ketua'],0,1); // Sesuaikan dengan nilai nim








$pdf->Output();

?>
