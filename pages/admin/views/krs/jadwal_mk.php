<?php 
session_start();
  include "../../../../config/fungsi.php";
 $conn  = mysqli_connect("localhost","root","","siakadstiesulutbaru");

$id_semester = $_POST['prov_id'];
$nim = $_POST['nim'];


$mhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = '$nim'");
$datamhs = mysqli_fetch_assoc($mhs);

$query = mysqli_query($conn, "SELECT * FROM mahasiswa INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan WHERE nim = $nim");
$data = mysqli_fetch_assoc($query);

$periode = mysqli_query($conn, "SELECT * FROM semester WHERE status = 1");

$smt = mysqli_query($conn, "SELECT * FROM semester WHERE id_semester = '$id_semester'");
$prd = mysqli_fetch_assoc($smt);

 ?>



 <?php

if ($id_semester == null) {
     echo '<div style="background-color: #337ab7; color: #fff; padding: 10px;">
        MOHON MAAFT!! TIDAK ADA DATA YANG DITAMPILKAN
    </div>';
} else { ?>
     <center>
        <legend class="mt-3"><strong>KARTU RENCANA STUDI</strong></legend>

        <table>
            <tr>
                <td><strong>NIM</strong></td>
                <td>&nbsp;: <?php echo $datamhs['nim']; ?></td>
            </tr>
            <tr>
                <td><strong>Nama Lengkap</strong></td>
                <td>&nbsp;: <?php echo $datamhs['nama']; ?></td>
            </tr>
            <tr>
                <td><strong>Nama Prodi</strong></td>
                <td>&nbsp;: <?php echo $data['nama_jurusan']; ?> </td>
            </tr>
            <tr>
                <td><strong>Tahun Akademik (Semester)</strong></td>
                <td>&nbsp;: <?php echo $prd['nama_semester'] ?> </td>
            </tr>
        </table>
</center><br><br>

            <!-- /.box-header -->
            <div class="box-body">
                 <div class="box-body">
                
            </div>
            <div class="table-responsive">
                    <table class="table table-hover"> 
                        <tr>
                            <th>Aksi</th>
                            <th>No</th>
                            <th>Kode MatKul</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>SKS</th>
                        </tr>
                        <?php 
                            $jadwal = mysqli_query($conn, "SELECT * FROM jadwal
                               INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
                               INNER JOIN dosen ON jadwal.nip = dosen.nip
                               INNER JOIN khs ON jadwal.id_jadwal = khs.id_jadwal
                               INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
                               WHERE khs.nim = $datamhs[nim] AND khs.id_semester = '$id_semester'"); 


                        ?> 
                        <?php $no = 1; 
                              $jumlahSks = 0;
                             
                        ?>

                        <?php foreach ($jadwal as $row) : ?>
                            <tr>
                                <td>
                                  <?php $periode = mysqli_query($conn, "SELECT * FROM semester WHERE status = 1 And id_semester = $id_semester"); ?>
                                  <?php if (mysqli_num_rows($periode) == 1) { ?>
                                    <a href="#" class="btn btn-danger btn-xs disabled"><i class="glyphicon glyphicon-trash"></i></a>
                                  <?php } else { ?>
                                    <a href="?page=krs&aksi=hapus&id= <?= $row["id_khs"]; ?> " onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
        
                                  <?php } ?>
                                </td>

   
                                <td><?= $no++ ?></td>            
                                <td><?= $row['kode_mk'] ?></td>
                                <td><?= $row['nama_mk'] ?></td>
                                <td><?= $row['nama_kelas'] ?></td>
                                <td><?= $row['sks']; $jumlahSks+= $row['sks']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5" align="right"><strong>Jumlah SKS : </strong></td>
                            <td colspan="1"><strong><?= $jumlahSks; ?></strong></td>
                        </tr><br>
                        <div class="box-body">
                        <a href="views/krs/cetak.php?nim=<?php echo $datamhs['nim']; ?>&thn=<?php echo $id_semester ?>" class="btn btn-warning btn-ms ml-3" target="_blank">
                          <span class="glyphicon glyphicon-print"></span> Cetak
                        </a>


                         <?php
                        $periode = mysqli_query($conn, "SELECT * FROM approve WHERE status = 1 AND nim = '$nim' AND id_semester = '$id_semester'");
                        if (mysqli_num_rows($periode) == 1) :
                        ?>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#batal<?= $nim; ?>" id="confirmButton">
                                <i class="fa fa-check" id="icon"> Batal</i>
                            </a>
                        <?php else : ?>
                           <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#<?= $nim; ?>" id="confirmButton">
                            <i class="fa fa-times-circle" id="icon"> Aprove KRS</i>
                        
                        <?php endif; ?>


                        </div>
                        <br><br>
                          <!-- Modal Konfirmasi -->
                      <div class="example-modal">
                        <div id="<?= $nim ?>" class="modal fade" role="dialog" style="display:none;">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header" style="background: #2298BE;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title">Konfirmasi Aprove KRS</h3>
                              </div>
                              <div class="modal-body">
                                <h4 align="center" >Apakah anda yakin mengaprove KRS  <b> <?= $datamhs['nama'];?></b><strong><span class="grt"></span></strong> ?</h4>
                              </div>
                              <div class="modal-footer">
                                <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                <a href="views/krs/approve_aksi.php?action=konfirm&nim=<?=$nim ?>&id=<?= $id_semester ?>" class="btn btn-primary">Yes</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- Modal Konfirmasi -->

                       <!-- Modal Konfirmasi batal approve -->
                      <div class="example-modal">
                        <div id="batal<?= $nim ?>" class="modal fade" role="dialog" style="display:none;">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header" style="background: #2298BE;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title">Batal Aprove KRS</h3>
                              </div>
                              <div class="modal-body">
                                <h4 align="center" >Batal mengaprove KRS  <b> <?= $datamhs['nama'];?></b><strong><span class="grt"></span></strong> ?</h4>
                              </div>
                              <div class="modal-footer">
                                <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                 <a href="views/krs/approve_aksi.php?action=batal&nim=<?=$nim ?>&id=<?= $id_semester ?>" class="btn btn-primary">Yes</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- Modal batal -->
                    </table>
                </div>
            </div>
            
    </section>
<?php } ?>

   


