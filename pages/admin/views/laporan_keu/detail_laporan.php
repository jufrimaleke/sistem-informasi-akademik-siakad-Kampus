<?php 
  include "../../config/fungsi.php";

$query_semester = mysqli_query($conn, "SELECT * FROM semester");

$id_semester = $_GET['id_laporan'];
$query_semester = mysqli_query($conn, "SELECT id_semester,nama_semester FROM semester");

$query_lap = mysqli_query($conn, "SELECT 
        set_pembayaran.id_set,
        set_pembayaran.nim,
        set_pembayaran.id_jenisPembayaran,
        set_pembayaran.id_semester,
        set_pembayaran.jumlah_bayar,
        set_pembayaran.jumlah_yangdibayar,
        set_pembayaran.payment_tipe,
        jenis_pembayaran.id_jenisPembayaran,
        jenis_pembayaran.id_pembayaran,
        nama_pembayaran.id_pembayaran,
        nama_pembayaran.nama_pembayaran,
        mahasiswa.nama,
        mahasiswa.id_jurusan,
        jurusan.id_jurusan,
        jurusan.nama_jurusan,
        semester.id_semester,
        semester.nama_semester
        FROM set_pembayaran
        INNER JOIN mahasiswa ON set_pembayaran.nim = mahasiswa.nim 
        INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
        INNER JOIN jenis_pembayaran ON set_pembayaran.id_jenisPembayaran = jenis_pembayaran.id_jenisPembayaran 
        INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran
        INNER JOIN semester ON set_pembayaran.id_semester = semester.id_semester
        WHERE set_pembayaran.id_semester = $id_semester");

$data = mysqli_fetch_object($query_lap);


$query = "SELECT SUM(jumlah_bayar) as total_bayar, SUM(jumlah_yangdibayar) as total_terbayar FROM set_pembayaran WHERE id_semester = $id_semester";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil dijalankan
if (!$result) {
    die("Error dalam query: " . mysqli_error($conn));
}

// Ambil nilai dari hasil query
$row = mysqli_fetch_assoc($result);

// Ambil nilai total pembayaran
$total_bayar = $row['total_bayar'];

$total_terbayar = $row['total_terbayar'];


$total_sisa_bayar = $total_bayar - $total_terbayar;
// Tutup koneksi
mysqli_close($conn);



?>

<?php if (mysqli_num_rows($query_lap) !== 0) { ?>

  
 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> laporan keuangan</li>
  </ol>    
  </section>
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box  box-success">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">LAPORAN KEUANGAN SEMESTER <b><?= $id_semester ?></b></h3>
                                <!-- <a href="" target="_blank" class="btn btn-warning btn-xs pull-right"><i class="fa fa-print"></i> Cetak Semua Tagihan</a> -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-9">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td width="200">TAHUN AJARAN</td>
                                            <td width="4">: </td>
                                            <td><?= $data->nama_semester ?></td>
                                        </tr>
                                        <tr>
                                            <td>TOTAL TAGIHAN</td>
                                            <td>:</td>
                                            <td>Rp. <?= number_format($total_bayar) ?></td>
                                        </tr>
                                        <tr>
                                            <td>TOTAL BELUM DIBAYAR</td>
                                            <td>:</td>
                                            <td>Rp. <?= number_format($total_sisa_bayar) ?></td>
                                        </tr>
                                        <tr>
                                            <td>TOTAL TERBAYAR</td>
                                            <td>:</td>
                                            <td>Rp. <?= number_format($total_terbayar) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <img src="../../assets/img/Logo2.png" class="img-responsive">   
                            </div>
                        </div>
                    </div>


            <div class="box-header">
              <ul class="nav pull-left">
                    <a href="views/laporan_keu/cetak_laporan.php?id_laporan=<?= $data->id_semester ?>" target="_blank" type="button" class="btn btn-primary" ><i class="fa fa-print"></i> CETAK</a>
                    
                </ul> 
            </div>
          <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr class="success">
                  <th>No</th>
                  <th>Nim</th>     
                  <th>Nama Mahasiswa</th>
                  <th>Tagihan</th>
                  <th>Pembayaran</th>
                  <th>Sisa Pembayaran</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $no = 1;
                while ($data_semester = mysqli_fetch_assoc($query_lap)) { ?>
            
                <tr>
                  <td><?= $no++ ?></td>                               
                  <td><?= $data_semester['nim'] ?></td>
                  <td><?= $data_semester['nama'] ?></td>
				  <td>Rp. <?= number_format($data_semester['jumlah_bayar']) ?></td>
				  <td>Rp. <?= number_format($data_semester['jumlah_yangdibayar']) ?></td>
				  <?php $total = $data_semester['jumlah_bayar'] - $data_semester['jumlah_yangdibayar'] ?>
				  <td>Rp. <?= number_format($total) ?></td>                 
                </tr>
                <?php } ?> 
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>

 
<?php } else {
echo '
    <section class="content">
    <div style="background-color: #337ab7; color: #fff; padding: 10px;">
        MOHON MAAFT!! TIDAK ADA LAPORAN KEUANGAN
    </div>
    </section>'; 
}
?>

