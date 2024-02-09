<?php 
  include "../../config/fungsi.php";


  $angkatan = mysqli_query($conn, "SELECT id_semester,nama_semester FROM semester");
  $jurusan = mysqli_query($conn, "SELECT id_jurusan,kode_jurusan,nama_jurusan FROM jurusan");
          
 ?>


 <section class="content-header">
  <h1>
    KRS
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> Laporan KRS</li>
  </ol>    
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
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
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Tahun Akademik</th>
                    <th>Nim</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Update approve_by</th>
                    <th>Update_date</th>
                    <th>Status Aprove</th>
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                   <?php
                   if (isset($_POST['filter'])) {
                      $prd = $_POST['angkatan'];
                      $jrs = $_POST['jrs'];
                      
                      $query = "SELECT mahasiswa.nim, mahasiswa.nama, jurusan.nama_jurusan, approve.id_semester, approve.status, semester.nama_semester, approve.approve_by, approve.approve_date
                          FROM approve 
                          INNER JOIN mahasiswa ON approve.nim = mahasiswa.nim 
                          INNER JOIN semester ON approve.id_semester = semester.id_semester
                          INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
                          WHERE semester.id_semester = '$prd' AND jurusan.id_jurusan = '$jrs'";
                       $result = mysqli_query($conn, $query);


                      $no = 1;
                    foreach ($result as $row) : ?>
                  <tr>                  
                    <td><?= $no++?></td>
                    <td><?= $row['nama_semester']?></td>
                    <td><?= $row['nim']?></td>
                    <td><?= $row['nama']?></td>
                    <td><?= $row['nama_jurusan']?></td>
                    <td><?= $row['approve_by'] ?></td>  
                     <td><?= $row['approve_date'] ?></td> 

                    <?php 
                    if ($row['status'] == 1) {
                      echo '<td>
                                <span class="btn btn-success">Sudah diupprove</span>
                            </td>';
                    }else {
                       echo '<td>
                               <span class="btn btn-danger">Belum diupprove</span>
                            </td>';
                    }



                     ?>
                        
                  </tr>

                  <?php endforeach;

                   } else {
                  echo '<tr><td colspan="7" class="text-center bg-success"><b>P I L I H  F I L T E R</b></td></tr>';
                  }
                  ?>
                  </tbody>
                </table>
                </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>
      </div>
    </section>