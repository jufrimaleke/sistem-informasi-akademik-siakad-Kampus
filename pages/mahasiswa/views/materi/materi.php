<?php 
  // include "../../config/fungsi.php";

$nim = $_SESSION['nim'];


   $materi = mysqli_query($conn, "SELECT * FROM materi
          INNER JOIN mata_kuliah ON materi.id_mk = mata_kuliah.id_mk");
 ?>
 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
    <script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#prodi').change(function() {
          var provinsi_id = $(this).val();

          $.ajax({
            type: 'POST',
            url: 'views/materi/list_materi.php',
            data: 'prov_id='+provinsi_id,
            success: function(response) {
              $('#materi').html(response);
            }
          });
        })
      });
    </script>
 </head>
 <body> 
 </body>
 </html>

 <section class="content-header">
  <h1>
    Dashboard
    <small>Materi Kuliah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> </li>
  </ol>    
  </section>

   <section class="content">
       <div class="box">
            <div class="box-header">
              <h3 class="box-title"> </h3>
             
                <div class="form-group col-md-4 pull-center center">
                <?php 
                  $prodi = mysqli_query($conn, "SELECT * FROM jadwal
                           INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk    
                           INNER JOIN khs ON jadwal.id_jadwal = khs.id_jadwal                
                           WHERE khs.nim = $nim");
                 ?>
                 <select class="form-control select2" id="prodi" style="width: 100%;">
                   <option value="">- Pilih Mata Kuliah -</option>
                   <?php while ($row = mysqli_fetch_array($prodi)) { ?>
                  <option value="<?php echo $row['id_mk'] ?>"><?php echo $row['nama_mk'] ?></option>
                   <?php } ?>
                </select>        
              </div>
            </div>
            <!-- /.box-header -->
            <div id="materi">
              
            </div>
            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>