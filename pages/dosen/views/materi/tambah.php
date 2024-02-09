<?php 
// require "../../config/fungsi.php";
$nip = $_SESSION['nip'];
  
  $materi = mysqli_query($conn, "SELECT * FROM jadwal
            INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
            WHERE jadwal.nip = $nip");

 //cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

	//cek apakah    data berhasil ditambahkan atau tidak
	if(tambah_materi($_POST) > 0 ){
    // var_dump($_POST); die();
		echo "
			<script>
				alert('data berhasil ditambahkan:');
				document.location.href = '?page=materi';
			</script>";
	} else {
		echo "
		 	<script>
				alert('data gagal ditambahkan:');
				document.location.href = '?page=materi';
      </script>";
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
      <li class="active"> tambah materi kuliah</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Materi Kuliah</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="" enctype="multipart/form-data">
              <div class="box-body">            
                <div>
                  <label for="mk">Mata Kuliah</label>
                    <select name="mk" class="form-control" id="mk" required> 
                      <option value="">- Pilih -</option> 
                        <?php foreach ($materi as $row): ?>
                          <?php echo '<option name="mk" value="'.$row["id_mk"].'">'.$row["kode_mk"].' | '.$row["nama_mk"].' | '.$row["semester"].'</option>'; ?>
                        <?php endforeach; ?>                    
                    </select>
                </div>
                 <div class="form-group">
                  <label for="Judul">Judul</label>
                  <input type="text" class="form-control" name="Judul" id="Judul">
                </div>
	            <div class="form-group">
                  <label for="file">File</label>
                 <input type="file" class="form-control" name="file" id="file">
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