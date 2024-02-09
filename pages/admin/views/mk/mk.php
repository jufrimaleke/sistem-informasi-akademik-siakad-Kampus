<?php 
  include "../../config/fungsi.php";
  $mk = mysqli_query($conn, "SELECT * FROM mata_kuliah 
        INNER JOIN jurusan ON mata_kuliah.id_jurusan = jurusan.id_jurusan 
        INNER JOIN paket_semester ON mata_kuliah.id_paketSemester = paket_semester.id_paket");
 ?>


  
 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> MK</li>
  </ol>    
  </section>

  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Mata Kuliah</h3>
               <a href="?page=mk&aksi=tambah" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
               <a href="views/mk/cetak.php" target="_blank" class="btn btn-warning btn-ms"> <span class="glyphicon glyphicon-print"></span> Cetak</a><br><br>

                <form method="POST" action="" enctype="multipart/form-data">
              <a target="_blank" class="btn btn-primary" href="../../assets/tmp/mk/template/data.xlsx">Download Template</a> <br><br>
                <input type="file" name="file" class="pull-left">
             
                <button type="submit" name="preview" class="btn btn-primary" align="left">
                    <span class="glyphicon glyphicon-eye-open"></span> Preview
                      </button>            
                </form>
              <hr>
            </div>
            <?php
      // Jika user telah mengklik tombol Preview
      if(isset($_POST['preview'])){
        //$ip = ; // Ambil IP Address dari User
        $nama_file_baru = 'data.xlsx';
        
        // Cek apakah terdapat file data.xlsx pada folder tmp
        if(is_file('../../assets/tmp/mk/'.$nama_file_baru)) // Jika file tersebut ada
           unlink('../../assets/tmp/mk/'.$nama_file_baru); // Hapus file tersebut
        
        $tipe_file = $_FILES['file']['type']; // Ambil tipe file yang akan diupload
        $tmp_file = $_FILES['file']['tmp_name'];
        
        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if($tipe_file == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
          // Upload file yang dipilih ke folder tmp
          // dan rename file tersebut menjadi data{ip_address}.xlsx
          // {ip_address} diganti jadi ip address user yang ada di variabel $ip
          // Contoh nama file setelah di rename : data127.0.0.1.xlsx
          move_uploaded_file($tmp_file, '../../assets/tmp/mk/'.$nama_file_baru);
          
          // Load librari PHPExcel nya
          require_once '../../assets/PHPExcel/PHPExcel.php';
          
          $excelreader = new PHPExcel_Reader_Excel2007();
          $loadexcel = $excelreader->load('../../assets/tmp/mk/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
          $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
          
          // Buat sebuah tag form untuk proses import data ke database
          echo "<form method='post' action='views/mk/import.php'>";
          
          // Buat sebuah div untuk alert validasi kosong
          echo "<div class='alert alert-danger' id='kosong'>
          Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
          </div>";
          
          echo "<div class='table-responsive'> <table class='table table-bordered'>
          <tr>
            <th colspan='7' class='text-center'>Preview Data</th>
          </tr>
          <tr>
            
            <th>Kode MK</th>
            <th>Nama MK</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Prodi</th>
          </tr>";
          
          $numrow = 1;
          $kosong = 0;
          foreach($sheet as $row){ // Lakukan perulangan dari data yang ada di excel
            // Ambil data pada excel sesuai Kolom
            $kode_mk        = $row['B'];
            $nama_mk        = $row['C']; // Ambil data NIS
            $sks            = $row['D']; // Ambil data nama
            $paket_semester = $row['E']; // Ambil data jenis kelamin
            $prodi          = $row['F']; // Ambil data telepon
           
            
            // Cek jika semua data tidak diisi
            if(empty($kode_mk) && empty($nama_mk) && empty($sks) && empty($paket_semester) && empty($prodi))
              continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
            
            // Cek $numrow apakah lebih dari 1
            // Artinya karena baris pertama adalah nama-nama kolom
            // Jadi dilewat saja, tidak usah diimport
            if($numrow > 1){
              $kode_mk_td = ( ! empty($kode_mk))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
              $nama_mk_td = ( ! empty($nama_mk))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
              $sks_td = ( ! empty($sks))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
              $paket_semester_td = ( ! empty($paket_semester))? "" : " style='background: #E07171;'"; // Jika Telepon kosong, beri warna merah
              $jurusan_td = ( ! empty($prodi))? "" : " style='background: #E07171;'";

              // Jika salah satu data ada yang kosong
              if(empty($kode_mk) or empty($nama_mk) or empty($sks) or empty($paket_semester) or empty($prodi)){
                $kosong++; // Tambah 1 variabel $kosong
              }
              
              echo 
              "<tr>";
                   // echo "<td".$id_khs_td.">".$id_khs."</td>";
                    echo "<td".$kode_mk_td.">".$kode_mk."</td>";
                    echo "<td".$nama_mk_td.">".$nama_mk."</td>";
                    echo "<td".$sks_td.">".$sks."</td>";
                    echo "<td".$paket_semester_td.">".$paket_semester."</td>";
                    echo "<td".$jurusan_td.">".$prodi."</td>";
              "</tr>";
            }
            
            $numrow++; // Tambah 1 setiap kali looping
          }
          
          echo "</table></div>";
          
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

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Kode MK</th>
                  <th>Nama MK</th>
                  <th>SKS</th>
                  <th>Semester</th>  
                  <th>Prodi</th>               
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($mk as $row) :  ?>   
                <tr>
                  <td><?= $i ?></td>                               
                  <td><?= $row["kode_mk"]; ?></td>
                  <td><?= $row["nama_mk"]; ?></td>
                  <td><?= $row["sks"]; ?></td>
                  <td><?= $row["nama_paket"]; ?></td>
                  <td><?= $row["nama_jurusan"]; ?></td>
                 
                  <td style="text-align: center;">
                   <a href="?page=mk&aksi=ubah&id_mk=<?= $row["id_mk"]; ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                   <a href="?page=mk&aksi=hapus&id_mk=<?= $row["id_mk"]; ?>"onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                  </td>
                  <?php $i++; ?>               
                  <?php endforeach; ?>
                </tr>                
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>

 <!-- jQuery 3 -->
