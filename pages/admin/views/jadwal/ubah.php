<?php 
require "../../config/fungsi.php";

$id = @$_GET["id_jadwal"];

$data = mysqli_query($conn, "SELECT * FROM jadwal
    INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
    INNER JOIN dosen ON jadwal.nip = dosen.nip
    INNER JOIN semester ON jadwal.id_semester = semester.id_semester
    INNER JOIN jurusan ON jadwal.id_jurusan = jurusan.id_jurusan
    INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
    INNER JOIN paket_semester ON mata_kuliah.id_paketSemester = paket_semester.id_paket
    WHERE jadwal.id_jadwal = $id");

$jadwal = mysqli_fetch_array($data);

$dosen = mysqli_query($conn, "SELECT * FROM dosen");
$semester = mysqli_query($conn, "SELECT * FROM semester WHERE status ='1'");
$mk = mysqli_query($conn, "SELECT * FROM mata_kuliah INNER JOIN jurusan ON mata_kuliah.id_jurusan = jurusan.id_jurusan");
$prodi = mysqli_query($conn, "SELECT * FROM jurusan");
$kelas = mysqli_query($conn, "SELECT * FROM kelas");
$paket_semester = mysqli_query($conn,"SELECT * FROM paket_semester");
//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

  //cek apakah    data berhasil ditambahkan atau tidak
  if(ubah_jadwal($_POST) > 0 ){
    echo "
      <script>
        alert('data berhasil diubah:');
        document.location.href = '?page=jadwal';
      </script>
    ";
  } else {
    echo ("error ". mysqli_error($conn));
    var_dump($_POST);die();
    echo "
      <script>
        alert('data gagal diubah:');
        document.location.href = '?page=jadwal';
      </script>
    ";
  }

}
?>


<section class="content-header">
  <h1>
    Dashboard
     <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
      <li class="active">  Ubah Jadwal</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> Ubah Jadwal</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
                <div class="form-group">
                  <label for="id">ID Jadwal</label>
                  <input type="text" class="form-control" name="id" id="id"value="<?= $jadwal["id_jadwal"]; ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="mk">Mata Kuliah</label>
                    <select name="mk" class="form-control" id="mk"> 
                      <?php echo '<option name="mk" value="'.$jadwal["id_mk"].'">'.$jadwal["nama_mk"].' | '.$jadwal["nama_jurusan"].' | '.$jadwal['nama_paket'].'</option>'; ?>
                    <?php foreach ($mk as $row): ?>
                          <?php echo '<option name="mk" value="'.$row["id_mk"].'">'.$row["nama_mk"].' | '.$row["nama_jurusan"].' | '.$row["id_paketSemester"].'</option>'; ?>
                        <?php endforeach; ?>                      
                    </select>
                </div>
              <div class="form-group">
                <label for="dosen">Dosen</label>
                <select name="dosen" class="form-control" id="dosen">
                  <?php echo '<option name="mk" value="'.$jadwal["nip"].'">'.$jadwal["nama_dosen"].'</option>'; ?>
                  <?php foreach ($dosen as $row): ?>
                    <?php echo '<option name="nip" value="'.$row["nip"].'">'.$row["nama_dosen"].'</option>'; ?>
                  <?php endforeach; ?>                    
                </select>
              </div>  
              <div class="form-group">
                <label for="semester">Semester</label>
                <select name="semester" class="form-control" id="semester">             
                  <?php echo '<option name="mk" value="'.$jadwal["id_semester"].'">'.$jadwal["nama_semester"].'</option>'; ?> 
                  <?php foreach ($semester as $row): ?>
                    <?php echo '<option name="id_semester" value="'.$row["id_semester"].'">'.$row["nama_semester"].'</option>'; ?>
                  <?php endforeach; ?>                    
                </select>
              </div>
              <div class="form-group">
                <label for="prodi">Program Studi</label>
                <select name="prodi" class="form-control" id="prodi">
                  <?php echo '<option name="prodi" value="'.$jadwal["id_jurusan"].'">'.$jadwal["nama_jurusan"].'</option>'; ?>
                  <?php foreach ($prodi as $row): ?>
                    <?php echo '<option name="nip" value="'.$row["id_jurusan"].'">'.$row["nama_jurusan"].'</option>'; ?>
                  <?php endforeach; ?>                    
                </select>
              </div>  
              <div class="form-group">
                <label for="hari">Hari</label>
                <select name="hari" class="form-control" id="hari">
                  <?php echo '<option name="mk" value="'.$jadwal["hari"].'">'.$jadwal["hari"].'</option>'; ?> 
                  <option value="SENIN"> SENIN </option>
                  <option value="SELASA"> SELASA </option>
                  <option value="RABU"> RABU </option>
                  <option value="KAMIS"> KAMIS </option>
                  <option value="JUMAT"> JUM'AT </option>
                  <option value="SABTU"> SABTU </option>
                </select>
              </div>
              <div class="form-group">
                  <label for="mulai">Jam Mulai</label>
                  <input type="time" class="form-control" name="mulai" id="mulai" value="<?= $jadwal["jam_mulai"];?>">
              </div> 
              <div class="form-group">
                  <label for="selesai">Jam Selesai</label>
                  <input type="time" class="form-control" name="selesai" id="selesai" value="<?= $jadwal["jam_selesai"];?>">
              </div>
               <div class="form-group">
                <label for="kelas">Kelas</label>
                <select name="kelas" class="form-control" id="kelas">
                  <?php echo '<option name="kelas" value="'.$jadwal["id_kelas"].'">'.$jadwal["nama_kelas"].'</option>'; ?>
                  <?php foreach ($kelas as $row): ?>
                    <?php echo '<option name="kelas" value="'.$row["id_kelas"].'">'.$row["nama_kelas"].'</option>'; ?>
                  <?php endforeach; ?>                    
                </select>
              </div>
              <div class="form-group">
                <label for="smt">Semester</label>
                <select name="smt" class="form-control" id="kelas">
                  <?php echo '<option name="smt" value="'.$jadwal["id_paketSemester"].'">'.$jadwal["nama_paket"].'</option>'; ?>
                  <?php foreach ($paket_semester as $smt): ?>
                    <?php echo '<option name="smt" value="'.$smt["id_paket"].'">'.$smt["nama_paket"].'</option>'; ?>
                  <?php endforeach; ?>                    
                </select>
              </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="submit" value="tambah" class="btn btn-primary">Simpan</button>
                <a href="index.php?page=jadwal" class="btn btn-danger">Batal</a>
              </div>
            </form>
          </div>
        </div>           
       </div>
    </section>