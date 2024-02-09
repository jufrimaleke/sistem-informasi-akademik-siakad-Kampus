<?php 
date_default_timezone_set('Asia/Singapore');
include "../../config/fungsi.php";

?>

 <section class="content-header">
  <h1>
    Dashboard
     <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
      <li class="active"> pengumuman</li>
  </ol> 
</section>

<!-- Main content -->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
             
               <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah_pengumuman"><i class="fa fa-plus"></i> Tambah Pengumuman</a>
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th style="text-align: center;">No.</th>
                  <th style="text-align: center;">Nama Pengumuman</th>
                  <th style="text-align: center;">Jenis Pengumuman</th>
                  <th style="text-align: center;">Tujuan</th>
                  <th style="text-align: center;">Isi Pengumuman</th>
                  <th style="text-align: center;">Status</th>
                   <th style="text-align: center;">Update_date</th>
                  <th style="text-align: center;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php $query_data = mysqli_query($conn,"SELECT * FROM pengumuman"); ?>
                <?php foreach ($query_data as $data_p) { ?>
                	
                
                <tr>
                	<td><?= $no++ ?></td>
              		<td><?= $data_p['nama_pengumuman'] ?></td>
              		<td><?= $data_p['jenis_pengumuman'] ?></td>
              		<?php if ($data_p['tujuan'] == 2): ?>
    					    <td>MAHASSIWA</td>
        					<?php elseif ($data_p['tujuan'] == 1): ?>
        					    <td>DOSEN</td>
        					<?php endif ?>

              		<td><?= ($data_p['isi_pengumuman']) ?></td>
              		<?php if ($data_p['status_post'] == 1): ?>
                    <td>
                      <a href="#" class="btn btn-success" data-toggle="modal" data-target="#nonaktifkan<?= $data_p['id_pengumuman'] ?>" >Disabled</a>
                    </td>
                  <?php else : ?>
                    <td>
                      <a href="" data-toggle="modal" data-target="#aktifkan<?= $data_p['id_pengumuman'] ?>" class="btn btn-danger">Enable</a>
                    </td>
                  <?php endif ?>

                  <td><?= $data_p['status_date'] ?></td>
              		<td style="text-align: center;">
               		 <a href="?page=pengumuman&aksi=ubah_pengumuman&id_pengumuman=<?= $data_p['id_pengumuman'] ?>"class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Ubah</a>

               		 <a href="" data-toggle="modal" class="btn btn-danger btn-xs" data-target="#hapus<?= $data_p['id_pengumuman'] ?>"><i class="glyphicon glyphicon-trash"></i> Hapus</a>

               		 <!-- <a href="#" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-search"></i> Preview</a> -->
              		</td>            
                </tr>


                
              

            <!-- MODAL HAPUS -->
              <div class="example-modal">
              <div id="hapus<?= $data_p['id_pengumuman'] ?>" class="modal fade" role="dialog" style="display:none;">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header" style="background: #2298BE;">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">HAPUS PENGUMUMAN</h3>
                    </div>
                    <div class="modal-body">
                      <form action="views/pengumuman/proses_pengumuman.php" method="POST" rol="form" enctype="multipart/form-data">
                        <div class="form-group">
                          <h3 class="modal-title">YAKIN AKAN MENGHAPUS PENGUMUMAN " <b><?= $data_p['nama_pengumuman'] ?>"</b></h3>
                          <input type="hidden" name="id_pengumuman" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                   <a href="?page=pengumuman&aksi=hapus_pengumuman&id_pengumuman=<?= $data_p['id_pengumuman'] ?>" class="btn btn-primary">Hapus</a>
                  </div>
                      </form>
                    </div>  
                  </div>
                </div>
              </div>
            </div><!-- AND MODAL HAPUS -->

            <!-- MODAL AKTIFKAN PENGUMUMAN -->
            <div class="example-modal">
            <div id="aktifkan<?= $data_p['id_pengumuman'] ?>" class="modal fade" role="dialog" style="display:none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header" style="background: #2298BE;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">HALAMAN KOMFORMASI</h3>
                  </div>
                  <div class="modal-body">
                    <h3 align="center"><b>AKTIFKAN PENGUMUMAN INI?</b></h3>
                    <div class="modal-footer">
                        <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close
                        </button>
                        <a href="?page=pengumuman&aksi=aktifkan&id_pengumuman=<?= $data_p['id_pengumuman'] ?>" class="btn btn-primary">Aktikan</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- end modal aktifkan -->



           <!-- modal Nonaktif -->
            <div class="example-modal">
            <div id="nonaktifkan<?= $data_p['id_pengumuman'] ?>" class="modal fade" role="dialog" style="display:none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header" style="background: #2298BE;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">HALAMAN KONFIRMASI</h3>
                  </div>
                  <div class="modal-body">
                    <h3 align="center"><b>NON-AKTIFKAN PENGUMUMAN INI?</b></h3>
                  </div>
                  <div class="modal-footer">
                    <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                     <a href="?page=pengumuman&aksi=nonaktifkan&id_pengumuman=<?= $data_p['id_pengumuman'] ?>" class="btn btn-primary">Non-aktif</a>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- MODAL NON AKKTIF --> 


            <?php }  ?>
                </tbody>             
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>

           
 <!-- modal aktifkan -->
                         

    <!-- MODAL TAMBAH -->
        <div class="example-modal">
        <div id="tambah_pengumuman" class="modal fade" role="dialog" style="display:none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background: #2298BE;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">TAMBAH PENGUMUMAN</h3>
              </div>
              <div class="modal-body">
                <form action="views/pengumuman/proses_pengumuman.php" method="POST" rol="form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label>Nama Pemgumuman</label>
                      <input type="text" name="nama_pengumuman" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label>Sifat Pengumuman</label>
                      <input type="text" name="jenis_pengumuman" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label>Tujuan Pemgumuman</label>
                      <select name="tujuan_pengumuman" class="form-control" required>
                        <option value="">--Pilih--</option>
                        <option value="1">DOSEN</option>
                        <option value="2">MAHASISWA</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Isi Pengumuman</label>
                      <textarea type="text" class="form-control" required id="editor1" name="isi_pengumuman">
                      </textarea>
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                       <select class="form-control" name="status">
                         <option>--Pilih--</option>
                         <option value="0">Disabled</option>
                         <option value="1">Enable</option>
                       </select>
                    </div>
                    <div class="form-group">
                      <label>Date</label>
                       <input class="form-control"  required="" readonly="true" name="date" value="<?php echo date('Y-m-d H:i:s') ?>">
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
        </div>
      </div><!-- AND MODAL TAMBAH -->           



    