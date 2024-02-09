<?php 
require "../../config/fungsi.php";

// ambil data di URL
$id = @$_GET["id_jurusan"];

// query data mahasiswa berdasarkan id
$jurusan = mysqli_query($conn,"SELECT * FROM jurusan 
	INNER JOIN dosen ON jurusan.nip = dosen.nip
	WHERE jurusan.id_jurusan = $id");
$result = mysqli_fetch_assoc($jurusan);

$dosen = mysqli_query($conn, "SELECT * FROM dosen");
// cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])) {
 
  // cek apakah  data berhasil diubah atau tidak
  if(ubah_prodi($_POST) > 0 ){
    echo "
      <script>
        alert('data berhasil diubah:');
        document.location.href = '?page=prodi';
      </script>
    ";
  } else {
    echo"
       <script>
         alert('data gagal diubah:');
         document.location.href = '?page=prodi';
       </script>
     ";
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
      <li class="active"> Ubah Prodi</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Prodi</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
              	<div class="form-group">
                  <label for="id">ID Prodi</label>
                  <input type="text" class="form-control" name="id" id="id" readonly="true" value="<?= $result["id_jurusan"]; ?>">
                </div>
                <div class="form-group">
                  <label for="kode">Kode Prodi</label>
                  <input type="text" class="form-control" name="kode" id="kode" value="<?= $result["kode_jurusan"]; ?>">
                </div>
                <div class="form-group">
                  <label for="prodi">Nama Prodi</label>
                  <input type="text" class="form-control" name="prodi" id="prodi" value="<?= $result["nama_jurusan"]; ?>">
                </div>
	            <div class="form-group">
                  <label for="nip">Ketua Prodi</label>
                  <select name="nip" class="form-control" id="nip">   
                  <option value="">-- Pilih --</option>   
                  <?php foreach ($dosen as $row) : ?>
                  <option value="<?= $row['nip'] ?>"><?= $row['nama_dosen'] ?></option>    		
                <?php endforeach ; ?>
    	      			      	         		
    	          	</select>
                </div>                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="submit" value="tambah" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>           
       </div>
    </section>