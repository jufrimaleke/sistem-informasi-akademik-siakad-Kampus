<?php 
  include "../../config/fungsi.php";

  $query_semester = mysqli_query($conn, "SELECT * FROM semester");

 


 ?>


  
 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> laporan keuangan</li>
  </ol>    
  </section>
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">LAPORAN KEUANGAN PER SEMESTER</h3>
              <hr>
            </div>
          <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Tahun Akademik</th>     
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $no = 1;
                while ($data_semester = mysqli_fetch_assoc($query_semester)) { ?>
                
                <tr>
                  <td><?= $no++ ?></td>                               
                  <td><?= $data_semester['nama_semester'] ?></td>
                  <td style="text-align: center;">
                   <a href="?page=laporan_keu&aksi=cetak&id_laporan=<?= $data_semester['id_semester'] ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-print"></i> Cetak</a>

                   <a href="?page=laporan_keu&aksi=detail&id_laporan=<?= $data_semester['id_semester'] ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-search"></i> Detail</a>
                  </td>
                </tr>
                <?php } ?> 
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>

 
