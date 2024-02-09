<?php 
  include "../../config/fungsi.php";
  


$angkatan_options= mysqli_query($conn, "SELECT * FROM semester");
$jurusan_options = mysqli_query($conn, "SELECT * FROM jurusan");
 ?>


 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> Jadwal</li>
  </ol>    
  </section>

  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Jadwal Kuliah</h3>
               <a href="?page=jadwal&aksi=tambah" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
               <a href="views/jadwal/cetak.php" target="_blank" class="btn btn-success btn-ms"> <span class="glyphicon glyphicon-print"></span> Cetak </a><br><br>
            
                <form method="POST">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="thn_akad">Tahun Akademik:</label>
                        <select name="thn_akad" class="form-control" id="thn_akad">
                          <?php $_SESSION['filter_akd'] = $_POST['thn_akad']; ?>
                        <option value="">- Pilih tahun akademik -</option>
                        <?php foreach ($angkatan_options as $option) : ?>
                          <option value="<?= $option['id_semester']; ?>" <?= $_SESSION['filter_akd'] === $option['id_semester'] ? 'selected' : ''; ?>>
                            <?= $option['nama_semester']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="jrs">Prodi:</label>
                        <select name="jrs" class="form-control" id="jrs">
                          <?php $_SESSION['filter_jrs'] = $_POST['jrs']; ?>
                          <option value="">- Pilih Jurusan -</option>
                          <?php foreach ($jurusan_options as $option) : ?>
                            <option value="<?= $option['id_jurusan']; ?>" <?= $_SESSION['filter_jrs'] === $option['id_jurusan'] ? 'selected' : ''; ?>>
                              <?= $option['nama_jurusan']; ?>
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
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Matakuliah</th>
                  <th>Nama Matakuliah</th>
                  <th>Tahun Akademik</th>
                  <th>Hari</th>    
                  <th>Jam</th>
                  <th>Dosen</th>
                  <th>Kelas</th>
                  <th>Jurusan</th>
                  <th>Semester</th>
                  <th>Aksi</th>
                </tr>
                </thead>
               <tbody>
                <?php 
                if (isset($_POST['filter'])) {
                    $thn_akad = $_POST['thn_akad'];
                    $jrs = $_POST['jrs'];

                    $jadwal = mysqli_query($conn, "SELECT * FROM jadwal
                     INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
                     INNER JOIN semester ON jadwal.id_semester = semester.id_semester
                     INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
                     INNER JOIN jurusan ON jadwal.id_jurusan = jurusan.id_jurusan
                     INNER JOIN paket_semester ON jadwal.id_paketSemester = paket_semester.nama_paket
                     INNER JOIN dosen ON jadwal.nip = dosen.nip WHERE jadwal.id_jurusan = $jrs AND jadwal.id_semester = $thn_akad");

                    // Periksa apakah ada data yang ditemukan
                    if (mysqli_num_rows($jadwal) > 0) {
                        $i = 1;
                        foreach ($jadwal as $row) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $row['kode_mk'] ?></td>
                                <td><?= $row["nama_mk"]; ?></td>
                                <td><?= $row["nama_semester"]; ?></td>
                                <td><?= $row["hari"]; ?></td>
                                <td><?= $row["jam_mulai"] . ' - ' . $row["jam_selesai"]; ?></td>
                                <td><?= $row["nama_dosen"]; ?></td>
                                <td><?= $row["nama_kelas"]; ?></td>
                                <td><?= $row["nama_jurusan"]; ?></td>
                                <td><?= $row["nama_paket"]; ?></td>
                                <td style="text-align: center;">
                                    <a href="?page=jadwal&aksi=ubah&id_jadwal=<?= $row["id_jadwal"]; ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                    <a href="?page=jadwal&aksi=hapus&id_jadwal=<?= $row["id_jadwal"]; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                                </td>
                            </tr>
                <?php
                            $i++;
                        endforeach;
                    } else {
                        // Tampilkan pesan jika tidak ada data yang ditemukan
                        echo '<tr><td colspan="11" class="text-center">Tidak ada data yang ditemukan</td></tr>';
                    }
                } else {

                    $jadwal = mysqli_query($conn, "SELECT * FROM jadwal
                     INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
                     INNER JOIN semester ON jadwal.id_semester = semester.id_semester
                     INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
                     INNER JOIN jurusan ON jadwal.id_jurusan = jurusan.id_jurusan
                     INNER JOIN paket_semester ON jadwal.id_paketSemester = paket_semester.nama_paket
                     INNER JOIN dosen ON jadwal.nip = dosen.nip");

                    $i = 1;
                        foreach ($jadwal as $row) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $row['kode_mk'] ?></td>
                                <td><?= $row["nama_mk"]; ?></td>
                                <td><?= $row["nama_semester"]; ?></td>
                                <td><?= $row["hari"]; ?></td>
                                <td><?= $row["jam_mulai"] . ' - ' . $row["jam_selesai"]; ?></td>
                                <td><?= $row["nama_dosen"]; ?></td>
                                <td><?= $row["nama_kelas"]; ?></td>
                                <td><?= $row["nama_jurusan"]; ?></td>
                                <td><?= $row["nama_paket"]; ?></td>
                                <td style="text-align: center;">
                                    <a href="?page=jadwal&aksi=ubah&id_jadwal=<?= $row["id_jadwal"]; ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                    <a href="?page=jadwal&aksi=hapus&id_jadwal=<?= $row["id_jadwal"]; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                                </td>
                            </tr>
                <?php
                            $i++;
                        endforeach;
                }
                ?>
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
