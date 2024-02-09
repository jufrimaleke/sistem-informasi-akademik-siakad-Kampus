<?php
// Load file koneksi.php
 if (!isset($_SESSION))session_start();
include "../../../../config/fungsi.php";
  
include "../../../../assets/PHPExcel/PHPExcel.php";

// Load plugin PHPExcel nya

// Panggil class PHPExcel nya
$excel = new PHPExcel();

// Settingan awal fil excel
// $excel->getProperties()->setCreator('My Notes Code')
//              ->setLastModifiedBy('My Notes Code')
//              ->setTitle("Data Siswa")
//              ->setSubject("Siswa")
//              ->setDescription("Laporan Semua Data Siswa")
//              ->setKeywords("Data Siswa");

// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = array(
  'font' => array('bold' => true), // Set font nya jadi bold
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);

// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);

$excel->setActiveSheetIndex(0)->setCellValue('A1', "DAFTAR MAHASISWA PADA MATAKULIAH");
$excel->getActiveSheet()->mergeCells('A1:I1');
$excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$excel->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$excel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
$fill = $excel->getActiveSheet()->getStyle('A2:I2')->getFill();
$fill->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$fill->getStartColor()->setARGB('dfe0e4'); // Memberikan warna pada A2


// Buat header tabel nya pada baris ke 3
$excel->setActiveSheetIndex(0)->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('B2', "ID KHS"); // Set kolom B3 dengan tulisan "NIS"
$excel->setActiveSheetIndex(0)->setCellValue('C2', "NIM"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('D2', "NAMA");
$excel->setActiveSheetIndex(0)->setCellValue('E2', "NILAI TUGAS"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
$excel->setActiveSheetIndex(0)->setCellValue('F2', "NILAI UTS"); // Set kolom E3 dengan tulisan "TELEPON"
$excel->setActiveSheetIndex(0)->setCellValue('G2', "NILAI UAS"); // Set kolom F3 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('H2', "NILAI AKHIR"); // Set kolom F3 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('I2', "NILAI HURUF"); // Set kolom F3 dengan tulisan "ALAMAT"

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B2')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C2')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('D2')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('E2')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('F2')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('G2')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('H2')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('I2')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

// Buat query untuk menampilkan semua data siswa
 $id_krs = @$_SESSION['id_jadwal'];

 $khs = mysqli_query($conn, "SELECT * FROM khs
         INNER JOIN jadwal ON khs.id_jadwal = jadwal.id_jadwal
         INNER JOIN mahasiswa ON khs.nim = mahasiswa.nim
         WHERE khs.id_jadwal = $id_krs");;

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 3; // Set baris pertama untuk isi tabel adalah baris ke 4
while($data = mysqli_fetch_array($khs)){ // Ambil semua data dari hasil eksekusi $sql
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
  $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['id_khs']);
  $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['nim']);
  $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['nama']);
  
  // Khusus untuk no telepon. kita set type kolom nya jadi STRING
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['nilai_tgs']);
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['nilai_uts']);
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['nilai_uas']);
  $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['nilai_akhir']);
  $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['nilai_huruf']);
  
  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
  $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
  
  $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
  
  $no++; // Tambah 1 setiap kali looping
  $numrow++; // Tambah 1 setiap kali looping
}

// Set width kolom
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(10); // Set width kolom B
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // Set width kolom E
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(10); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('I')->setWidth(10); // Set width kolom F

// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Peserta Kelas");
$excel->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Data Peserta kelas.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');
?>
