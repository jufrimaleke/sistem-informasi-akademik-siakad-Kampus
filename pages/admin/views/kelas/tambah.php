<?php 
require "../../config/fungsi.php";
$kelas = mysqli_query($conn, "SELECT * FROM kelas");

//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

	//cek apakah    data berhasil ditambahkan atau tidak
	if(tambah_kelas($_POST) > 0 ){
		echo "
			<script>
				alert('data berhasil ditambahkan:');
				document.location.href = '?page=kelas';
			</script>
		";
	} else {
		echo ("error ". mysqli_error($conn));
		echo "
		 	<script>
				alert('data gagal ditambahkan:');
				document.location.href = '?page=kelas';
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
      <li class="active"> tambah kelas</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Kelas</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
                <div class="form-group">
                  <label for="kode">Nama Kelas</label>
                  <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Kelas">
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