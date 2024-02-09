<?php 

  include "../../config/fungsi.php";

  $jadwal = mysqli_query($conn, "SELECT * FROM mahasiswa
           INNER JOIN jurusan ON mahasiswa.id_jurusan= jurusan.id_jurusan");
 ?>

 <section class="content-header">
  <h1>
    Transkrip
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> Kelas Prodi</li>
  </ol>    
  </section>

  <section class="content">
       <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3><br><br>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <form method="get">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nim</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;  ?>
                    <?php foreach ($jadwal as $row) : ?>
                  <tr>                  
                    <td><?= $no++?></td>
                    <td><?= $row['nim']?></td>
                    <td><?= $row['nama']?></td>
                    <td><?= $row['nama_jurusan']?></td>
                    <td>
                      <a href="?page=transkrip&aksi=lihat_transkrip&nim=<?= $row["nim"]; ?>"><span class="btn btn-success"><i class="fa fa-list"> Lihat Transkrip</i></span></a>
                    </td>
                  </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>