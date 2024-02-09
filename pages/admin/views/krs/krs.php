<?php 
if (!isset($_SESSION))session_start();
include "../../config/fungsi.php";

$nim = $_GET['nim'];


  ?>
 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
    <script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
      $('#krs').change(function() {
        var list_krs = $(this).val();
        var nim = $('#nim').val(); // Mendapatkan nilai dari elemen dengan ID "nim"

        $.ajax({
          type: 'POST',
          url: 'views/krs/jadwal_mk.php',
          data: {
            prov_id: list_krs,
            nim: nim // Menambahkan nilai nim sebagai parameter
          },
          success: function(response) {
            $('#list_krs').html(response);
          }
        });
      })
    });

    </script>
</head>
 <body>
 <section class="content-header">
  <h1>
    KRS
    <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
    <li class="active"> Rencana Studi</li>
  </ol>    
  </section>

<section class="content">
 <!-- SELECT2 EXAMPLE -->
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Kartu Rencana Studi</h3><br><br>
      <a href="?page=krs&aksi=tambah&nim=<?=$nim ?>" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah KRS</a>
    
      <div class="form-group col-md-4 pull-right">
        <input type="hidden" name="" id="nim" value="<?php echo $nim ?>">    
        <?php 
          $prodi = mysqli_query($conn, "SELECT DISTINCT khs.id_semester, khs.nim, semester.nama_semester FROM khs 
           INNER JOIN semester ON khs.id_semester = semester.id_semester
           WHERE khs.nim = $nim");
         ?>

         <select class="form-control select2" required id="krs" style="width: 100%;">
           <option value="">- Tahun Akademik -</option>
           <?php while ($row = mysqli_fetch_array($prodi)) { ?>
          <option value="<?php echo $row['id_semester'] ?>"><?php echo $row['nama_semester'] ?></option>
           <?php } ?>
        </select> 

       
           
      </div><br><br>
      
    

    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class='box-body table-responsive no-padding'>  
   
         <div id="list_krs">
              
         </div>
        </div>
      </div>
    </div>
  
</section>


 </body>
 </html>



 





 