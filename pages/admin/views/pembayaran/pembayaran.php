<?php
  include "../../config/fungsi.php";
  $angkatan = mysqli_query($conn, "SELECT id_angkatan FROM angkatan");
  $jurusan = mysqli_query($conn, "SELECT id_jurusan,kode_jurusan,nama_jurusan FROM jurusan");

 
  $id_smt = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'");
  $data_idsmt = mysqli_fetch_assoc($id_smt);

$jenis_p = mysqli_query($conn, "SELECT * FROM jenis_pembayaran inner join nama_pembayaran on jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran");



 
?>

  
 <section class="content-header">
  <h1>
    Pembayaran Mahasiswa
    
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="#"> pembayaran</a></li>
    <li class="active"> pembayaran mahasiswa</li>
  </ol>    
  </section>

  <section class="content">
      <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                      <!-- <form method="POST">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="angkatan">Angkatan :</label>
                        <select name="angkatan" required class="form-control" id="angkatan" required>
                          <?php $_SESSION['filter_angkatan'] = $_POST['angkatan']; ?>
                          <option value="">-- Pilih -- </option>
                          <?php foreach ($angkatan as $row): ?>
                            <option value="<?php echo $row["id_angkatan"]; ?>"
                              <?= $_SESSION['filter_angkatan'] === $row['id_angkatan'] ? 'selected' : ''; ?>>
                              <?php echo $row["id_angkatan"]; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="jrs">Jurusan:</label>
                        <select name="jrs"class="form-control" id="jrs" required>
                          <?php $_SESSION['filter_prodi'] = $_POST['jrs']; ?>
                           <option value="">-- Pilih -- </option>
                          <?php foreach ($jurusan as $row): ?>
                            <option value="<?php echo $row["id_jurusan"]; ?>" 
                              <?= $_SESSION['filter_prodi'] === $row['id_jurusan'] ? 'selected' : ''; ?>>
                              <?php echo $row['nama_jurusan']; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label for="jrs">Jenis Pembayaran:</label>
                        <select name="jrs"class="form-control" id="jrs" required>
                          <?php $_SESSION['filter_prodi'] = $_POST['jrs']; ?>
                           <option value="">-- Pilih -- </option>
                          <?php foreach ($jenis_p as $row): ?>
                            <option value="<?php echo $row["id_jurusan"]; ?>" 
                              <?= $_SESSION['filter_prodi'] === $row['id_jenisPembayaran'] ? 'selected' : ''; ?>>
                              <?php echo $row['nama_pembayaran']; ?>
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
                </form> -->
                <ul class="nav pull-left">
                    <a href="?page=pembayaran&aksi=set_pembayaranPerAngkatan" type="button" class="btn btn-primary" ><i class="fa fa-plus"></i> SET PER ANGKATAN</a>
                    <a href="?page=pembayaran&aksi=set_pembayaranPerMahasiswa" type="button" class="btn btn-success" ><i class="fa fa-plus"></i> SET PER MAHASSISWA</a>
                </ul>   
             </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Akademik</th>
                                        <th>Jurusan</th>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>Payment Tipe</th>
                                        <th>Tagihan</th>
                                        <th>Jumlah Terbayar</th>
                                        <th>Status Pembayaran</th>
                                        <th>Status Aprove</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $jenis_pembayaran = mysqli_query($conn, "SELECT set_pembayaran.id_set,
                                      set_pembayaran.nim,
                                      set_pembayaran.id_jenisPembayaran,
                                      set_pembayaran.jumlah_bayar, 
                                      set_pembayaran.payment_tipe, 
                                      set_pembayaran.jumlah_yangdibayar,
                                      set_pembayaran.approved,
                                      mahasiswa.nim,
                                      mahasiswa.nama,
                                      mahasiswa.id_jurusan,
                                      mahasiswa.id_angkatan,
                                      jenis_pembayaran.id_jenisPembayaran,
                                      jenis_pembayaran.id_pembayaran,
                                      jenis_pembayaran.id_semester,
                                      jurusan.id_jurusan,
                                      jurusan.nama_jurusan,
                                      semester.nama_semester,
                                      jenis_pembayaran.id_jenisPembayaran,
                                      jenis_pembayaran.id_pembayaran,
                                      nama_pembayaran.id_pembayaran,
                                      nama_pembayaran.nama_pembayaran 
                                      FROM set_pembayaran
                                      INNER JOIN mahasiswa ON set_pembayaran.nim = mahasiswa.nim
                                      INNER JOIN jenis_pembayaran ON set_pembayaran.id_jenisPembayaran = jenis_pembayaran.id_jenisPembayaran
                                      INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
                                      INNER JOIN semester ON set_pembayaran.id_semester = semester.id_semester 
                                      INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran WHERE set_pembayaran.id_semester = '$data_idsmt[id_semester]'");


                                    $no = 1;
                                    while ($dataJenisPembayaran = mysqli_fetch_assoc($jenis_pembayaran)) { ?>

                                    <tr>
                                      <td><?= $no++ ?></td>
                                      <td><?= $dataJenisPembayaran['nama_semester'] ?></td>          
                                      <td><?= $dataJenisPembayaran['nama_jurusan'] ?></td>                
                                      <td><?= $dataJenisPembayaran['nim'] ?></td>
                                      <td><?= $dataJenisPembayaran['nama'] ?></td>
                                      <td><?= $dataJenisPembayaran['payment_tipe'] ?> || <?= $dataJenisPembayaran['nama_pembayaran'] ?></td>
                                      <td>Rp. <?= number_format($dataJenisPembayaran['jumlah_bayar']) ?></td>
                                      <td>Rp. <?= number_format($dataJenisPembayaran['jumlah_yangdibayar']) ?></td>
                                      
                                      <?php if (floatval($dataJenisPembayaran['jumlah_yangdibayar']) < floatval($dataJenisPembayaran['jumlah_bayar'])): ?>
                                          <td><a href="#" class=" btn btn-xs btn-danger">BELUM LUNAS</a></td>
                                      <?php else: ?>
                                         <td><a href="#" class=" btn btn-xs btn-success">LUNAS</a></td>
                                      <?php endif; ?>
                                       <?php if ($dataJenisPembayaran['approved'] == 1): ?>
                                            <td><a href="#" class=" btn btn-xs btn-success"> APPROVED</a></td>
                                          <?php else : ?>
                                               <td><a href="#" class=" btn btn-xs btn-warning"> BELUM DIUPPROVE</a></td>
                                        <?php endif ?>
                                                  



                                      <td style="text-align: center;">
                                        <a href="?page=pembayaran&aksi=inputPembayaranMhs&id_set=<?= $dataJenisPembayaran['id_set'] ?>&nim=<?=$dataJenisPembayaran['nim'] ?>&id_jenis=<?= $dataJenisPembayaran['id_jenisPembayaran'] ?>" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-edit"></i> Bayar</a>
                                        
                                       <a href="?page=pembayaran&aksi=ubah_setPembayaranMhs&nim=<?= $dataJenisPembayaran['nim'] ?>&id_set=<?= $dataJenisPembayaran['id_set'] ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Ubah</a>

                                       <a href="?page=pembayaran&aksi=hapus_setPembayaran&id_set=<?= $dataJenisPembayaran['id_set'] ?>"onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Hapus</a>

                                        <a href="" data-toggle="modal" data-target="#detail<?= $dataJenisPembayaran['id_set'] ?>"class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-search"></i> Detail</a>
                                      </td>
                                    </tr>
                                    <!-- batal transaksi -->
                                    <div class="example-modal">
                                    <div id="detail<?= $dataJenisPembayaran['id_set'] ?>" class="modal fade" role="dialog" style="display:none;">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header" style="background: #2298BE;">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h3 class="modal-title">DETAIL</h3>
                                          </div>
                                          <div class="modal-body">
                                            <form>
                                              <label>Jenis Pembayaran</label>
                                              <label>:</label>
                                              <label>UKT</label>
                                              
                                            </form>
                                            
                                          </div>
                                          <div class="modal-footer">
                                            <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div><!-- end modal batal transaksi --> 
                                    <?php } ?> 
                                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

     