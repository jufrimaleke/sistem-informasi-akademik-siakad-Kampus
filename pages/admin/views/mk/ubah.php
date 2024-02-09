<?php 
require "../../config/fungsi.php";

$id = $_GET["id_mk"];

$mk = query("SELECT * FROM mata_kuliah INNER JOIN jurusan ON mata_kuliah.id_jurusan = jurusan.id_jurusan WHERE id_mk = $id")[0];
//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

  //cek apakah    data berhasil ditambahkan atau tidak
  if(ubah_mk($_POST) > 0 ){
    echo "
      <script>
        alert('data berhasil diubah:');
        document.location.href = '?page=mk';
      </script>
    ";
  } else {
    echo ("error ". mysqli_error($conn));
    echo "
      gaga
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
      <li class="active"> Tambah Mata Kuliah</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Mata Kuliah</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
                 <div class="form-group">
                  <label for="id_mk">ID Matakuliah</label>
                  <input type="text" class="form-control" name="id_mk" readonly="on" value="<?= $mk["id_mk"]; ?>">
                </div>
                <div class="form-group">
                  <label for="kode">Kode Matakuliah</label>
                  <input type="text" class="form-control" name="kode" id="kode" autocomplete="off" value="<?= $mk["kode_mk"]; ?>">
                </div>
                <div class="form-group">
                  <label for="nama">Nama Matakuliah</label>
                  <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" value="<?= $mk["nama_mk"]; ?>">
                </div>
                 <div class="form-group">
                  <label for="sks">SKS</label>
                  <input type="text" class="form-control" name="sks" id="sks" autocomplete="off" value="<?= $mk["sks"]; ?>">
                </div>
              <div class="form-group">
                  <label for="semester">Semester</label>
                  <select name="semester" class="form-control">
                  <?php echo '<option value="'.$mk["id_paketSemester"].'">'.$mk["id_paketSemester"].'</option>'; ?>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option> 
                  <option value="6">6</option>
                  <option value="7">7</option>                
                  </select>
                </div> 
              <div class="form-group">
                  <label>Jurusan</label>
                  <select name="jurusan" class="form-control">
                      <option value="<?= $mk['id_jurusan'] ?>"><?= ($mk['id_jurusan'] == 9) ? 'Manajemen' : (($mk['id_jurusan'] == 10) ? 'Akuntansi' : '') ?></option>
                      <option value="9">Manajemen</option>
                      <option value="10">Akuntansi</option>
                  </select>
              </div>               
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="submit" value="tambah" class="btn btn-primary">Simpan</button>
                 <a href="index.php?page=mk" class="btn btn-danger">Batal</a>
              </div>
            </form>
          </div>
        </div>           
       </div>
    </section>