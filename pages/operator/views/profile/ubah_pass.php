<?php 
  include "../../config/fungsi.php";
  // ambil data di URL
  $nip = $_GET["nip"];

  $dosen = query("SELECT * FROM dosen WHERE nip = $nip")[0];

  if(isset($_POST["submit"])){
 
  // cek apakah  data berhasil diubah atau tidak
  if(ubah_dosen($_POST) > 0 ){
    echo "
      <script>
        alert('data berhasil diubah:');
        document.location.href = '?page=dosen';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('data gagal diubah:');
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
      <li class="active"> Ubah Dosen</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->

          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Dosen</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                  <input type="hidden" name="fotoLama" value="<?= $dosen["foto"]; ?>"> 
                  <div class="form-group">
                    <label for="nip">NIP / NIDN</label>
                    <input type="text" class="form-control" name="nip" id="nip"  value="<?= $dosen["nip"]; ?>">
                  </div>
                  <div class="form-group">
                    <label for="nama">Nama Dosen</label>
dosen<input type="text" class="form-control" name="nama" id="nama"  value="<?= $dosen["nama"]; ?>" required>
                  </div>
                   <div class="form-group">
                    <label for="jk">Jenis Kelamin</label>
                    <input type="text" class="form-control" name="jk" id="jk"  value="<?= $dosen["jenis_kelamin"]; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="tanggal">Tanggal Lahir</label>
                    <input type="text" class="form-control" name="tanggal" id="tanggal"  value="<?= $dosen["tanggal_lahir"]; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" name="alamat" id="alamat" value="<?= $dosen["alamat"]; ?>" required>
                  </div>
                   <div class="form-group">
                    <label for="telp">Telepon</label>
                    <input type="text" class="form-control" name="telp" id="telp"  value="<?= $dosen["telp"]; ?>" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email"  value="<?= $dosen["email"]; ?>" required>
                  </div>
                   <div class="form-group">
                    <label for="pendidikan">Pendidikan Terakhir</label>
                    <input type="text" class="form-control" name="pendidikan" id="pendidikan"  value="<?= $dosen["pendidikan_terakhir"]; ?>" required>
                  </div>
                   <div class="form-group">
                    <label for="foto">Foto</label>
                    <img src="../../assets/img/<?= $dosen["foto"]; ?>" width="50px"><br>
                    <input type="file" class="form-control" name="foto"  value="<?= $dosen["foto"]; ?>"  id="foto">
                  </div>
                   <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password"  required>
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



