<?php 

  include "../../config/fungsi.php";

  
  $angkatan = mysqli_query($conn, "SELECT * FROM angkatan");
  $jurusan = mysqli_query($conn, "SELECT id_jurusan,kode_jurusan,nama_jurusan FROM jurusan");
 ?>

 <section class="content-header">
  <h1>
    Kartu Hasil Studi
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
              <form method="POST">
                  <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="jrs">Prodi:</label>
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
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" name="filter" class="btn btn-info form-control">Filter</button>
                      </div>
                    </div>
                  </div>
                </form>  
            </div>


            <!-- /.box-header -->
            <div class="box-body">
              <form method="get">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                 
                    <th>Nim</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>  
               <?php 
                  if (isset($_POST['filter'])) {
                      $angkatan = $_POST['angkatan'];
                      $jrs = $_POST['jrs'];
                      
                      $jadwal = mysqli_query($conn, "SELECT * FROM mahasiswa
                                             INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan WHERE mahasiswa.id_jurusan = '$jrs' AND mahasiswa.id_angkatan = '$angkatan'");

                      foreach ($jadwal as $row) : ?>
                          <tr>                  
                              <td><?= $row['nim']?></td>
                              <td><?= $row['nama']?></td>
                              <td><?= $row['nama_jurusan']?></td>
                              <td>
                                  <a href="?page=khs_mhs&aksi=lihat_khs_mhs&nim=<?= $row["nim"]; ?>"><span class="btn btn-success"><i class="fa fa-list"> Lihat KHS</i></span></a>
                              </td>
                          </tr>
                  <?php
                      endforeach;
                  } else {
                      echo '<tr><td colspan="7" class="text-center bg-success"><b>P I L I H  F I L T E R</b></td></tr>';
                  }
                  ?>

                  </tbody>
                
                </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>