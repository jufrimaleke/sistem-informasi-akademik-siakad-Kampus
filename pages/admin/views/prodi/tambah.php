<?php 
require "../../config/fungsi.php";
$dosen = mysqli_query($conn, "SELECT * FROM dosen");

//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

	//cek apakah    data berhasil ditambahkan atau tidak
	if(tambah_prodi($_POST) > 0 ){
		echo "
			<script>
				alert('data berhasil ditambahkan:');
				document.location.href = '?page=prodi';
			</script>
		";
	} else {
		echo ("error ". mysqli_error($conn));
		echo "
		 	<script>
				alert('data gagal ditambahkan:');
				document.location.href = '?page=prodi';
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
      <li class="active"> tambah prodi</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Prodi</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
                <div class="form-group">
                  <label for="kode">Kode Prodi</label>
                  <input type="text" class="form-control" name="kode" id="kode" placeholder="Kode Prodi">
                </div>
                <div class="form-group">
                  <label for="nama">Nama Prodi</label>
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Prodi">
                </div>
	            <div class="form-group">
                  <label for="ketua">Ketua Prodi</label>
                  <select name="nip" class="form-control" id="nim" required>          		
	      			<option value="">- Pilih -</option> 
	      			<?php foreach ($dosen as $row): ?>
	      				<?php echo '<option name="nip" value="'.$row["nip"].'">'.$row["nama"].'</option>'; ?>
	      			<?php endforeach; ?>       	         		
	          	</select>
                </div>                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="submit" value="tambah" class="btn btn-primary">Simpan</button>
                 <a href="index.php?page=prodi" class="btn btn-danger">Batal</a>
              </div>
            </form>
          </div>
        </div>           
       </div>
    </section>