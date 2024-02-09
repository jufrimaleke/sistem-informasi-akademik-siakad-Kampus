<?php 
require "../../config/fungsi.php";

// ambil data di URL
$id = @$_GET["id_kelas"];

// query data mahasiswa berdasarkan id
$kelas = query("SELECT * FROM kelas WHERE id_kelas = '$id'")[0];

 
if(isset($_POST["submit"])) {
 
  // cek apakah  data berhasil diubah atau tidak
  if(ubah_kelas($_POST) > 0 ){
    echo "
      <script>
        alert('data berhasil diubah:');
        document.location.href = '?page=kelas';
      </script>
    ";
  } else {
    echo ("error ". mysqli_error($conn));
    var_dump($_POST);
    // echo "
    //   <script>
    //     alert('data gagal diubah:');
    //     document.location.href = '?page=prodi';
    //   </script>
    // ";
  }

}

 ?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
<section class="content-header">
  <h1>
    Dashboard
     <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
      <li class="active"> Ubah Kelas</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Kelas</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
              	<div class="form-group">
                  <label for="id">ID Kelas</label>
                  <input type="text" class="form-control" name="id_kelas" id="id_kelas" readonly="true" value="<?= $kelas["id_kelas"]; ?>">
                </div>
                <div class="form-group">
                  <label for="nama_kelas">Nama Kelas</label>
                  <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" value="<?= $kelas["nama_kelas"]; ?>">
                </div>                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="submit" value="tambah" class="btn btn-primary">Simpan</button>
                <a href="index.php?page=kelas" class="btn btn-danger">Batal</a>
              </div>
            </form>
          </div>
        </div>           
       </div>
    </section>