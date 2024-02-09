<?php 
require "../../config/fungsi.php";
// $dosen = mysqli_query($conn, "SELECT * FROM dosen");

//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

	//cek apakah    data berhasil ditambahkan atau tidak
	if(tambah_dosen($_POST) > 0 ){
		echo "
			<script>
				alert('data berhasil ditambahkan:');
				document.location.href = '?page=dosen';
			</script>
		";
	} else {
		echo ("error ". mysqli_error($conn));
    die;
		echo "
		 	<script>
				alert('data gagal ditambahkan:');
				document.location.href = '?page=dosen';
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
      <li class="active"> tambah dosen</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->

          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Dosen</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="nip">NIP / NIDN</label>
                    <input type="text" class="form-control" name="nip" id="nip" placeholder="NIP / NIDN" required>
                  </div>
                  <div class="form-group">
                    <label for="nama">Nama Dosen</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Dosen" required>
                  </div>
                   <div class="form-group">
                    <label for="jk">Jenis Kelamin</label>
                    <input type="text" class="form-control" name="jk" id="jk" placeholder="Jenis Kelamin" required>
                  </div>
                  <div class="form-group">
                    <label for="tanggal">Tanggal Lahir</label>
                    <input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal Lahir" required>
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" required>
                  </div>
                   <div class="form-group">
                    <label for="telp">Telepon</label>
                    <input type="text" class="form-control" name="telp" id="telp" placeholder="Telepon" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
                  </div>
                   <div class="form-group">
                    <label for="pendidikan">Pendidikan Terakhir</label>
                    <input type="text" class="form-control" name="pendidikan" id="pendidikan" placeholder="Pendidikan Terakhir" required>
                  </div>
                   <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control" name="foto" id="foto">
                  </div>
                   <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                  </div>
                   <div class="form-group">
                    <label for="password2">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password1" id="password1" placeholder="Konfirmasi Password" required>
                  </div>   
                  <div class="box-footer">
                  <button type="submit" name="submit" value="tambah" class="btn btn-primary">Simpan</button>
                  </div>          
                </div>
              <!-- /.box-body -->            
             
            </form>
          </div>      
     </div>
    </section>



