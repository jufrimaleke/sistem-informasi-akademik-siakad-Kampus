
 
 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="callout callout-success">
    <h4>Selamat Datang  -
      <?php 
      if (isset($_SESSION['admin'])) {
      echo $_SESSION['admin']; 
      }else if (isset($_SESSION['dosen'])) { 
        echo $_SESSION['nama'];
      }else if (isset($_SESSION['mahasiswa'])) { 
        echo $_SESSION['nama'];
      }else if (isset($_SESSION['operator'])) { 
        echo $_SESSION['nama'];
      }  

      ?> 
  </div>
  <?php 
  if (isset($_SESSION["admin"])) { ?>
                      
  <?php
  include "../../config/koneksi.php";

  function countUsers($table, $column) {
    global $conn;
    $query = "SELECT COUNT($column) AS total FROM $table";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
  }

  $jml_mahasiswa = countUsers('mahasiswa', 'nim');
  $jml_dosen = countUsers('dosen', 'nip');

  ?>

<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?= $jml_mahasiswa ?></h3>
        <p>User Mahasiswa</p>
      </div>
      <div class="icon">
        <i class="fa fa-user"></i>
      </div>
      <a href="http://localhost/siakadstiks/pages/admin/index.php?page=mahasiswa" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?= $jml_dosen ?></h3>
        <p>User Dosen</p>
      </div>
      <div class="icon">
        <i class="fa fa-user"></i>
      </div>
      <a href="http://localhost/siakadstiks/pages/admin/index.php?page=dosen" class="small-box-footer">More info <i class="fa fa-users-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <?php 

          $prd = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'"); 
          $data = mysqli_fetch_assoc($prd); 
          $idPrd = $data['id_semester'];
          $prdAk = $data['nama_semester'];
          

          $query = "SELECT * FROM approve WHERE id_semester = '$idPrd'";
          $result = mysqli_query($conn, $query); 
          $count = mysqli_num_rows($result); 

        ?>
        <h3><?= $count ?></h3>
         <p>KRS Prd Aktif : <?= $prdAk ?></p>
          
       
        <p> </p>
      </div>
      <div class="icon">
        <i class="fa fa-check"></i>
      </div>
      <a href="http://localhost/siakadstiks/pages/admin/index.php?page=laporan&aksi=lap_krs" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3>1</h3>
        <p>User Lainnya</p>
      </div>
      <div class="icon">
        <i class="fa fa-user"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
  
      

<div class="box box-primary">
<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        
        <div style="width: 80%; margin: 0 auto;">
          <canvas id="myChart"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Data yang akan digunakan untuk grafik
            var data = {
                labels: ["Periode 2021-1", "Periode 2021-2", "Periode 2022-1", "Periode 2022-2"],
                datasets: [
                        {
                        label: "Grafik Kuesioner Mahasiswa",
                        data: [200, 70, 60, 300],
                      
                        borderWidth: 2,
                        fill: false
                    }
                ]
            };

            // Konfigurasi grafik
            var options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            // Membuat dan menggambar grafik
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: options
            });
        </script><br>
        
        <a href="#" class="btn btn-primary btn-sm">More Info</a>
      </div><br>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
       
        <div style="width: 80%; margin: 0 auto;">
          <canvas id="myChart2"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Data yang akan digunakan untuk grafik
            var data = {
                labels: ["Periode 2021-1", "Periode 2021-2", "Periode 2022-1", "Periode 2022-2"],
                datasets: [
                        {
                        label: "Grafik Jumlah Mahasiswa Per Periode",
                        data: [60, 500, 5, 60],
                        borderColor: "green",
                        borderWidth: 2,
                        fill: false
                    }
                ]
            };

            // Konfigurasi grafik
            var options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            // Membuat dan menggambar grafik
            var ctx = document.getElementById('myChart2').getContext('2d');
            var myChart2 = new Chart(ctx, {
                type: 'line',
                data: data,
                options: options
            });
        </script><br>
        
        <a href="#" class="btn btn-primary btn-sm">More Info</a>
      </div>
    </div>
  </div>
</div>
</div>
</div>
    <!-- /.box-body -->
</div>
</div>
</div>
</div>
</div>
 
