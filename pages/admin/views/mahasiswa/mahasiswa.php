 <?php 
  include "../../config/fungsi.php";
 

  $angkatan = mysqli_query($conn, "SELECT id_angkatan FROM angkatan");
  $jurusan = mysqli_query($conn, "SELECT id_jurusan,kode_jurusan,nama_jurusan FROM jurusan");
  $dosen = mysqli_query($conn, "SELECT nip FROM dosen");
 
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
               <a href="?page=mahasiswa&aksi=tambah" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fa fa-print"></i> Download Data</a>
               
               <form method="POST" action="" enctype="multipart/form-data"><br>
              <a class="btn btn-primary" href="../../assets/tmp/mhs/sample/templnew.xlsx">Download Template</a> <br><br>
                <input type="file" name="file" class="pull-left">
                <button type="submit" name="preview" class="btn btn-primary" align="left">
                    <span class="glyphicon glyphicon-eye-open"></span> Preview
                      </button>            
                </form><br>

                <form method="POST">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="angkatan">Angkatan :</label>
                       
                        <select name="angkatan" required class="form-control" id="angkatan">
                          <?php $_SESSION['filter_angkatan'] = $_POST['angkatan']; ?>
                          <option value="">Semua</option>
                          <?php foreach ($angkatan as $row): ?>
                            <option value="<?php echo $row["id_angkatan"]; ?>"
                              <?= $_SESSION['filter_angkatan'] === $row['id_angkatan'] ? 'selected' : ''; ?>>
                              <?php echo $row["id_angkatan"]; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="jrs">Prodi:</label>
                        

                        <select name="jrs"class="form-control" id="jrs">

                          <?php $_SESSION['filter_prodi'] = $_POST['jrs']; ?>
                      
                          <?php foreach ($jurusan as $row): ?>
                            <option value="<?php echo $row["id_jurusan"]; ?>" 
                              <?= $_SESSION['filter_prodi'] === $row['id_jurusan'] ? 'selected' : ''; ?>>
                              <?php echo $row['nama_jurusan']; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>


                    <div class="col-md-2">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" name="filter" class="btn btn-info form-control">Filter</button>
                      </div>
                    </div>
                  </div>
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
          move_uploaded_file($tmp_file, '../../assets/tmp/mhs/'.$nama_file_baru);
          
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
            <th>Nik</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Agama</th>
            <th>Password</th>
            <th>NIP</th>
            <th>Prodi</th>
            <th>Angkatan</th>
          </tr>";
          
          $numrow = 1;
          $kosong = 0;
          foreach($sheet as $row){ // Lakukan perulangan dari data yang ada di excel
            // Ambil data pada excel sesuai Kolo

          $no              = $row['A'];
          $nim             = $row['B'];
          $nama            = $row['C'];
          $nik             = $row['D'];
          $jenis_kelamin   = $row['E'];
          $tempat_lahir    = $row['F'];
          $tanggal_lahir   = $row['G'];
          $alamat          = $row['H']; 
          $agama           = $row['I'];
          $password        = $row['J'];
          $nip             = $row['K'];
          $id_jurusan      = $row['L'];
          $id_angkatan     = $row['M'];

            
            // Cek jika semua data tidak diisi
            if(empty($no) && empty($nim) && empty($nama) && empty($nik) && empty($jenis_kelamin) && empty($tempat_lahir) && empty($tanggal_lahir) && empty($alamat) && empty($agama) && empty($password) && empty($nip) && empty($id_jurusan) && empty($id_angkatan))
              continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
            
            
            if($numrow > 1){
              // Validasi apakah semua data telah diisi
             // $id_khs_td = ( ! empty($id_khs))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
              $no_td = ( ! empty($no))? "" : " style='background: #E07171;'";
              $nim_td = ( ! empty($nim))? "" : " style='background: #E07171;'";
              $nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'";
              $nik_td = ( ! empty($nik))? "" : " style='background: #E07171;'";
              $jenis_kelamin_td = ( ! empty($jenis_kelamin))? "" : " style='background: #E07171;'";
              $tempat_lahir_td = ( ! empty($tempat_lahir))? "" : " style='background: #E07171;'";
              $tanggal_lahir_td = ( ! empty($tanggal_lahir))? "" : " style='background: #E07171;'";
              $alamat_td = ( ! empty($alamat))? "" : " style='background: #E07171;'";
              $agama_td = ( ! empty($agama))? "" : " style='background: #E07171;'";
              $password_td = ( ! empty($password))? "" : " style='background: #E07171;'";
              $nip_td = ( ! empty($nip))? "" : " style='background: #E07171;'";
              $id_jurusan_td = ( ! empty($id_jurusan))? "" : " style='background: #E07171;'";
              $id_angkatan_td = ( ! empty($id_angkatan))? "" : " style='background: #E07171;'";

            
              
              echo "<tr>";
             // echo "<td".$id_khs_td.">".$id_khs."</td>";
              echo "<td".$no_td.">".$no."</td>";
              echo "<td".$nim_td.">".$nim."</td>";
              echo "<td".$nama_td.">".$nama."</td>";
              echo "<td".$nik_td.">".$nik."</td>";
              echo "<td".$jenis_kelamin_td.">".$jenis_kelamin."</td>";
              echo "<td".$tempat_lahir_td.">".$tempat_lahir."</td>";
              echo "<td".$tanggal_lahir_td.">".$tanggal_lahir."</td>";
              echo "<td".$alamat_td.">".$alamat."</td>";
              echo "<td".$agama_td.">".$agama."</td>";
              echo "<td".$password_td.">".$password."</td>";
              echo "<td".$nip_td.">".$nip."</td>";
              echo "<td".$id_jurusan_td.">".$id_jurusan."</td>";
              echo "<td".$id_angkatan_td.">".$id_angkatan."</td>";
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
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Nik</th> 
                  <th>Prodi</th>
                  <th>Angkatan</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
<?php 
if (isset($_POST['filter'])) {
    $angkatan = $_POST['angkatan'];
    $jrs = $_POST['jrs'];

    $mahasiswa = mysqli_prepare($conn, "SELECT nim,nama,jenis_kelamin,nik,jurusan.nama_jurusan,angkatan.id_angkatan FROM mahasiswa INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
    INNER JOIN angkatan ON mahasiswa.id_angkatan = angkatan.id_angkatan WHERE angkatan.id_angkatan = ? and jurusan.id_jurusan = ?");

   mysqli_stmt_bind_param($mahasiswa, "ii",$angkatan,$jrs);
   mysqli_stmt_execute($mahasiswa);
   $result = mysqli_stmt_get_result($mahasiswa);

    if (mysqli_num_rows($result) > 0) {
        $i = 1;
        foreach ($result as $row) :
?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $row["nim"]; ?></td>
                <td><?= $row["nama"]; ?></td>
                <td><?= $row["jenis_kelamin"]; ?></td>
                <td><?= $row["nik"]; ?></td>
                <td><?= $row["nama_jurusan"]; ?></td>
                <td><?= $row["id_angkatan"]; ?></td>
                <td style="text-align: center;">
                    <a href="?page=mahasiswa&aksi=ubah&nim=<?= $row["nim"]; ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="?page=mahasiswa&aksi=hapus&nim=<?= $row["nim"]; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
<?php
            $i++;
        endforeach;
    } else {
        // Tampilkan pesan jika tidak ada data yang ditemukan
        echo '<tr><td colspan="8" class="text-center">Tidak ada data yang ditemukan</td></tr>';
    }
} else {
    // Jika filter belum dipilih, tampilkan semua data
   

$mahasiswa = mysqli_query($conn, "SELECT nim, nama, jenis_kelamin, nik, jurusan.nama_jurusan, angkatan.id_angkatan FROM mahasiswa 
   INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan 
   INNER JOIN angkatan ON mahasiswa.id_angkatan = angkatan.id_angkatan");

    if (mysqli_num_rows($mahasiswa) > 0) {
        $i = 1;
        foreach ($mahasiswa as $row) :
?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $row["nim"]; ?></td>
                <td><?= $row["nama"]; ?></td>
                <td><?= $row["jenis_kelamin"]; ?></td>
                <td><?= $row["nik"]; ?></td>
                <td><?= $row["nama_jurusan"]; ?></td>
                <td><?= $row["id_angkatan"]; ?></td>
                <td style="text-align: center;">
                    <a href="?page=mahasiswa&aksi=ubah&nim=<?= $row["nim"]; ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="?page=mahasiswa&aksi=hapus&nim=<?= $row["nim"]; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
<?php
            $i++;
        endforeach;
    } else {
        // Tampilkan pesan jika tidak ada data yang ditemukan
        echo '<tr><td colspan="8" class="text-center">Tidak ada data yang ditemukan</td></tr>';
    }
}
?>
</tbody>

              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div> 

      <!-- modal insert -->
     <div class="modal fade" id="tambahModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #2298BE;">
            <h3 class="modal-title" id="tambahModalLabel">Download Data</h3>
          </div>
          <div class="modal-body">
             <form action="views/mahasiswa/export.php" method="POST" rol="form" enctype="multipart/form-data">
             <div class="form-group">
                <label for="nama">Pilih Prodi</label>
                <select name="prodi" class="form-control" id="prodi" required>             
                    <option value="">- Pilih -</option> 
                    <?php foreach ($jurusan as $row): ?>
                      <?php echo '<option name="prodi" value="'.$row["id_jurusan"].'">'.$row["nama_jurusan"].'</option>'; ?>
                    <?php endforeach; ?>                    
                    </select>
             </div>
             <div class="form-group">
              <label for="nama">Angkatan</label>
                <select name="angkatan" class="form-control" id="angkatan" required>             
                    <option value="">- Pilih -</option> 
                    <?php foreach ($angkatan as $akt): ?>
                      <?php echo '<option name="angkatan" value="'.$akt["id_angkatan"].'">'.$akt["id_angkatan"].'</option>'; ?>
                    <?php endforeach; ?>                    
                    </select>
             </div>
             <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="reset" name="tambah" class="btn btn-success">Reset</button>
                  <button type="submit" name="add" class="btn btn-primary">Download</button>
               </div>
             </form>
          </div>  
        </div>
      </div>
    </div><!-- modal insert close -->         
    </section>

 
</body>
</html>