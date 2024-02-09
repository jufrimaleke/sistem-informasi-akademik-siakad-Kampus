  <?php 
 // include "../../config/fungsi.php";

  $nim = $_SESSION['mahasiswa'];

  $krs = mysqli_query($conn, "SELECT * FROM khs 
        INNER JOIN jadwal ON khs.id_jadwal = jadwal.id_jadwal
        WHERE khs.nim =  $nim");
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

          $.ajax({
            type: 'POST',
            url: 'views/krs/list_krs.php',
            data: 'prov_id='+list_krs,
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
    Dashboard
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
      <h3 class="box-title">Kartu Rencana Studi</h3>
      <div class="form-group col-md-4 pull-right">
        <?php 
          $prodi = mysqli_query($conn, "SELECT DISTINCT khs.id_semester, khs.nim, semester.nama_semester FROM khs 
           INNER JOIN semester ON khs.id_semester = semester.id_semester
           WHERE khs.nim = $nim");
         ?>

         <select class="form-control select2" id="krs" style="width: 100%;">
           <option value="">- Tahun Akademik -</option>
           <?php while ($row = mysqli_fetch_array($prodi)) { ?>
          <option value="<?php echo $row['id_semester'] ?>"><?php echo $row['nama_semester'] ?></option>
           <?php } ?>
        </select>        
      </div><br><br>
    
<?php
$id_smt = mysqli_query($conn, "SELECT id_semester, status FROM semester WHERE status = '1'");
$d_pisah = mysqli_fetch_assoc($id_smt);

$query_data = mysqli_prepare($conn, "SELECT 
    set_pembayaran.id_set,
    set_pembayaran.nim,
    set_pembayaran.id_semester,
    set_pembayaran.jumlah_bayar,
    set_pembayaran.jumlah_yangdibayar,
    set_pembayaran.approved 
    FROM set_pembayaran 
    INNER JOIN semester ON set_pembayaran.id_semester = semester.id_semester 
    WHERE nim = ? AND set_pembayaran.id_semester = {$d_pisah['id_semester']}");
    mysqli_stmt_bind_param($query_data, "s", $nim);
    mysqli_stmt_execute($query_data);
    $result = mysqli_stmt_get_result($query_data);
    $data_pay = mysqli_fetch_assoc($result);

    if ($data_pay['jumlah_bayar'] === $data_pay['jumlah_yangdibayar'] && $data_pay['approved'] == 1 && $d_pisah['status'] == 1) { 
    ?>
        <a href="?page=krs&aksi=tambah" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah KRS</a>
    <?php 
    } else { 
    ?>
        <a href="#" class="btn btn-danger btn-ms">ANDA BELUM MENYELESAIKAN ADMINISTRASI ATAU BELUM DIAPPROVE!</a>
        <p>Hubungi bagian keuangan!</p>
    <?php 
    } 
    ?>



      
        

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



 

