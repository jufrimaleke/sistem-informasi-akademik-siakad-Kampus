
 <?php $nim = $_SESSION['mahasiswa']; 

$nim = $_SESSION['mahasiswa'];
 
  $mahasiswa = query("SELECT * FROM mahasiswa WHERE nim = '$nim'");


 
  if(isset($_POST["submit"])){
 
  // cek apakah  data berhasil diubah atau tidak
  if( ubahPass($_POST) > 0 ){
    echo "
      <script>
        alert('data berhasil diubah:');
        document.location.href = '?page=pass';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('data gagal diubah:');
        document.location.href = '?page=pass';
      </script>
    ";
  }

}

 ?>

 <section class="content-header">
  <h1>
    Ubah Password
    
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Ubah Password</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <form method="POST" action="">
        <div class="form-group row">
         
          <div class="col-sm-10">
            <input type="hidden" class="form-control form-control-sm" id="colFormLabelSm" name="nim"value="<?= $nim ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">New Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control form-control-sm" id="colFormLabelSm" name="pass1" placeholder="Masukkan password baru" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="colFormLabel" class="col-sm-2 col-form-label" name="pass1">Ulangi Password</label>
          <div class="col-sm-10">
            <input type="password"required class="form-control" id="colFormLabel" name="pass2" placeholder="Ulangi password">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2"></div>
          <div class="col-sm-10">
            <button type="submit" name="submit" value="tambah"class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div> 
  </div>
</section>


  
      

 