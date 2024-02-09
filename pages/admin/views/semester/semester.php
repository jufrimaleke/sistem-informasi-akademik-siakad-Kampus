<?php 
  include "../../config/fungsi.php";
  $semester = mysqli_query($conn, "SELECT * FROM semester");

 ?>


 <section class="content-header">
  <h1>
    Dashboard
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> Semester</li>
  </ol>    
  </section>

  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Semester</h3>
              <!--  <a href="?page=semester&aksi=tambah" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
               <a href="views/semester/cetak.php" class="btn btn-success btn-ms"> <span class="glyphicon glyphicon-print"></span>Cetak </a> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID Semester</th>
                  <th>Nama Semester</th>
                  <th>Deadline Pembayaran</th>
                  <th>Stastus Semester</th>
                  <th>Aksi</th>
                  
                 
                </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($semester as $row) :  ?>   
                <tr>                                  
                  <td><?= $row["id_semester"]; ?></td>
                  <td><?= $row["nama_semester"]; ?></td>
                   <td><?= $row["deadline_time"]; ?></td>             
                  <td>
                    <a href="javascript:void(0);" onclick="toggleStatus(<?php echo $row['id_semester']; ?>);" 
                      class="btn btn-primary btn-xs status-toggle-btn <?php echo ($row['status'] == '1') ? 'btn-success' : 'btn-danger' ?>"
                      data-id_semester="<?php echo $row['id_semester']; ?>"
                      data-status="<?php echo $row['status']; ?>">
                      <i class="glyphicon glyphicon-edit"></i>
                      <?php
                      if ($row['status'] == '1') {
                          echo "Nonaktif";
                      } else {
                          echo "Aktifkan";
                      }
                      ?>
                    </a>
                  </td>
                   <td>
                     <a href="" data-toggle="modal" data-target="#edit<?= $row['id_semester'] ?>"class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>
                     </a>
                  </td>
                   <!-- EDIT DEADLINE -->
                    <div class="example-modal">
                    <div id="edit<?= $row['id_semester'] ?>" class="modal fade" role="dialog" style="display:none;">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header" style="background: #2298BE;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">KONFIRMASI EDIT DEADLINE</h3>
                          </div>
                          <div class="modal-body">
                            <form action="" method="post" role="form" enctype="multipart/form-data">
                                <input type="hidden" name="id_semester" value="<?= $row['id_semester'] ?>">
                                <div class="form-group">
                                    <label for="deadline">Pilih Waktu Deadline:</label>
                                    <input type="datetime-local" id="deadline" class="form-control" name="deadline" value="<?= $row['deadline_time'] ?>" required>
                                </div>
                            <div class="modal-footer">
                            <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                           <button type="submit" name="ubah" class="btn btn-primary pull-left">Ubah</button>
                          </div>
                            </form>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div><!-- end modal EDIT DEADLINE --> 

                  <?php $i++; ?>               
                  <?php endforeach; ?>
                </tr>                
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>

 <!-- jQuery 3 -->
<script>
    function toggleStatus(idSemester) {
        $.ajax({
            url: "?page=semester&aksi=status&id_semester=" + idSemester,
            type: "GET",
            success: function(response) {
                console.log(response);
                
                var button = $('[data-id_semester="' + idSemester + '"]');
                if (button) {
                    var status = button.attr('data-status');
                    if (status === '1') {
                        button.html("Aktifkan");
                        button.removeClass('btn-success').addClass('btn-danger');
                        button.attr('data-status', '0');
                    } else {
                        button.html("Nonaktif");
                        button.removeClass('btn-danger').addClass('btn-success');
                        button.attr('data-status', '1');
                    }
                }

                // Memaksa pembaruan halaman
                location.reload();
            }
        });
    }
</script>

<?php 

if (isset($_POST['ubah'])) {
  $id = $_POST['id_semester'];
  $deadline = $_POST['deadline'];


  $query_ubah = mysqli_query($conn, "UPDATE semester SET
          id_semester = '$id',
          deadline_time = '$deadline'
          WHERE id_semester = '$id'");

  if ($query_ubah) {
    echo "<script>alert('Data berhasil diupdate')</script>";
  }else {
    echo "<script>alert('Data gagal diupdate')</script>";
  }

 
}

?>

