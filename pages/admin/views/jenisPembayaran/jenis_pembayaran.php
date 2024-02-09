<?php 
  include "../../config/fungsi.php";

 $data = mysqli_query($conn, "SELECT * FROM jenis_pembayaran inner join nama_pembayaran on jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran inner join semester on jenis_pembayaran.id_semester = semester.id_semester");

 $d = mysqli_fetch_assoc($data);
 
 $query_semester = mysqli_query($conn, "SELECT * FROM semester");


 $query_namaPembayaran = mysqli_query($conn,"SELECT * from nama_pembayaran");
 $smt_aktf = mysqli_query($conn,"SELECT * from semester WHERE status = '1'");
 $d_smt = mysqli_fetch_object($smt_aktf);

 ?>


  
 <section class="content-header">
  <h1>
    Manajemen Keuangan
    
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="#"> Set Keuangan</a></li>
    <li class="active"> Jenis Pembayaran</li>
  </ol>    
  </section>

  <section class="content">
      <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">JENIS PEMBAYARAN</h3>
                        <ul class="nav pull-right">
                            <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fa fa-plus"></i> Tambah Data</a>
                        </ul>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pembayaran</th>
                                        <th>Semester</th>
                                        <th>Tipe</th>
                                        <th>Payment</th>
                                        <th>Set Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	$no = 1;
                                	foreach($data as $d) : ?>
                                        <tr>
                                            <td style="text-align: center;" width="10px"><?= $no++ ?></td>
                                            <td><?= $d['nama_pembayaran'] ?></td>
                                            <td><?= $d['nama_semester'] ?></td>
                                            <td><?= $d['payment_tipe'] ?></td>
                                            <td><?= number_format($d['payment']) ?></td>
                                            <td><?= $d['deadline_time'] ?></td>
                                            <td>
                                                <a href="?page=jenis_pembayaran&aksi=edit&id=<?= $d["id_jenisPembayaran"]; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>
                                                </a>

                                               <a href="?page=jenis_pembayaran&aksi=hapus&id=<?= $d["id_jenisPembayaran"]; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i>
                                               </a>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

     <!-- modal insert -->
     <div class="modal fade" id="tambahModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #2298BE;">
            <h3 class="modal-title" id="tambahModalLabel">Tambah Jenis Pembayaran</h3>
          </div>
          <div class="modal-body">
             <form action="views/jenisPembayaran/tambah.php" method="POST" role="form" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" name="semester" value="<?php echo $d_smt->id_semester ?>">
                    <label for="id_pembayaran">Jenis Pembayaran</label>
                    <select name="id_pembayaran" class="form-control" required>
                        <option>-- Pilih Semester --</option>
                        <?php foreach ($query_namaPembayaran as $a) : ?>
                            <option value="<?= $a['id_pembayaran'] ?>"><?= $a['nama_pembayaran'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" class="form-control" name="smt" value="<?= $d_smt->nama_semester; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="tipe">Tipe</label>
                    <select name="tipe" class="form-control" required>
                        <option value="#">-- Pilih --</option>
                        <option value="SEMESTER">SEMESTER</option>
                        <option value="BULAN">BULAN</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="biaya">Biaya</label>
                    <input type="text" name="biaya" id="biayaInput" class="form-control" required oninput="formatBiaya()" onfocusout="formatBiaya()">
                </div>
                <div class="form-group">
                    <label for="deadline">Pilih Waktu Deadline:</label>
                    <input type="datetime-local" id="deadline" class="form-control" name="deadline" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="reset" name="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" name="tambah_jenis" class="btn btn-success">Tambah</button>
                </div>
            </form>

            <script>
                function formatBiaya() {
                    // Tambahkan logika format biaya jika diperlukan
                    // Contoh: jika biaya dalam format angka, tambahkan separator ribuan
                }
            </script>

          </div>  
        </div>
      </div>
    </div><!-- modal insert close --> 

    </section>

 
