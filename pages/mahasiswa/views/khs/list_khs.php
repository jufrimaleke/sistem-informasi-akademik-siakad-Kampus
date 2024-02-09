<?php 
session_start();
include "../../../../config/koneksi.php";

$_SESSION['idsemester'] = $_POST['prov_id'];
$id_semester = $_SESSION['idsemester'];

$nim = $_SESSION['mahasiswa'];

  $khs = mysqli_query($conn, "SELECT * FROM jadwal 
          INNER JOIN khs ON jadwal.id_jadwal = khs.id_jadwal
          INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
          WHERE khs.nim = $nim AND khs.id_semester = $id_semester"); 
?>

<?php if ($id_semester == null) {
  echo '
  <div class="content">
  <div style="background-color: #337ab7; color: #fff; padding: 10px;">
        MOHON MAAFT!! TIDAK ADA DATA YANG DITAMPILKAN PILIH TAHUN AKADEMIK
    </div>
<div>
    ';
 } else { ?>
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
        <a target="_blank" href="views/khs/cetak.php" class="btn btn-success btn-ms" class="pull-right"><span class="glyphicon glyphicon-print"></span> Cetak </a>
            <div class="box-body">
          <div class="row" id="nim"> 
          <div class="table-responsive">
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
                <?php $no = 1; $total_sks = 0; $tot_nk = 0; $ips = 0?>

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
                  <?php 
                    if ($row['nilai_huruf'] == "A") {
                      echo "LULUS";
                    } elseif ($row['nilai_huruf'] == "B") {
                      echo "LULUS";
                    } elseif ($row['nilai_huruf'] == "C") {
                      echo "LULUS";
                    } elseif ($row['nilai_huruf'] == "D") {
                      echo "TIDAK LULUS";
                    } elseif ($row['nilai_huruf'] == "E") {
                      echo "TIDAK LULUS";
                    } else {
                      echo "TIDAK LULUS";
                    }
                  ?>
                  </td>
                </tr>
                <?php $no++; ?>

                <?php $total_sks = $total_sks + $row["sks"];  ?>
                <?php $tot_nk = $tot_nk + ($bobot * $row['sks']); ?>
                <?php  $ips = $tot_nk / $total_sks; ?>

                <?php 
                  $ips = $tot_nk / $total_sks;
                  $hasilIps = number_format($ips, 2, '.', '');
                    
                 ?>

                <?php endforeach;?>     
                 
                <tr>
                  <td colspan="3"style="text-align: center;"><b>TOTAL SKS</b></td>
                  <td style="text-align: center;"><?php echo $total_sks; ?></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: center;"><?php echo $tot_nk; ?></td>
                  <td></td>
                  
                </tr>
                <tr>
                   <td colspan="3" style="text-align:center;color:#black;" ><b>TOTAL IPS</b></td>
                   <td colspan="5"align="center"><?= $hasilIps; ?></td>
                   
                </tr>
              </table>
               </div>
            </div>
            <!-- /.box-body --> 
           </div>
         
        </div>
      </div>          
    </section>

<?php } ?>