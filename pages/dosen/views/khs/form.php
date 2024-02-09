 <?php 
   if (!isset($_SESSION))session_start();

   include "../../config/fungsi.php";

  $id_krs = @$_SESSION['id_jadwal'];

  $krs = mysqli_query($conn, "SELECT * FROM jadwal
           INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
            WHERE jadwal.id_jadwal = $id_krs");

?>
 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> Form Import Nilai</li>
  </ol>    
  </section>

  <section class="content">
 <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
        <?php foreach ($krs as $row) : ?>
          <h3 class="box-title"><?= $row["kode_mk"] ?> - <?= $row["nama_mk"] ?> </h3>
        <?php endforeach; ?>

          <div class="callout callout-info">
            <p>1. Gunakan Tombol "Download Peserta Kelas" untuk mendownload format file Upload.</p>
            <p>2. Upload file dalam ekstensi *.xlsx, *.xls, *.csv dan format sesuai dengan format file yang didownload.</p>
          </div>
        </div>

        <form method="POST" action="" enctype="multipart/form-data">
              <a target="_blank" class="btn btn-success" href="views/khs/export_excel.php">Download Peserta Kelas</a> <br><br>
                <input type="file" name="file" class="pull-left">
             
                <button type="submit" name="preview" class="btn btn-primary" align="left">
                    <span class="glyphicon glyphicon-eye-open"></span> Preview
                </button>            
          </form>
        <hr>

      <div class="box-body">
      <!-- Buat Preview Data -->
      <?php
      // Jika user telah mengklik tombol Preview
      if(isset($_POST['preview'])){
        //$ip = ; // Ambil IP Address dari User
        $nama_file_baru = 'data.xlsx';
        
        // Cek apakah terdapat file data.xlsx pada folder tmp
        if(is_file('../../assets/tmp/'.$nama_file_baru)) // Jika file tersebut ada
           unlink('../../assets/tmp/'.$nama_file_baru); // Hapus file tersebut
        
        $tipe_file = $_FILES['file']['type']; // Ambil tipe file yang akan diupload
        $tmp_file = $_FILES['file']['tmp_name'];
        
        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if($tipe_file == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
          // Upload file yang dipilih ke folder tmp
          // dan rename file tersebut menjadi data{ip_address}.xlsx
          // {ip_address} diganti jadi ip address user yang ada di variabel $ip
          // Contoh nama file setelah di rename : data127.0.0.1.xlsx
          move_uploaded_file($tmp_file, '../../assets/tmp/'.$nama_file_baru);
          
          // Load librari PHPExcel nya
          require_once '../../assets/PHPExcel/PHPExcel.php';
          
          $excelreader = new PHPExcel_Reader_Excel2007();
          $loadexcel = $excelreader->load('../../assets/tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
          $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
          
          // Buat sebuah tag form untuk proses import data ke database
          echo "<form method='post' action='views/khs/import.php'>";
          
          // Buat sebuah div untuk alert validasi kosong
          echo "<div class='alert alert-danger' id='kosong'>
          Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
          </div>";
          
          echo "<table class='table table-bordered'>
          <tr>
            <th colspan='5' class='text-center'>Preview Data</th>
          </tr>
          <tr>
            <th>Id KHS</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Nilai Tugas</th>
            <th>Nilai UTS</th>
            <th>Nilai UAS</th>
            <th>Nilai Akhir</th>
            <th>Nilai Huruf</th>
          </tr>";
          
          $numrow = 1;
          $kosong = 0;
          foreach($sheet as $row){ // Lakukan perulangan dari data yang ada di excel
            // Ambil data pada excel sesuai Kolom
            $id_khs  = $row['B'];
            $nim     = $row['C']; // Ambil data NIS
            $nama    = $row['D']; // Ambil data nama
            $n_tugas = $row['E']; // Ambil data jenis kelamin
            $n_uts   = $row['F']; // Ambil data telepon
            $n_uas   = $row['G']; // Ambil data alamat
            $n_akhir = $row['H'];
            $n_huruf = $row['I'];
            
            // Cek jika semua data tidak diisi
            if(empty($id_khs) && empty($nim) && empty($nama) && empty($n_tugas) && empty($n_uts) && empty($n_uas) && empty($n_akhir) && empty($n_huruf))
              continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
            
            // Cek $numrow apakah lebih dari 1
            // Artinya karena baris pertama adalah nama-nama kolom
            // Jadi dilewat saja, tidak usah diimport
            if($numrow > 1){
              // Validasi apakah semua data telah diisi
              $id_khs_td = ( ! empty($id_khs))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
              $nim_td = ( ! empty($nim))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
              $nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
              $n_tugas_td = ( ! empty($n_tugas))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
              $n_uts_td = ( ! empty($n_uts))? "" : " style='background: #E07171;'"; // Jika Telepon kosong, beri warna merah
              $n_uas_td = ( ! empty($n_uas))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
              $n_akhir_td = ( ! empty($n_akhir))? "" : " style='background: #E07171;'";
              $n_huruf_td = ( ! empty($n_huruf))? "" : " style='background: #E07171;'";

              // Jika salah satu data ada yang kosong
              if(empty($id_khs) or empty($nim) or empty($nama) or empty($n_tugas) or empty($n_uts) or empty($n_uas) or empty($n_akhir) or empty($n_huruf)){
                $kosong++; // Tambah 1 variabel $kosong
              }
              
              echo "<tr>";
              echo "<td".$id_khs_td.">".$id_khs."</td>";
              echo "<td".$nim_td.">".$nim."</td>";
              echo "<td".$nama_td.">".$nama."</td>";
              echo "<td".$n_tugas_td.">".$n_tugas."</td>";
              echo "<td".$n_uts_td.">".$n_uts."</td>";
              echo "<td".$n_uas_td.">".$n_uas."</td>";
              echo "<td".$n_akhir_td.">".$n_akhir."</td>";
              echo "<td".$n_uas_td.">".$n_huruf."</td>";
              echo "</tr>";
            }
            
            $numrow++; // Tambah 1 setiap kali looping
          }
          
          echo "</table>";
          
          // Cek apakah variabel kosong lebih dari 0
          // Jika lebih dari 0, berarti ada data yang masih kosong
          if($kosong > 0){
          ?>  
            <script>
            $(document).ready(function(){
              // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
              $("#jumlah_kosong").html('<?php echo $kosong; ?>');
              
              $("#kosong").show(); // Munculkan alert validasi kosong
            });
            </script>
          <?php
          }else{ // Jika semua data sudah diisi
            echo "<hr>";
            
            // Buat sebuah tombol untuk mengimport data ke database
            echo "<button type='submit' name='import' class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Import</button>";
          }
          
          echo "</form>";
        }else{ // Jika file yang diupload bukan File Excel 2007 (.xlsx)
          // Munculkan pesan validasi
          echo "<div class='alert alert-danger'>
          Hanya File Excel 2007 (.xlsx) yang diperbolehkan
          </div>";
        }
      }
      ?>
            </div>
          </div>
  </section>