<?php 
require "../../config/fungsi.php";


//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

  //cek apakah    data berhasil ditambahkan atau tidak
  if(tambah_mk($_POST) > 0 ){
    echo "
    <section class='content-header'>
       <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h4><i class='icon fa fa-check'></i> Success!</h4>
               Data Berhasil Di Ditambahkan.
              </div>
      </section>
    ";
  } else {
    echo ("error ". mysqli_error($conn));
    echo "
      <script>
        alert('data gagal ditambahkan:');
        document.location.href = '?page=mk';
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
              <h3 class="box-title">Tambah Mata Kuliah</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
                <div class="form-group">
                  <label for="kode">Kode Matakuliah</label>
                  <input type="text" class="form-control" name="kode" id="kode" autocomplete="off" placeholder="Kode Matakuliah">
                </div>
                <div class="form-group">
                  <label for="nama">Nama Matakuliah</label>
                  <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" placeholder="Matakuliah">
                </div>
                 <div class="form-group">
                  <label for="sks">SKS</label>
                  <input type="text" class="form-control" name="sks" id="sks" autocomplete="off" placeholder="SKS">
                </div>
              <div class="form-group">
                  <label for="sem">Semester</label>
                  <select name="sem" class="form-control" id="sem">             
                  <option value="1">1</option> 
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option> 
                  <option value="7">7</option> 
                  <option value="8">8</option>               
                  </select>
                </div>  
                <div class="form-group">
                  <label for="jurusan">Prodi</label>
                  <?php 
                    $jurusan = mysqli_query($conn, "SELECT * FROM jurusan");
                   ?>
                   <select class="form-control select2" name="jurusan" id="jurusan" style="width: 100%;">
                    <option value="">-Pilih Prodi-</option>
                     <?php while ($jrs = mysqli_fetch_array($jurusan)) { ?>
                    <option value="<?php echo $jrs['id_jurusan'] ?>"><?php echo $jrs['nama_jurusan'] ?></option>
                    <?php } ?>
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