<?php 
 $prd = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'"); 
          $data = mysqli_fetch_assoc($prd); 
          $nama_prd = $data['nama_semester'];
          $id_prd = $data['id_semester'];


$nip = $_SESSION['nip'];

 ?>


 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> Dosen</li>
  </ol>    
  </section>

  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">HISTORI MENGAJAR DOSEN</h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
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
                                        WHERE jadwal.nip = '$nip'"); ?>

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
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>

 <!-- jQuery 3 -->
