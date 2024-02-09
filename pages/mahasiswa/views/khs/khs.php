 <?php 
  // include "../../config/fungsi.php";

  $nim = $_SESSION['mahasiswa'];
  $khs = mysqli_query($conn, "SELECT * FROM khs 
          INNER JOIN jadwal ON khs.id_krs = jadwal.id_krs
          INNER JOIN mata_kuliah ON khs.id_mk = mata_kuliah.id_mk
          WHERE khs.nim = $nim"); 

  $mahasiswa = mysqli_query($conn, "SELECT DISTINCT nim khs
               INNER JOIN mahasiswa ON khs.nim = mahasiswa.nim
               WHERE khs.nim = $nim");
 ?> 
 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
   <style type="text/css">
   th { text-align: center; }
   td { padding: 10px;}
   </style>

   <script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
      <script>
      $(document).ready(function() {
        $('#prodi').change(function() {
          var provinsi_id = $(this).val();

          $.ajax({
            type: 'POST',
            url: 'views/khs/list_khs.php',
            data: 'prov_id='+provinsi_id,
            success: function(response) {
              $('#nim').html(response);
            }
          });
        })
      });
    </script>
 </head>
 <body>

 <section class="content-header">
  <h1>
    Dashboard
     <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
      <li class="active"> khs</li>
  </ol> 
</section>

<!-- Main content -->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body">
            <h3>Kartu Hasil Studi</h3>
            <div class="row">
            <div class="col-md-6">
              <form action="" method="POST">
              <div class="form-group">
                <?php 
                  $mhs = mysqli_query($conn, "SELECT * FROM mahasiswa 
                    INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
                    WHERE mahasiswa.nim = $nim");
                 ?>                
                   <?php while ($row = mysqli_fetch_array($mhs)) { ?>                 
                  <input class="form-control select2" readonly="true" value="<?php echo $row['nama'] ?> "/>
              </div>

              <div class="form-group">
                   <input class="form-control select2" readonly="true" value="<?php echo $row['nim'] ?> "/>
                  
              </div>
                     
              <!-- /.form-group -->
            </div>

            <div class="col-md-6">
            <div class="form-group">
                 <input class="form-control select2" readonly="true" value="<?php echo $row['nama_jurusan'] ?> "/>
                   <?php } ?>
              </select>
            </div>
             
            <div class="form-group">
            <?php 
              $semester = mysqli_query($conn, "SELECT DISTINCT semester.id_semester, nama_semester FROM semester
                          INNER JOIN khs ON semester.id_semester = khs.id_semester
                          WHERE khs.nim = '$nim'");
            
             ?>

      
             

              <select class="form-control select2" name="prodi" required  id="prodi" style="width: 100%;"  >
                
               <option value=""> pilih tahun akademik </option>
                 <?php while ($row = mysqli_fetch_array($semester)) { ?>
                
                <option value="<?php echo $row['id_semester'] ?>"><?php echo $row['nama_semester'] ?></option>

                
                <?php } ?>
              </select>  
          </div>
            </select>
         
          </div>

           
          </div> 
        </form>

          <div class="form-group">
                <input type="text" class="form-control" style="text-align: center;" value="KARTU HASIL STUDI" readonly="">
          </div>

          <div class="row" id="nim"> 
              
           </div>
    
         
          </div>

        </div>
 </div>
      </div>          
    </section>






    </body>
 </html>

        
