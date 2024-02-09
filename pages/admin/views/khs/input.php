 <?php 
  include "../../config/fungsi.php";

  $_SESSION['id_jadwal'] = $_GET['nilai'];
  $id_krs = $_SESSION['id_jadwal'];
 
  $khs = mysqli_query($conn, "SELECT * FROM khs
           INNER JOIN jadwal ON khs.id_jadwal = jadwal.id_jadwal
           INNER JOIN mahasiswa ON khs.nim = mahasiswa.nim
           WHERE khs.id_jadwal = $id_krs");

  $krs = mysqli_query($conn, "SELECT * FROM jadwal
           INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
           WHERE jadwal.id_jadwal = $id_krs");
  $data = mysqli_fetch_assoc($krs);
  
  

  ?>

 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Dashboard</a></li>
    <li class="active">Kelas Peserta</li>
  </ol>
</section>

<section class="content">
  <div class="box box-default">
    <div class="box-header with-border">
      <?php foreach ($krs as $row) : ?>
        <h3 class="box-title"><b><?= $row["kode_mk"] ?> - <?= $row["nama_mk"] ?></b></h3><br><br>
      <?php endforeach; ?>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <form method="POST" action="">
          <div class="pull-left">
            <button type='submit' name='simpan' class='btn btn-primary'>Simpan</button>
          </div>
          <br><br><br>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Kehadiran</th>
                <th>Nilai Tugas</th>
                <th>Nilai UTS</th>
                <th>Nilai UAS</th>
                <th>Nilai Akhir</th>
                <th>Nilai Huruf</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($khs as $row) : ?>
                <tr>
                  <input type="hidden" name="id[]" value="<?= $row['id_khs'] ?>">
                  <td><?= $no; ?></td>
                  <td><?= $row["nim"] ?></td>
                  <td style="width:300px"><?= $row["nama"] ?></td>
                 <td><input type="text" name="kehadiran[]" value="<?= $row['kehadiran'] ?>" class="form-control" style="width: 75px;" value=""></td>
                  <td><input type="number" name="nilai_tgs[]" value="<?= $row['nilai_tgs'] ?>" class="form-control" style="width: 75px;" value=""></td>
                  <td><input type="number" name="nilai_uts[]" value="<?= $row['nilai_uts'] ?>" class="form-control" style="width: 75px;" value=""></td>
                  <td><input type="number" name="nilai_uas[]" value="<?= $row['nilai_uas'] ?>" class="form-control" style="width: 75px;" value=""></td>
                  <td><input type="number" name="nilai_akhir[]" value="<?= $row['nilai_akhir'] ?>" class="form-control" style="width: 75px;" value="" step="any"></td>
                  <td>
                    <select name="nilai_huruf[]" class="form-control" style="width: 75px;">
                       <option value="">-</option>
                      <option value="A" <?= ($row['nilai_huruf'] == 'A') ? 'selected' : '' ?>>A</option>
                      <option value="B" <?= ($row['nilai_huruf'] == 'B') ? 'selected' : '' ?>>B</option>
                      <option value="C" <?= ($row['nilai_huruf'] == 'C') ? 'selected' : '' ?>>C</option>
                      <option value="D" <?= ($row['nilai_huruf'] == 'D') ? 'selected' : '' ?>>D</option>
                      <option value="E" <?= ($row['nilai_huruf'] == 'E') ? 'selected' : '' ?>>E</option>
                    </select>
                  </td>

                </tr>
                <?php $no++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php
          $select = "SELECT COUNT(nim) FROM khs WHERE id_jadwal = $data[id_jadwal]";
          $query = mysqli_query($conn, $select);
          while ($data = mysqli_fetch_assoc($query)) {
            $jml = $data['COUNT(nim)'];
            
          }
          ?>
          <input type="hidden" name="count" value="<?= $jml; ?>">
        </form>
      </div>
    </div>
  </div>
</section>

<?php
if (isset($_POST['simpan'])) { // Jika user mengklik tombol Simpan
  $id = $_POST['id'];
  $kehadiran = $_POST['kehadiran'];
  $n_tugas = $_POST['nilai_tgs'];
  $n_uts = $_POST['nilai_uts'];
  $n_uas = $_POST['nilai_uas'];
  $n_akhir = $_POST['nilai_akhir'];
  $n_huruf = $_POST['nilai_huruf'];

  $count = $_POST['count'];

  for ($i = 0; $i < $_POST['count']; $i++) {
    $query = "UPDATE khs SET
              kehadiran = '$kehadiran[$i]',
              nilai_tgs = '$n_tugas[$i]',
              nilai_uts = '$n_uts[$i]',
              nilai_uas = '$n_uas[$i]',
              nilai_akhir = '$n_akhir[$i]',
              nilai_huruf = '$n_huruf[$i]'
              WHERE id_khs = $id[$i]";

    // Eksekusi $query
    mysqli_query($conn, $query);
  }

  echo "
    <script>
        alert('Nilai berhasil ditambahkan:');
        document.location.href = '?page=khs';
      </script>";
}
?>

