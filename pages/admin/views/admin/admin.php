<?php 
  include "../../config/fungsi.php";
  $dosen = mysqli_query($conn, "SELECT * FROM dosen");

 ?>


 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> Dosen</li>
  </ol>    
  </section>

  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Dosen</h3>
               <a href="?page=dosen&aksi=tambah" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
               <a href="views/dosen/cetak.php" class="btn btn-success btn-ms"> <span class="glyphicon glyphicon-print"></span> Cetak </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  <th>Email</th>
                  <th>Foto</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($dosen as $row) :  ?>   
                <tr>                                  
                  <td><?= $row["nip"]; ?></td>
                  <td><?= $row["nama"]; ?></td>
                  <td><?= $row["jenis_kelamin"]; ?></td>
                  <td><?= $row["alamat"]; ?></td>
                  <td><?= $row["email"]; ?></td>
                  <td><img src="../../assets/img/<?= $row["foto"]; ?>"  width="50px"></td>  
                  <td style="text-align: center;">
                   <a href="?page=dosen&aksi=ubah&nip=<?= $row["nip"]; ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                   <a href="?page=dosen&aksi=hapus&nip=<?= $row["nip"]; ?>"onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                  </td>
                  <?php $i++; ?>               
                  <?php endforeach; ?>
                </tr>                
                </tbody>
                <tfoot>
                <tr>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  <th>Email</th>
                  <th>Foto</th>
                  <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>

 <!-- jQuery 3 -->
