<?php 
  // include "../../config/fungsi.php";

  
  $angkatan = mysqli_query($conn, "SELECT id_semester,nama_semester FROM semester");
  $jurusan = mysqli_query($conn, "SELECT id_jurusan,kode_jurusan,nama_jurusan FROM jurusan");

 ?>

 <section class="content-header">
  <h1>
    Dashboard
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
              <form method="POST">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="angkatan">Angkatan :</label>
                        <select name="angkatan" required class="form-control" id="angkatan" required>
                          <?php $_SESSION['filter_angkatan'] = $_POST['angkatan']; ?>
                          <option value="">-- Pilih -- </option>
                          <?php foreach ($angkatan as $row): ?>
                            <option value="<?php echo $row["id_semester"]; ?>"
                              <?= $_SESSION['filter_angkatan'] === $row['id_semester'] ? 'selected' : ''; ?>>
                              <?php echo $row["nama_semester"]; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="jrs">Prodi:</label>
                        <select name="jrs"class="form-control" id="jrs">
                          <?php $_SESSION['filter_prodi'] = $_POST['jrs']; ?>
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
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tahun Semester</th>
                  <th>Prodi</th>
                  <th>Kode MatKul</th>
                  <th>Nama MatKul</th>
                  <th>SKS</th>
                  <th>Jml MHS</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
              <?php 
              if (isset($_POST['filter'])) {
                  $prd = $_POST['angkatan'];
                  $jrs = $_POST['jrs'];
                  $nip = $_SESSION['nip'];
                  $jadwal = mysqli_query($conn, "SELECT * FROM jadwal
                       INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
                       INNER JOIN semester ON jadwal.id_semester = semester.id_semester
                       INNER JOIN jurusan ON jadwal.id_jurusan = jurusan.id_jurusan
                       WHERE jadwal.nip = '$nip' AND semester.id_semester = '$prd' AND jurusan.id_jurusan = '$jrs'");
                  foreach ($jadwal as $row) : ?>
                      <tr>                  
                          <td><?= $row['nama_semester']?></td>
                          <td><?= $row['nama_jurusan']?></td>
                          <td><?= $row['kode_mk']?></td>
                          <td><?= $row['nama_mk']?></td>
                          <td><?= $row['sks']?></td>
                          <?php
                          $select = "SELECT COUNT(nim) FROM khs WHERE id_jadwal = $row[id_jadwal]";
                          $query = mysqli_query($conn, $select);
                          $data = mysqli_fetch_assoc($query);
                          $jml = $data['COUNT(nim)'];
                          ?>
                          <td><?= $jml ?></td>
                      
                          <?php if ($jml == 0) { ?>
                            <td>
                              <a href="#" disabled ><span class="btn btn-danger"><i class="fa fa-list"> Tidak ada peserta</i></span></a>
                          </td>
                          <?php } else { ?>
                            <td>
                              <a href="?page=khs&aksi=input&id_jadwal=<?= $row["id_jadwal"]; ?>" disabled ><span class="btn btn-success"><i class="fa fa-list"> Lihat Peserta</i></span></a>
                          </td>
                        <?php } ?>

                      </tr>       
                  <?php endforeach;
              } else {
                  echo '<tr><td colspan="7" class="text-center bg-success"><b>P I L I H  F I L T E R</b></td></tr>';
              }
              ?>
              </tbody>

              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>