<?php } else{ 

if (isset($_SESSION['mahasiswa'])) {
 
$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

// $conn  = mysqli_connect("localhost","stiz4159_Adminsiakad","Siakadstie@56","stiz4159_siakad");
$prd = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'"); 
          $data = mysqli_fetch_assoc($prd); 
          $prdAk = $data['nama_semester'];


$nim = $_SESSION['nim'];

// Membuat prepared statement
$query_Nimset = mysqli_prepare($conn, "SELECT 
    set_pembayaran.id_set, 
    set_pembayaran.nim, 
    set_pembayaran.id_semester,
    set_pembayaran.id_jenisPembayaran,
    set_pembayaran.jumlah_bayar,
    set_pembayaran.jumlah_yangdibayar,
    set_pembayaran.payment_tipe,
    set_pembayaran.set_time_update, 
    semester.id_semester, 
    semester.nama_semester, 
    mahasiswa.nim, 
    mahasiswa.nama, 
    mahasiswa.id_jurusan, 
    jurusan.id_jurusan, 
    jurusan.nama_jurusan,
    jenis_pembayaran.id_jenisPembayaran,
    jenis_pembayaran.id_pembayaran,
    nama_pembayaran.id_pembayaran,
    nama_pembayaran.nama_pembayaran 
    FROM set_pembayaran 
    INNER JOIN semester ON set_pembayaran.id_semester = semester.id_semester
    INNER JOIN mahasiswa ON set_pembayaran.nim = mahasiswa.nim
    INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
    INNER JOIN jenis_pembayaran ON set_pembayaran.id_jenisPembayaran = jenis_pembayaran.id_jenisPembayaran
    INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran
    WHERE set_pembayaran.nim = ?");

// Mengaitkan nilai parameter
mysqli_stmt_bind_param($query_Nimset, "i", $nim);

// Mengeksekusi statement
mysqli_stmt_execute($query_Nimset);

// Mendapatkan hasil query
$result = mysqli_stmt_get_result($query_Nimset);

// Mengambil data sebagai asosiatif array
$data_Nimset = mysqli_fetch_assoc($result);

 ?>



  
        <div class="row">
            <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-warning">
                                <div class="box-header with-border bg-aqua">
                                    <h3 class="box-title">Transaksi Terakhir</h3>
                                </div>
                                <!-- /.box-header -->
                                <form action="" method="POST">
                                <div class="box-body">
                                     <table class="table table-responsive table-bordered" style="white-space: nowrap;">
                                        <tr class="success"> 
                                            <th>Nim</th>
                                            <th>Jumlah bayar</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        <?php 
                                        $no = 1;
                                        $query_histori = mysqli_query($conn, "SELECT * FROM histori_transaksi WHERE nim = '$nim'"); 
                                          foreach ($query_histori as $data) :?>
                                            <tr>
                                                
                                                <td><?= $data['nim'] ?></td>
                                                <td><?= number_format($data['jumlah_historiyangdibayar']) ?></td>
                                                <td><?= $data['update_date'] ?></td>
                                                
                                            </tr>
                                          <?php endforeach; ?>
                                    </table>

                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box box-danger">
                                <div class="box-header with-border bg-danger">
                                    <h3 class="box-title">Pengumuman</h3>
                                </div>


                                <?php 
                                $query_pengumuman = mysqli_query($conn, "SELECT nama_pengumuman, jenis_pengumuman, isi_pengumuman FROM pengumuman WHERE tujuan = '2' AND status_post = '1'"); 
                                $data_p = mysqli_fetch_object($query_pengumuman);
                                ?>

                                <?php if (mysqli_num_rows($query_pengumuman) == 1): ?>
                                    <div class="box-body">
                                        <div class="box-header with-border bg-warning">
                                            <h3 class="box-title" style="text-transform: uppercase;"><b><?php echo $data_p->jenis_pengumuman ?></b></h3>
                                        </div>
                                        <p>
                                            <?php echo $data_p->isi_pengumuman ?>
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <div class="box-body">
                                        <div class="box-header with-border bg-warning">
                                            <h3 class="box-title" style="text-transform: uppercase;"><b>belum ada pengumuman</b></h3>
                                        </div>
                                        <p>
                                            Empty
                                        </p>
                                    </div>
                                <?php endif ?>

                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">KRS PERIODE AKTIF <b><?php echo $prdAk ?></b></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        
                            
                                            <?php
                                            $periode = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'");
                                            $d = mysqli_fetch_assoc($periode);

                                            $jadwal = mysqli_query($conn, "SELECT * FROM jadwal
                                                INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
                                                INNER JOIN khs ON jadwal.id_jadwal = khs.id_jadwal
                                                WHERE khs.nim = $nim AND khs.id_semester = {$d['id_semester']}");

                                            if (mysqli_num_rows($jadwal) > 0) {
                                                $jumlahSks = 0;
                                            ?>
                                              <table id="example2" class="table table-bordered table-hover">
                                                    <tr>
                                                        <th>Kode MK</th>
                                                        <th>Nama MK</th>
                                                        <th>SKS</th>
                                                    </tr>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($jadwal)) :
                                                    ?>
                                                        <tr>
                                                            <td><?= $row['kode_mk'] ?></td>
                                                            <td><?= $row['nama_mk'] ?></td>
                                                            <td><?= $row['sks'];
                                                                $jumlahSks += $row['sks']; ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                    <tr>
                                                        <td colspan="2" align="right"><strong>Jumlah SKS : </strong></td>
                                                        <td><strong><?= $jumlahSks; ?></strong></td>
                                                    </tr>
                                                </table>
                                            <?php
                                            } else {
                                                echo "<tr><td colspan='3'><b>ANDA BELUM MENGISI KRS</b></td></tr>";
                                            }
                                            ?>
  
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                        <!-- List Tagihan Bulanan -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">TAGIHAN</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="success">
                                                <th>No.</th>
                                                <th>Tahun Akademik</th>
                                                <th>Nama Pembayaran</th>
                                                <th>Total Tagihan</th>
                                                <th>Total Pembayaran</th>
                                                <th>Tanggal Bayar</th>
                                                <th>Status</th> 
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $nim = mysqli_real_escape_string($conn, $data_Nimset['nim']);
                                            $query_data = mysqli_query($conn, "SELECT * FROM set_pembayaran inner join semester ON set_pembayaran.id_semester = semester.id_semester WHERE nim = '$nim'");


                                             ?>
                                            <?php $no = 1;  ?>
                                            <?php foreach($query_data as $data) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $data['nama_semester'] ?></td>
                                                    <td><?= $data_Nimset['nama_pembayaran'] ?></td>
                                                    <td><?= number_format($data['jumlah_bayar']) ?></td>
                                                    <td><?= number_format($data['jumlah_yangdibayar']) ?></td>
                                                    <td><?= $data['update_date_pembayaran'] ?></td>
                                                   
                                                    <?php if (floatval($data['jumlah_yangdibayar']) < floatval($data['jumlah_bayar'])): ?>
                                                      <td><a href="#" class=" btn btn-xs btn-danger">BELUM LUNAS</a></td>
                                                  <?php else: ?>
                                                     <td><a href="#" class=" btn btn-xs btn-success">LUNAS</a></td>
                                                  <?php endif; ?>
                                                  

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
                   
            </div>
        </div>
    </section>


<?php } else{ 

if (isset($_SESSION['dosen'])) {
 
$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

// $conn  = mysqli_connect("localhost","stiz4159_Adminsiakad","Siakadstie@56","stiz4159_siakad");
$prd = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'"); 
          $data = mysqli_fetch_assoc($prd); 
          $nama_prd = $data['nama_semester'];
          $id_prd = $data['id_semester'];


$nip = $_SESSION['nip'];

$query_jadwal = mysqli_query($conn, "SELECT * FROM jadwal
                INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
                INNER JOIN jurusan ON jadwal.id_jurusan = jurusan.id_jurusan
                INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
                INNER JOIN paket_semester ON jadwal.id_paketSemester = paket_semester.id_paket
                INNER JOIN semester ON jadwal.id_semester = semester.id_semester
               
                WHERE jadwal.nip = '$nip' AND jadwal.id_semester = '$id_prd'");

$hitung = mysqli_num_rows($query_jadwal);


 ?>

        <div class="row">
            <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="box box-warning">
                                <div class="box-header with-border bg-aqua">
                                    <h3 class="box-title">JUMLAH MATAKULIAH MENGAJAR DISEMESTE AKTIF</h3>
                                </div>

                                 

                                <!-- /.box-header -->
                                <form action="" method="POST">
                               <div class="table-responsive">
                                      <table id="example2" class="table table-bordered table-striped">
                                        <tr class="success">
                                            <th>No</th>
                                            <th>Periode</th> 
                                            <th>Kode MK</th> 
                                            <th>Nama MK</th>
                                            <th>SKS</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Jumlah MHS</th>
                                        </tr>
                                        <?php 
                                        $no = 1;
                                        foreach($query_jadwal as $data) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $data['nama_semester'] ?></td>
                                                <td><?= $data['kode_mk'] ?></td>
                                                <td><?= $data['nama_mk'] ?></td>
                                                <td><?= $data['sks'] ?></td>
                                                <td><?= $data['nama_kelas'] ?></td>
                                                <td><?= $data['nama_jurusan'] ?></td>
                                                <?php
                                                  $select = "SELECT COUNT(nim) FROM khs WHERE id_jadwal = $data[id_jadwal]";
                                                  $query = mysqli_query($conn, $select);
                                                  $data = mysqli_fetch_assoc($query);
                                                  $jml = $data['COUNT(nim)'];
                                                  ?>
                                                  <?php if ($jml == 0) : ?>
                                                    <td align>
                                                     <a href="#" disabled ><span class="btn btn-danger">Belum ada peserta</span></a>
                                                     </td>
                                                    <?php else : ?>
                                                    
                                                      <td><?= $jml ?></td>
                                                    
                                                <?php endif ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="box box-danger">
                                <div class="box-header with-border bg-danger">
                                    <h3 class="box-title">PENGUMUMAN</h3>
                                </div>
                             
                                    <div class="box-body">
                                        
                                        <?php 
                                $query_pengumuman = mysqli_query($conn, "SELECT nama_pengumuman, jenis_pengumuman, isi_pengumuman FROM pengumuman WHERE tujuan = '1' AND status_post = '1'"); 
                                $data_p = mysqli_fetch_object($query_pengumuman);
                                ?>

                                <?php if (mysqli_num_rows($query_pengumuman) == 1): ?>
                                    <div class="box-body">
                                        <div class="box-header with-border bg-warning">
                                            <h3 class="box-title" style="text-transform: uppercase;"><b><?php echo $data_p->nama_pengumuman ?></b></h3>
                                        </div>
                                        <p>
                                            <?php echo $data_p->isi_pengumuman ?>
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <div class="box-body">
                                        <div class="box-header with-border bg-warning">
                                            <h3 class="box-title" style="text-transform: uppercase;"><b>belum ada pengumuman</b></h3>
                                        </div>
                                        <p>
                                            Empty
                                        </p>
                                    </div>
                                <?php endif ?>
                                    </div>
                            </div>
                        </div>
                    </div>
                   
                        <!-- List Tagihan Bulanan -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">HISTORI MATAKULIAH MENGAJAR SETIAP SEMESTER</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                        <div class="box-header">
                            <a href="?page=histori" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-search"></span> view</a>
                        </div>
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                 <div class="table-responsive">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="success">
                                                <th>No</th>
                                                <th>Periode</th> 
                                                <th>Kode MK</th> 
                                                <th>Nama MK</th>
                                                <th>SKS</th>
                                                <th>Kelas</th>
                                                <th>Jurusan</th>
                                                <th>Jumlah MHS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $query_jadwal = mysqli_query($conn, "SELECT * FROM jadwal
                                        INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
                                        INNER JOIN jurusan ON jadwal.id_jurusan = jurusan.id_jurusan
                                        INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
                                        INNER JOIN paket_semester ON jadwal.id_paketSemester = paket_semester.id_paket
                                        INNER JOIN semester ON jadwal.id_semester = semester.id_semester
                                        WHERE jadwal.nip = '$nip' LIMIT 5"); ?>

                                        <?php 
                                        $no =  1; 
                                        foreach($query_jadwal as $data) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $data['nama_semester'] ?></td>
                                                <td><?= $data['kode_mk'] ?></td>
                                                <td><?= $data['nama_mk'] ?></td>
                                                <td><?= $data['sks'] ?></td>
                                                <td><?= $data['nama_kelas'] ?></td>
                                                <td><?= $data['nama_jurusan'] ?></td>
                                                <?php
                                                  $select = "SELECT COUNT(nim) FROM khs WHERE id_jadwal = $data[id_jadwal]";
                                                  $query = mysqli_query($conn, $select);
                                                  $data = mysqli_fetch_assoc($query);
                                                  $jml = $data['COUNT(nim)'];
                                                  ?>
                                                  <?php if ($jml == 0) : ?>
                                                    <td align>
                                                     <a href="#" disabled ><span class="btn btn-danger">Belum ada peserta</span></a>
                                                     </td>
                                                    <?php else : ?>
                                                    
                                                      <td><?= $jml ?></td>
                                                    
                                                <?php endif ?>
                                           
                                            </tr>
                                         <?php endforeach; ?>
                                        </tbody>  
                                    </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
                   
            </div>
        </div>
    </section>

    
<?php } ?>

<?php } ?>



<?php } ?>
