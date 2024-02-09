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
      <li class="active"> prodi</li>
  </ol> 
</section>

<!-- Main content -->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header" style="text-align:center;">
              <h3 class="box-title" >Kartu Hasil Studi Studi</h3>
                <br>
               <a href="views/khs/cetak.php" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-print"></span> Cetak </a>
            </div>
           <table class="table-bordered">
             <tr>
               <td>NAMA</td>
               <td>:</td>
               <td><?php echo 'nama'; ?></td>
             </tr>
             <tr>
               <td>NIM</td>
               <td>:</td>
               <td><?php echo 'nama'; ?></td>
             </tr>
             <tr>
               <td>BIDANG STUDI</td>
               <td>:</td>
               <td><?php echo 'nama'; ?></td>
             </tr>
             <tr>
               <td>PROGRAM STUDI</td>
               <td>:</td>
               <td><?php echo 'nama'; ?></td>
             </tr>
             <tr>
               <td>SEMESTER</td>
               <td>:</td>
               <td><?php echo 'nama'; ?></td>
             </tr>
             <tr>
               <td>TAHUN AKADEMIK</td>
               <td>:</td>
               <td><?php echo 'nama'; ?></td>
             </tr>

           </table>
            <!-- /.box-header -->
            <div class="box-body">
              <table style="margin:0 auto;" width="90%" class="table-bordered table-hover">
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
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>          
    </section>


 </body>
 </html>

        
