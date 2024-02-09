 <?php 
  include "../../config/fungsi.php";
  $prodi = mysqli_query($conn, "SELECT * FROM jurusan
		 INNER JOIN dosen ON jurusan.nip = dosen.nip");

 ?>

 <section class="content-header">
  <h1>
    Dashboard
     <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
      <li class="active"> prodi</li>
  </ol> 
</section>

<!-- Main content -->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Program Studi</h3>
              <a href="?page=prodi&aksi=tambah" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah </a>
               <a href="views/prodi/cetak.php" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-print"></span> Cetak </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th style="text-align: center;">No.</th>
                  <th style="text-align: center;">Kode Prodi</th>
                  <th style="text-align: center;">Nama Prodi</th>
                  <th style="text-align: center;">Ketua Prodi</th>
                  <th style="text-align: center;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?> 
           		  <?php foreach ($prodi as $row): ?>  
                <tr>
                	<td style="text-align: center;"><?= $i; ?></td>
              		<td><?= $row["kode_jurusan"]; ?></td>
              		<td><?= $row["nama_jurusan"]; ?></td>
              		<td><?= $row["nama_dosen"]; ?></td>
              		<td style="text-align: center;">
               		 <a href="?page=prodi&aksi=ubah&id_jurusan=<?= $row["id_jurusan"]; ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
               		 <!-- <a href="?page=prodi&aksi=hapus&id_jurusan="onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Hapus</a> -->
              		</td>              
                </tr>
                 <?php $i++; ?>
          		   <?php endforeach; ?>
                </tbody>             
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>

        
