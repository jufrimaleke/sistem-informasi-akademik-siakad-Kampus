<?php 
  include "../../config/fungsi.php";

 $data = mysqli_query($conn, "SELECT * FROM nama_pembayaran");

 $d = mysqli_fetch_assoc($data);

 $query_angkatan = mysqli_query($conn, "SELECT * from angkatan");
 

 ?>


  
 <section class="content-header">
  <h1>
    Manajemen Keuangan
    
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="#"> Set Keuangan</a></li>
    <li class="active"> Set Keuangan</li>
  </ol>    
  </section>

  <section class="content">
      <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">NAMA PEMBAYARAN</h3>
                        <ul class="nav pull-right">
                            <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fa fa-plus"></i> Tambah Data</a>
                        </ul>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pembayaran</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	$no = 1;
                                	foreach($data as $d) : ?>
                                        <tr>
                                            <td style="text-align: center;" width="10px"><?= $no++ ?></td>
                                            <td><?= $d['nama_pembayaran'] ?></td>
                                            <td><?= $d['keterangan'] ?></td>
                                            <td>
                                                <a href="" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                               <a href="?page=pertanyaantptk&aksi=hapus&id=<?= $d["id"]; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- modal edit -->
     <div class="modal fade" id="editModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #2298BE;">
            <h3 class="modal-title" id="tambahModalLabel">Tambah Aspek</h3>
          </div>
          <div class="modal-body">
             <form action="views/pertanyaantptk/tambah.php" method="POST" rol="form" enctype="multipart/form-data">
             <div class="form-group">
                <label for="nama">Nama Aspek</label>
                <input type="text" name="nama_aspekkeu" class="form-control" required>
             </div>
             <div class="form-group">
                <label for="nama">Aspek</label>
                <select name="aspek" class="form-control">
                    <option>-- Pilih Aspek --</option>
                    <?php foreach ($aspek as $a) : ?>
                    <option value="<?= $a['id_aspek'] ?>"><?= $a['nama_aspek'] ?></option>
                <?php endforeach ; ?>
                </select>
             </div>
             <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="reset" name="reset" class="btn btn-warning">Reset</button>
                  <button type="submit" name="tambah" class="btn btn-success">Edit</button>
               </div>
             </form>
          </div>  
        </div>
      </div>
    </div><!-- modal edit close --> 

     <!-- modal insert -->
     <div class="modal fade" id="tambahModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #2298BE;">
            <h3 class="modal-title" id="tambahModalLabel">Tambah Jenis Pembayaran</h3>
          </div>
          <div class="modal-body">
             <form action="views/setKeuangan/tambah.php" method="POST" rol="form" enctype="multipart/form-data">
             <div class="form-group">
                <label for="nama_aspek">Nama Pembayaran</label>
                <input type="text" name="nama_pembaran" class="form-control" required>
             </div>
             <div class="form-group">
                <label for="Semester">Keterangan</label>
                <input type="text" name="keterangan" class="form-control">
             </div>
             </div>
             <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="reset" name="reset" class="btn btn-warning">Reset</button>
                  <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
               </div>
             </form>
          </div>  
        </div>
      </div>
    </div><!-- modal insert close -->            
    </section>

 
