<?php 
require "../../config/fungsi.php";

$id_pengumuman = mysqli_real_escape_string($conn, $_GET["id_pengumuman"]);

$query_pengumuman = query("SELECT * FROM pengumuman WHERE id_pengumuman = '$id_pengumuman'")[0];

//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["ubah_pengumuman"])){

  //cek apakah    data berhasil ditambahkan atau tidak
  if(ubah_pengumuman($_POST) > 0 ){
    echo "
      <script>
        alert('data berhasil diubah:');
        document.location.href = '?page=pengumuman';
      </script>
    ";
  } else {
    echo ("error ". mysqli_error($conn));
    echo "
      <script>
        alert('data gagal diubah:');
        document.location.href = '?page=pengumuman';
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
      <li class="active"> Ubah pengumuman</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">UBAH PENGUMUMAN</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
                 <div class="form-group">
                  <label for="id">ID Pengumuman</label>
                  <input type="text" class="form-control" name="id_pengumuman" readonly="on" value="<?= $query_pengumuman["id_pengumuman"]; ?>">
                </div>
                <div class="form-group">
                  <label for="kode">Nama Pengumuman</label>
                  <input type="text" class="form-control" name="nama_pengumuman"autocomplete="off" value="<?= $query_pengumuman["nama_pengumuman"]; ?>">
                </div>
                <div class="form-group">
                  <label for="nama">Jenis Pengumuman</label>
                  <input type="text" class="form-control" name="jenis_pengumuman" autocomplete="off" value="<?= $query_pengumuman["jenis_pengumuman"]; ?>">
                </div>
                 <div class="form-group">
                  <label for="tujuan_pengumuman">Tujuan</label>
                    <select name="tujuan_pengumuman" class="form-control" required>
                        <option value="<?= $query_pengumuman['tujuan'] ?>">
						    <?= ($query_pengumuman['tujuan'] == 1) ? 'DOSEN' : (($query_pengumuman['tujuan'] == 2) ? 'MAHASISWA' : '') ?>
						</option>

                        <option value="1">DOSEN</option>
                        <option value="2">MAHASISWA</option>
                    </select>
                </div>
              	<div class="form-group">
                  <label for="ketua">Isi Pengumuman</label>
                  <textarea class="form-control" name="isi_pengumuman" id="editor1"><?= $query_pengumuman["isi_pengumuman"]; ?></textarea>
                </div>                
              <div class="form-group">
                  <label for="status_pengumuman">Status Pengumuman</label>
                  <select name="status_pengumuman" class="form-control">
                       <option value="<?= $query_pengumuman['status_post'] ?>">

                       	<?= ($query_pengumuman['status_post'] == 1) ? 'ENABLE' : (($query_pengumuman['status_post'] == 0) ? 'DISABLE' : '') ?>
                     		
                       	</option>
                       	<option value="0">DISABLE</option>
                       	<option value="1">ENABLE</option>
                  </select>
                </div>                
           
              <div class="form-group">
                  <label for="update_date">Date Update</label>
                  <input class="form-control" name="update_date" readonly autocomplete="off" value="<?= date('Y-m-d H:i:s') ?>">

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="ubah_pengumuman" value="ubah_pengumuman" class="btn btn-primary">Edit</button>
                 <a href="index.php?page=pengumuman" class="btn btn-danger">Batal</a>
              </div>
            </form>
          </div>
        </div>           
       </div>
    </section>