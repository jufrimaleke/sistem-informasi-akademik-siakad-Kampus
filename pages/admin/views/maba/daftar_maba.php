 <?php 
  include "../../config/fungsi.php";
  $maba = mysqli_query($conn, "SELECT * FROM maba INNER JOIN jurusan ON maba.id_jurusan = jurusan.id_jurusan");

 ?>

 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> Mahasiswa</li>
  </ol>    
  </section>

  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Mahasiswa</h3>
               <a href="?page=maba&aksi=tambah" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
               <a href="#" target="_blank" id="" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-print"></span>  Cetak</a>
               
               <form method="POST" action="" enctype="multipart/form-data"><br>
              <a class="btn btn-primary" href="#">Download Template</a> <br><br>
                <input type="file" name="file" class="pull-left">
             
                <button type="submit" name="preview" class="btn btn-primary" align="left">
                    <span class="glyphicon glyphicon-eye-open"></span> Preview
                      </button>            
                </form>
            </div>

  <?php
      // Jika user telah mengklik tombol Preview
      if(isset($_POST['preview'])){
        //$ip = ; // Ambil IP Address dari User
        $nama_file_baru = 'data.xlsx';
        
        // Cek apakah terdapat file data.xlsx pada folder tmp
        if(is_file('../../assets/tmp/mhs/'.$nama_file_baru)) // Jika file tersebut ada
           unlink('../../assets/tmp/mhs/'.$nama_file_baru); // Hapus file tersebut
        
        $tipe_file = $_FILES['file']['type']; // Ambil tipe file yang akan diupload
        $tmp_file = $_FILES['file']['tmp_name'];
        
        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if($tipe_file == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
          // Upload file yang dipilih ke folder tmp
          // dan rename file tersebut menjadi data{ip_address}.xlsx
          // {ip_address} diganti jadi ip address user yang ada di variabel $ip
          // Contoh nama file setelah di rename : data127.0.0.1.xlsx
          move_uploaded_file($tmp_file, '../../assets/tmp/mhs'.$nama_file_baru);
          
          // Load librari PHPExcel nya
          require_once '../../assets/PHPExcel/PHPExcel.php';
          
          $excelreader = new PHPExcel_Reader_Excel2007();
          $loadexcel = $excelreader->load('../../assets/tmp/mhs/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
          $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
          
          // Buat sebuah tag form untuk proses import data ke database
          echo "<form method='post' action='views/mahasiswa/import.php'>";
          
          // Buat sebuah div untuk alert validasi kosong
          echo "<div class='alert alert-danger' id='kosong'>
          Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
          </div>";
          
          echo "<div class='table-responsive'> <table class='table table-bordered'>
          <tr>
            <th colspan='7' class='text-center'>Preview Data</th>
          </tr>
          <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Alamat</th>
            <th>Password</th>
            <th>Prodi</th>
            <th>Angkatan</th>
          </tr>";
          
          $numrow = 1;
          $kosong = 0;
          foreach($sheet as $row){ // Lakukan perulangan dari data yang ada di excel
            // Ambil data pada excel sesuai Kolom
            $no               = $row['A'];
            $nim              = $row['B'];
            $nama             = $row['C']; // Ambil data NIS
            $tempat_lahir     = $row['D']; // Ambil data nama
            $tanggal_lahir    = $row['E']; // Ambil data jenis kelamin
            $jenis_kelamin    = $row['F']; // Ambil data telepon
            $agama            = $row['G']; // Ambil data alamat
            $alamat           = $row['H'];
            $password         = $row['I'];
            $prodi            = $row['J'];
            $angkatan         = $row['K'];
            
            // Cek jika semua data tidak diisi
            if(empty($no) && empty($nim) && empty($nama) && empty($tempat_lahir) && empty($tanggal_lahir) && empty($jenis_kelamin) && empty($agama) && empty($alamat) && empty($password) && empty($prodi) && empty($angkatan))
              continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
            
            // Cek $numrow apakah lebih dari 1
            // Artinya karena baris pertama adalah nama-nama kolom
            // Jadi dilewat saja, tidak usah diimport
            if($numrow > 1){
              // Validasi apakah semua data telah diisi
             // $id_khs_td = ( ! empty($id_khs))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
              $no_td = ( ! empty($no))? "" : " style='background: #E07171;'";
              $nim_td = ( ! empty($nim))? "" : " style='background: #E07171;'";
              $nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'";
              $tempat_lahir_td = ( ! empty($tempat_lahir))? "" : " style='background: #E07171;'";
              $tanggal_lahir_td = ( ! empty($tanggal_lahir))? "" : " style='background: #E07171;'";
              $jenis_kelamin_td = ( ! empty($jenis_kelamin))? "" : " style='background: #E07171;'";
              $agama_td = ( ! empty($agama))? "" : " style='background: #E07171;'";
              $alamat_td = ( ! empty($alamat))? "" : " style='background: #E07171;'";
              $password_td = ( ! empty($password))? "" : " style='background: #E07171;'";
              $prodi_td = ( ! empty($prodi))? "" : " style='background: #E07171;'";
              $angkatan_td = ( ! empty($angkatan))? "" : " style='background: #E07171;'";

            
              
              echo "<tr>";
             // echo "<td".$id_khs_td.">".$id_khs."</td>";
              echo "<td".$no_td.">".$no."</td>";
              echo "<td".$nim_td.">".$nim."</td>";
              echo "<td".$nama_td.">".$nama."</td>";
              echo "<td".$tempat_lahir_td.">".$tempat_lahir."</td>";
              echo "<td".$tanggal_lahir_td.">".$tanggal_lahir."</td>";
              echo "<td".$jenis_kelamin_td.">".$jenis_kelamin."</td>";
              echo "<td".$agama_td.">".$agama."</td>";
              echo "<td".$alamat_td.">".$alamat."</td>";
              echo "<td".$password_td.">".$password."</td>";
               echo "<td".$prodi_td.">".$prodi."</td>";
              echo "<td".$angkatan_td.">".$angkatan."</td>";
              echo "</tr>";
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
            <div class="table-responsive">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>No.Pendaftaran</th>
                  <th>Nama</th>
                  <th>Tempat Lahir</th>
                  <th>Tanggal Lahir</th>
                  <th>JK</th>
                  <th>No.HP</th>
                  <th>Prodi</th>
                  <th>Berkas</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($maba as $row) :  ?>   

                <tr>
                  <td><?= $i ?></td>
                  <td><?= $row["no_pendaftaran"]; ?></td>
                  <td><?= $row["nama"]; ?></td>
                  <td><?= $row["tempat_lahir"]; ?></td>
                  <td><?= $row["tgl_lahir"]; ?></td>
                  <td><?= $row["jenis_kelamin"]; ?></td>
                  <td><?= $row["nomor_hp"]; ?></td>
                  <td><?= $row["nama_jurusan"]; ?></td>
                  <td>
                    <a href="<?php echo $row['berkas'];?>" target="_blank"><?php echo $row['berkas'];?></a> 
                    </td>

                  <td style="text-align: center;">
                   <a href="?page=maba&aksi=ubah&id=<?= $row["no_pendaftaran"]; ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
                   <a href="?page=maba&aksi=hapus&no_pendaftaran=<?= $row["no_pendaftaran"]; ?>"onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                  <?php $i++; ?>               
                  <?php endforeach; ?>
                </tr>
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>


</body>
</html>