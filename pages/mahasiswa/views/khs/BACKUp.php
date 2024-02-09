 <?php 
  include "../../config/fungsi.php";

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
        $('#thn_akademik').change(function() {
          var provinsi_id = $(this).val();

          $.ajax({
            type: 'POST',
            url: 'views/khs/list_khs.php',
            data: 'prov_id='+provinsi_id,
            success: function(response) {
              $('#semester').html(response);
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
              <div class="form-group">
                 <input class="form-control select2" readonly="true" value="<?php echo $row['bidang_studi'] ?> "/>
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
                   <select class="form-control select2" id="semester" style="width: 100%;">
                   
                    <option> </option>
                  </select>
              </div> 
            <div class="form-group">
              <?php 
                $semester = mysqli_query($conn, "SELECT DISTINCT semester.id_semester, nama_semester FROM semester
                            INNER JOIN khs ON semester.id_semester = khs.id_semester
                            WHERE khs.nim = $nim");
               ?>
               <select class="form-control select2"  id="thn_akademik" style="width: 100%;" >
                 <?php while ($row = mysqli_fetch_array($semester)) { ?>
                <option value=""> pilih tahun akademik </option>
                <option value="<?php echo $row['id_semester'] ?>"><?php echo $row['nama_semester'] ?></option>
                <?php } ?>
              </select>
            </div>
           
          </div> </form></div>
          <div class="form-group">
                <input type="text" class="form-control" style="text-align: center;" value="KARTU HASIL STUDI" readonly="">
          </div>
          <div id="semester"> 
              <!-- <table style="margin:0 auto;" width="90%" class="table-bordered table-hover">
                <tr>
                  <th rowspan="2">No.</th>
                  <th rowspan="2">Kode MK</th>
                  <th rowspan="2">Mata Kuliah</th>
                  <th rowspan="2">K</th>
                  <th colspan="2">Nilai</th>
                  <th rowspan="2">N x K</th>
                  <th rowspan="2">Keterangan</th>
                </tr>               
                 <tr>
                  <th> N </th>
                  <th> H </th>
                </tr>
                <?php $no = 1; $total_sks = 0; $tot_nk = 0;?>

                <?php foreach ($khs as $row) : ?>
                <tr>
                	<td style="text-align: center;"><?= $no .= '.';   ?></td>
              		<td style="text-align: center;"><?= $row['kode_mk'];?></td>
              		<td><?= $row['nama_mk'];?></td>
              		<td style="text-align: center;"><?= $row['sks'];?></td>
              		<td style="text-align: center;">
                  <?php 
                  $bobot = 0;
                  if ($row['nilai_huruf'] == 'A') {
                    echo $bobot = 4;
                  } elseif ($row['nilai_huruf'] == 'B') {
                    echo $bobot = 3;
                  } elseif ($row['nilai_huruf'] == 'C') {
                    echo $bobot = 2;
                  } elseif ($row['nilai_huruf'] == 'D') {
                    echo $bobot = 1;
                  } elseif ($row['nilai_huruf'] == 'D') {
                    echo $bobot;
                  } elseif ($row['nilai_huruf'] == 'E') {
                    echo $bobot;
                  }
                   ?>
                  </td>
                  <td style="text-align: center;"><?= $row['nilai_huruf'] ?></td>
                  <td style="text-align: center;"><?= $bobot * $row['sks']; ?></td>
                  <td style="text-align: center;">
                  <?php if ($bobot = "A" || "B" ||"C") {
                    echo "LULUS";
                  } else {
                    echo "TIDAK LULUS";
                  }
                  ?>
                  </td>
                </tr>
                <?php $no++; ?>

                <?php $total_sks = $total_sks + $row["sks"];  ?>
                <?php $tot_nk = $tot_nk + ($bobot * $row['sks']); ?>

                <?php endforeach;?>     
                 
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: center;"><?php echo $total_sks; ?></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: center;"><?php echo $tot_nk; ?></td>
                </tr>
              </table>
               <a href="views/khs/cetak.php" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-print"></span> Cetak </a>
            </div> -->
            <!-- /.box-body --> 
           </div>
          </div>
        </div>
      </div>          
    </section>
    </body>
 </html>

        
