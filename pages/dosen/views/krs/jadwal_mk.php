<?php 
session_start();
  include "../../../../config/fungsi.php";
 $conn  = mysqli_connect("localhost","root","","siakadstiks");

$id_semester = $_POST['prov_id'];
$nim = $_POST['nim'];

$aprove = mysqli_query($conn, "SELECT nim,id_semester from approve where nim = $nim AND id_semester = $id_semester");


$mhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = '$nim'");
$datamhs = mysqli_fetch_assoc($mhs);

$query = mysqli_query($conn, "SELECT * FROM mahasiswa INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan WHERE nim = $nim");
$data = mysqli_fetch_assoc($query);

$periode = mysqli_query($conn, "SELECT * FROM semester WHERE status = 1");

$smt = mysqli_query($conn, "SELECT * FROM semester WHERE id_semester = '$id_semester'");
$prd = mysqli_fetch_assoc($smt);

 ?>

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
</center><br>

            <div>
            <div class="box-body">
            <div class="box-body">
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
                            </a>
                        <?php endif; ?>
            </div>
            <div class="table-responsive" align="center">
                    
                        <?php 
                            $jadwal = mysqli_query($conn, "SELECT * FROM jadwal
                               INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
                               INNER JOIN dosen ON jadwal.nip = dosen.nip
                               INNER JOIN khs ON jadwal.id_jadwal = khs.id_jadwal
                               INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
                               WHERE khs.nim = $datamhs[nim] AND khs.id_semester = $id_semester "); 
                        ?> 
                        
                  
                       
                    <table border="1px" class="tabel">
                        <tr>
                            <th align="center" style="padding:0 20px 0 20px;">No</th>
                            <th align="center" style="padding:0 40px 0 40px;">Kode MK</th>
                            <th align="center" style="padding:0 80px 0 80px;">Nama Matakuliah</th>
                            <th align="center" style="padding:0 30px 0 30px;">SKS</th>
                            <th align="center" style="padding:0 25px 0 25px;">Kelas</th>
                            
                            <?php $no = 1; $total_sks = 0; ?>
                            <?php foreach ($jadwal as $row) : ?>

                            <tr>
                                
                                <td align="center"><?= $no++ ?></td>
                                <td align="center"><?= $row["kode_mk"] ?></td>
                                <td><?= $row["nama_mk"] ?></td>
                                <td align="center"><?=$row["sks"] ?></td>
                                <td align="center"><?= $row["nama_kelas"]?></td>    
                            </tr>
                            <?php $total_sks = $total_sks + $row["sks"];  ?>
                             <?php endforeach; ?>

                          <tr>
                               <td colspan="4" style="text-align:center; background-color:#d5d6d6; color:#black;" ><b>TOTAL SKS</b></td>
                               <td align="center"><?= $total_sks?> </td>
                               <td></td>
                               <td></td>
                        </tr>

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
                                <a href="views/approve/approve_aksi.php?action=konfirm&nim=<?=$nim ?>&id=<?= $id_semester ?>" class="btn btn-primary">Yes</a>
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
                                 <a href="views/approve/approve_aksi.php?action=batal&nim=<?=$nim ?>&id=<?= $id_semester ?>" class="btn btn-primary">Yes</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- Modal batal -->
                    </table>
                </div>
            </div>
            
    </section>
<script>
    function approveKRS(krsId){

    }
</script>