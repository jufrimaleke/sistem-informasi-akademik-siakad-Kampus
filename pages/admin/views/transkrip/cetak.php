<?php
session_start();
include "../../../../config/fungsi.php";

$nim = $_GET['nim'];

include "../../../../assets/fpdf/fpdf.php";


$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

// Mengambil data nama mahasiswa
$dataNama = mysqli_query($conn, "SELECT * FROM mahasiswa INNER JOIN dosen ON mahasiswa.nip = dosen.nip
    INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan WHERE mahasiswa.nim = '$nim'");

$nama = mysqli_fetch_assoc($dataNama);

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$lebar_halaman = 210; // Ganti dengan lebar halaman sesuai kebutuhan Anda
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


$pdf->Cell(200,10,'T R A N S K R I P  N I L A I  S E M E N T A R A',0,1,'C');








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




$mhs = mysqli_query($conn, "SELECT nim, nama, id_jurusan from mahasiswa WHERE nim = '$nim'");
$id_jurusan = mysqli_fetch_assoc($mhs);

$ketua = mysqli_query($conn, "SELECT * FROM jurusan INNER JOIN dosen ON jurusan.nip = dosen.nip WHERE jurusan.id_jurusan = '{$id_jurusan['id_jurusan']}'");

$d = mysqli_fetch_assoc($ketua);

$pdf->SetFont('Times','B','12');
$pdf->Cell(90,7,'',0,0,'C');
$pdf->SetFont('Times','B','12');
$pdf->Cell(90,7,'Manado,'.date('d F Y'),0,1,'C');



$pdf->SetFont('Times','B','12');
$pdf->Cell(90,7,'',0,0,'C');

$pdf->SetFont('Times','B','12');
$pdf->Cell(90,7,'Kaprodi',0,1,'C'); // Mahasiswa

$pdf->Cell(10,15,'',0,1);



// SET BARIS PALING BAWAH JUMLAH SKS
$pdf->SetFont('Times','B','12');
$pdf->Cell(90,7,'',0,0,'C');
$pdf->SetFont('Times','B','12');
$pdf->Cell(90,7,$d['nama_dosen'],0,0,'C'); // Nama dosen







// $pdf->SetFont('Times','B',12);
$pdf->Cell(70,5,'',0,0);
$pdf->Cell(94,20,'',0,1,'C');
// $pdf->Cell(120,5,$nama['nama_dosen'],0,0);// nama Dosen Pembimbing
// $pdf->Cell(60,5,$nama['nama'],1,1); // Nama Mahasiswa




//Bagian Ketua Prodi


$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(190, 7, '', 0, 0, 'C');
$pdf->Cell(10,15,'',0,2);
$pdf->Cell(100, 10, '', 0, 1);

$pdf->Cell(190, 7, '', 0, 0, 'C');












$pdf->SetY(-40); // Posisi vertikal dari bawah halaman
$pdf->SetFont('Arial', 'I', 5); // Mengatur font, gaya, dan ukuran
$pdf->Cell(0, 10, 'Dokumen ini dicetak oleh:' . '', 0, 0, 'L');
$pdf->SetY(-37); // Posisi vertikal dari bawah halaman
$pdf->SetFont('Arial', 'I', 5); // Mengatur font, gaya, dan ukuran
$pdf->Cell(0, 10, 'Ip_address. ' . $_SERVER['REMOTE_ADDR'], 0, 0, 'L');






$pdf->Output();

