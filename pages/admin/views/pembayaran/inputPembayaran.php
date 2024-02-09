<?php 
$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

// Mendapatkan dan membersihkan nilai id_set
$id_set = isset($_GET['id_set']) ? $_GET['id_set']  : '';
$id_jenis = isset($_GET['id_jenis']) ? $_GET['id_jenis']  : '';
$id_set = mysqli_real_escape_string($conn, $id_set);
$id_jenis = mysqli_real_escape_string($conn, $id_jenis);

$nim_GET = $_GET['nim'];

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
    set_pembayaran.approved, 
    semester.id_semester, 
    semester.nama_semester, 
    mahasiswa.nim, 
    mahasiswa.nama, 
    mahasiswa.id_jurusan,
    mahasiswa.foto,
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
    WHERE set_pembayaran.id_set = ?");

// Mengaitkan nilai parameter
mysqli_stmt_bind_param($query_Nimset, "i", $id_set);

// Mengeksekusi statement
mysqli_stmt_execute($query_Nimset);

// Mendapatkan hasil query
$result = mysqli_stmt_get_result($query_Nimset);

// Mengambil data sebagai asosiatif array
$data_Nimset = mysqli_fetch_assoc($result);


 ?>


<div class="content">
    <section class="content-header">
        <h1>
          STUDENT PAYMENT TRANSACTIONS
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">STUDENT INFORMATION</h3>
                                <!-- <a href="" target="_blank" class="btn btn-warning btn-xs pull-right"><i class="fa fa-print"></i> Cetak Semua Tagihan</a> -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-9">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td width="200">TAHUN AJARAN</td>
                                            <td width="4">: </td>
                                            <td><?= $data_Nimset['nama_semester'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>NIM</td>
                                            <td>:</td>
                                            <td><?= $data_Nimset['nim'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>NAME</td>
                                            <td>:</td>
                                            <td><?= $data_Nimset['nama'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>MAJOR</td>
                                            <td>:</td>
                                            <td><?= $data_Nimset['nama_jurusan'] ?></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                               
                                <img src="../../assets/img/<?= $data_Nimset["foto"]; ?>" class="img-thumbnail img-responsive" width="200">     
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">TRANSACTION HISTORY</h3>
                                </div>
                                <!-- /.box-header -->
                               
                                <form action="" method="POST">  
                                <div class="box-body">
                                     <table class="table table-responsive table-bordered" style="white-space: nowrap;">
                                        <tr class="success">
                                            <th>No</th>
                                            <th>Payment</th>
                                            <th>Date</th>
                                            <th>Jenis P</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php
                                        $no = 1;

                                        $nim = mysqli_real_escape_string($conn, $nim_GET);

                                        $id_smt = mysqli_query($conn, "SELECT id_semester,nama_semester,status FROM semester WHERE status = '1'");
                                        $d_pisah = mysqli_fetch_assoc($id_smt);
                                        $d_smt = $d_pisah['id_semester'];

                                        $query_histori = mysqli_query($conn, "SELECT
                                        histori_transaksi.id_histori,
                                        histori_transaksi.nim,
                                        histori_transaksi.update_date,
                                        histori_transaksi.id_tahunAkademik,
                                        histori_transaksi.jumlah_historiyangdibayar,
                                        histori_transaksi.id_jenisPembayaran,
                                        histori_transaksi.return,
                                        jenis_pembayaran.id_jenisPembayaran,
                                        jenis_pembayaran.id_pembayaran,
                                        nama_pembayaran.id_pembayaran,
                                        nama_pembayaran.nama_pembayaran
                                        FROM histori_transaksi 
                                        INNER JOIN semester ON histori_transaksi.id_tahunAkademik = semester.id_semester
                                        INNER JOIN jenis_pembayaran ON histori_transaksi.id_jenisPembayaran = jenis_pembayaran.id_jenisPembayaran
                                        INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran 
                                        WHERE histori_transaksi.nim = '$nim' AND histori_transaksi.id_tahunAkademik = '$d_smt' AND id_set = '$id_set'");


                                
                                        foreach ($query_histori as $data) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>Rp. <?= number_format($data['jumlah_historiyangdibayar']) ?></td>
                                                <td><?= $data['update_date'] ?></td>
                                                <td><?= $data['nama_pembayaran'] ?></td>
                                               
                                                </td>

                                                <?php if ($data['return'] == 1) : ?>
                                                      <td><a href="#" class=" btn btn-xs btn-danger" disabled >Direturn</a></td>
                                                <?php elseif ($data_Nimset['approved'] == 1): ?>
                                                <td>
                                                    <a href="#" class=" btn btn-xs btn-warning" disabled >FINAL</a>
                                                </td>
                                                <?php else : ?>  
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#id_histori<?= $data['id_histori'] ?>"><i class="glyphicon glyphicon-edit"></i> RETURN
                                                      </a>
                                                </td>

                                                  <?php endif; ?>
                                            </tr>
                                            <!-- batal transaksi -->
                                    <div class="example-modal">
                                    <div id="id_histori<?= $data['id_histori'] ?>" class="modal fade" role="dialog" style="display:none;">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header" style="background: #2298BE;">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h3 class="modal-title">KONFIRMASI BATAL TRANSAKSI</h3>
                                          </div>
                                          <div class="modal-body">
                                            <h4 align="center" >Apakah anda yakin ingin membatalkan  <b> TRANSAKSI <?= $data['id_histori'] ?></b><strong><span class="grt"></span></strong> ?</h4>
                                             <?php $return = 1; ?>
                                            <form action="views/pembayaran/batal_transaksi.php" method="POST">
                                                <input type="hidden" name="return" value="1">
                                                <input type="hidden" name="id_set" value="<?php echo $id_set ?>">
                                            </form>
                                          </div>
                                          <div class="modal-footer">
                                            <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                            <a href="?page=pembayaran&aksi=batal_transaksi&id_histori=<?= $data['id_histori'] ?>&id_set=<?= $id_set ?>&return=<?php echo $return ?>" class="btn btn-primary">Ok</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div><!-- end modal batal transaksi --> 
                                        <?php endforeach; ?>

                                    </table>

                                </div>
                                </form>
                            </div>
                        </div>
               
                        <div class="col-md-3">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">PAYMENT</h3>
                                </div>
                                <?php
// Mengambil waktu deadline terbaru
$query = "SELECT deadline_time FROM semester WHERE id_semester = $d_smt";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$deadline = $row['deadline_time'];


// Cek apakah waktu deadline sudah lewat
?>
<?php if (strtotime($deadline) < time()) { ?>

    <h3 style="text-align: center; margin-bottom: 10px; margin-top: 10px; color: red;"><b>T I M E O U T</b></h3>
   
<?php } else { ?>
    <div class="box-body">
        <form method="POST" action="views/pembayaran/proses_pembayaranMhs.php">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Total</label>
                        <input type="hidden" name="id_tahunAkademik" value="<?= $data_Nimset['id_semester'] ?>">
                        <input type="hidden" name="nim" value="<?= $data_Nimset['nim'] ?>">
                        <input type="hidden" name="id_set" value="<?php echo $id_set ?>">
                         <?php 
                         $hasil = $data_Nimset['jumlah_bayar'] - $data_Nimset['jumlah_yangdibayar']

                         ?>
                        <input type="text" class="form-control numeric" value="<?= number_format($hasil) ?>" name="harga" id="harga" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dibayar</label>
                        <input type="text" name="transaksi" id="biayaInput"class="form-control" required oninput="formatBiaya()" onfocusout="formatBiaya()">
                    </div>
                </div>
                 <input class="form-control"  required="" type="hidden" name="d" value="<?php echo date('Y-m-d') ?>">
            </div>
            <!-- <div class="form-group">
                <input type="file" name="bukti" class="form-control" required>
            </div> -->
            <div class="form-group">
                <?php if ($hasil == 0) { ?>
                <button class="btn btn-danger btn-block" type="submit" disabled> NO BILLING</button>
               <?php }else{ ?>
                <button class="btn btn-success btn-block" type="submit" name="bayar"> PAY</button>
                <?php } ?>
            </div>
        </form>
    </div>


<?php } ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">DATE</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form action="" method="GET" class="view-pdf">
                                        <input type="hidden" name="n" value="">
                                        <input type="hidden" name="r" value="">
                                        <div class="form-group">
                                            <label>Transaction Date</label>
                                            <div class="input-group date " data-date="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input class="form-control" readonly="" required="" type="date" name="d" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <!-- <button class="btn btn-success btn-block" formtarget="_blank" type="submit"><i class="fa fa-print"></i> Cetak Bukti Pembayaran</button> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                        <!-- List Tagihan Bulanan -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">TRANSACTION REPORTS </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="success">
                                                <th>No.</th>
                                                <th>Academic Year</th>
                                                <th>Payment Name</th>
                                                <th>Total Tagihan</th>
                                                <th>Total Bill</th>
                                                <th>Payment Date</th>
                                                <th>Status</th>
                                                <th colspan="2">Status Approved</th>  
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $nim = mysqli_real_escape_string($conn, $data_Nimset['nim']);


                                            $query_data = mysqli_query($conn, "SELECT * FROM set_pembayaran 
                                                INNER JOIN semester ON set_pembayaran.id_semester = semester.id_semester
                                                INNER JOIN jenis_pembayaran ON set_pembayaran.id_jenisPembayaran = jenis_pembayaran.id_jenisPembayaran 
                                                INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran
                                                 WHERE nim = '$nim' AND set_pembayaran.id_set = $id_set ");


                                             ?>
                                            <?php $no = 1;  ?>
                                            <?php foreach($query_data as $data) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $data['nama_semester'] ?></td>
                                                    <td><?= $data['nama_pembayaran'] ?></td>
                                                    <td>Rp. <?= number_format($data['jumlah_bayar']) ?></td>
                                                    <td>Rp. <?= number_format($data['jumlah_yangdibayar']) ?></td>
                                                    <td><?= $data['update_date_pembayaran'] ?></td>
                                                   
                                                    <?php if (floatval($data['jumlah_yangdibayar']) < floatval($data['jumlah_bayar'])): ?>
                                                      <td><a href="#" class=" btn btn-xs btn-danger">BELUM LUNAS</a></td>
                                                  <?php else: ?>
                                                     <td><a href="#" class=" btn btn-xs btn-success">LUNAS</a></td>
                                                  <?php endif; ?>
                                                  
                                                 <?php 
                                                 $hasil = $data_Nimset['jumlah_bayar'] - $data_Nimset['jumlah_yangdibayar'];

                                                ?>


                                               



                                                  <?php if ($hasil == 0): ?>
                                                    <td>
                                                    <a href="#" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#id_set<?= $data['id_set'] ?>">APPROVE
                                                      </a>
                                                    </td>
                                                    <?php if ($data['approved'] == 1) : ?>
                                                        <td><a href="#" class="btn btn-xs btn-success">APPROVED</a></td>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                     <!-- batal transaksi -->
                                    <div class="example-modal">
                                    <div id="id_set<?= $data['id_set'] ?>" class="modal fade" role="dialog" style="display:none;">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header" style="background: #2298BE;">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h3 class="modal-title">KONFIRMASI APPROVE</h3>
                                          </div>
                                          <div class="modal-body">
                                            <h4 align="center" >Apakah anda yakin akan MENGAPPROVE <b><?= $data['nim'] ?></b><strong><span class="grt"></span></strong> ?</h4>
                                            <?php $nilai = 1 ?>
                                            <form action="views/pembayaran/approve_pembayaran.php" method="POST">
                                                
                                                <input type="hidden" name="id_set" value="<?= $data['id_set'] ?>">
                                            </form>
                                          </div>
                                          <div class="modal-footer">
                                            <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                            <a href="?page=pembayaran&aksi=approve_p&id_set=<?php echo $data['id_set']; ?>" class="btn btn-primary">Ok</a>

                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div><!-- end modal batal transaksi --> 


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
</div>

<div class="modal fade" id="update_transaksi">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #2298BE;">
            <h3 class="modal-title" id="update_transaksi">UPDATE TRANSAKSI</h3>
          </div>
          <div class="modal-body">
             <form action="views/mahasiswa/export.php" method="POST" rol="form" enctype="multipart/form-data">
             <div class="form-group">
                <label for="nama">Pilih Prodi</label>
             </div>
             <div class="form-group">
              <label for="nama">Angkatan</label>
             </div>
             <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="reset" name="tambah" class="btn btn-success">Upate</button>
               </div>
             </form>
          </div>  
        </div>
      </div>
    </div><!-- modal insert close --> 




