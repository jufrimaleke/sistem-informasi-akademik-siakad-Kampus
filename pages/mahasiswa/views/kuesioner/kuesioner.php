<?php

$conn  = mysqli_connect("localhost","root","","siakadstiks");

$prdquery = mysqli_query($conn, "SELECT id_semester,kuesioner FROM semester WHERE kuesioner = '1'");
$prd = mysqli_fetch_assoc($prdquery);
$dataPrd =  $prd['id_semester'];
$nim = $_SESSION['nim'];

$aspek = mysqli_query($conn,"SELECT * FROM aspek");

?>

<section class="content-header">
    <h1>
        <?php if (isset($prd['isaktif']) && $prd['isaktif'] == 'true') : ?>
            Pengisian Kuesioner Telah Dibuka !
        <?php else : ?>
            Pengisian Kuesioner ditutup !
        <?php endif; ?>
    </h1>
</section>


<section class="content">
  <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="">
    <?php foreach ($aspek as $asp) : ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
            <div class="table-responsive-sm">
              <table border="1" class="display table table-striped table-hover table-sm" bordercolor=#9B9B9B align="center" cellspacing="0" cellpadding="0">
                <tr>
                  <td rowspan="2" align="center" bgcolor="#FF9D9D" class="bg-primary">
                      <b>
                          <font face="Calibri" size="4">NO.</font>
                      </b>
                  </td>
                  <td rowspan="2" align="left" bgcolor="#FF9D9D" class="bg-primary">
                      <b>
                          <font face="Calibri" size="4"><?= strtoupper($asp['nama_aspek']) ?></font>
                      </b>
                  </td>
                  <td align="center" colspan="5" class="bg-primary">
                      <b>
                          <font face="Calibri" size="4">HARAPAN</font>
                      </b>
                  </td>
                  <td align="center" colspan="5" bgcolor="#FF9D9D" class="bg-info">
                      <b>
                          <font face="Calibri" size="4">KENYATAAN</font>
                      </b>
                  </td>
                </tr>
                <tr>
                  <td align="center" class="bg-primary" style="width: 3%;">
                    <b><font face="Calibri" size="4">1</font></b>
                  </td>
                  <td align="center" class="bg-primary" style="width: 3%;">
                    <b><font face="Calibri" size="4">2</font></b>
                  </td>
                  <td align="center" class="bg-primary" style="width: 3%;">
                    <b><font face="Calibri" size="4">3</font></b>
                  </td>
                  <td align="center" class="bg-primary" style="width: 3%;">
                    <b><font face="Calibri" size="4">4</font></b>
                  </td>
                  <td align="center" class="bg-primary" style="width: 3%;">
                    <b><font face="Calibri" size="4">5</font></b>
                  </td>
                  <td align="center" class="bg-info" style="width: 3%;">
                    <b><font face="Calibri" size="4">1</font></b>
                  </td>
                  <td align="center" class="bg-info" style="width: 3%;">
                    <b><font face="Calibri" size="4">2</font></b>
                  </td>
                  <td align="center" class="bg-info" style="width: 3%;">
                    <b><font face="Calibri" size="4">3</font></b>
                  </td>
                  <td align="center" class="bg-info" style="width: 3%;">
                    <b><font face="Calibri" size="4">4</font></b>
                  </td>
                  <td align="center" class="bg-info" style="width: 3%;">
                    <b><font face="Calibri" size="4">5</font></b>
                  </td>
                </tr>


                <?php
                $no = 1;
                $asked = mysqli_query($conn, "SELECT * FROM pertanyaan WHERE id_aspek = '".$asp['id_aspek']."'");
                while ($ask = mysqli_fetch_array($asked)) { ?>

                  <input type="hidden" name="username[<?= $ask['id_pertanyaan'] ?>]" value="<?= $_SESSION['nim'] ?>">
                  <input type="hidden" name="id_aspek[<?= $ask['id_pertanyaan'] ?>]" value="<?= $asp['id_aspek'] ?>">
                  <input type="hidden" name="id_pertanyaan[<?= $ask['id_pertanyaan'] ?>]" value="<?= $ask['id_pertanyaan'] ?>">
                  <tr>
                    <td bgcolor="#F9EDED" align="center" style="width: 3%;">
                      <font face="Calibri" size="3"><?= $no ?></font>
                    </td>
                    <td bgcolor="#F9EDED">
                      <font face="Calibri" size="3"><?= $ask['pertanyaan'] ?></font>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="harapan[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="1" required>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="harapan[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="2" required>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="harapan[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="3" required>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="harapan[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="4" required>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="harapan[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="5" required>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="nyata[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="1" required>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="nyata[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="2" required>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="nyata[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="3" required>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="nyata[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="4" required>
                    </td>
                    <td bgcolor="#F9EDED" align="center">
                      <input name="nyata[<?= $ask['id_pertanyaan'] ?>]" type="radio" value="5" required>
                    </td>
                  </tr>
                <?php
                  $no++;
                }
                ?>

              </table>
            </div>
          </div>              
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  <div class="row">
      <div class="col-xs-12">
          <div class="box box-primary">
              <div class="box-body">
                  <div class="form-group">
                      <label for="harapan" class="col-sm-2 control-label">Harapan</label>
                      <div class="col-sm-10">
                          <textarea type="text" class="form-control" required id="editor" name="textharapan" value=""></textarea>
                         
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="masukan" class="col-sm-2 control-label">Masukan</label>
                      <div class="col-sm-10">
                          <textarea type="text" class="form-control" required id="editor1" name="textmasukan" value=""></textarea>
                         
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <button type="submit" class="btn btn-success">Send</button>
  <input type="hidden" name="submitted" value="insert" />
  </form> 

<?php

if (isset($_POST['submitted']) && $_POST['submitted'] === 'insert') {
    
    foreach ($_POST['harapan'] as $ask_id =>$id_pertanyaan) {   
        $nyata            = $_POST['nyata'][$ask_id];
        $idAsp            = $_POST['id_aspek'][$ask_id];
        $nim              = $_POST['username'][$ask_id];
        $idask            = $_POST['id_pertanyaan'][$ask_id];

        $insert_query = "INSERT INTO respon (id_respon, id_semester, id_pertanyaan, id_aspek, username, harapan, nyata) VALUES ('', '$dataPrd', $idask, '$idAsp', '$nim', '$id_pertanyaan', '$nyata')";
        $result = mysqli_query($conn, $insert_query);

       
        if (!$result) {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
           
        }
    }
   
}


?>


<?php


// Query untuk mengambil data dari tabel 'respon' (gantilah dengan nama tabel yang sesuai)
$query = "SELECT harapan, username, nyata FROM respon where username = '$nim'"; // Sesuaikan dengan nama tabel Anda
$result = mysqli_query($conn, $query);

if ($result) {
    $h = 0;
    $n = 0;
    $no = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        $h += $row['harapan'];
        $n += $row['nyata'];
    }

    $no = 1;
    $na = 0;

    mysqli_data_seek($result, 0); // Reset cursor hasil kueri ke awal

    while ($row = mysqli_fetch_assoc($result)) {
        $na += ((($row['harapan'] / $h) * 100) / 100);
    }

    $ms = 0;
    $ws = 0;

    $no = 1;

    mysqli_data_seek($result, 0); // Reset cursor hasil kueri ke awal

    while ($row = mysqli_fetch_assoc($result)) {
        $ms += $row['nyata'];
        $ws += ((($row['harapan'] / $h) * 100) / 100) * $row['nyata'];
    }

    // Mengganti angka 4 dengan 5
    $range = 5;

    // Menghitung persentase berdasarkan rentang 5
    $persentase = ($ws / $range) * 100;

    // Menentukan keterangan berdasarkan persentase
    if ($persentase <= 25) {
        $ket = "Kurang";
    } elseif ($persentase >= 26 && $persentase <= 50) {
        $ket = "Cukup";
    } elseif ($persentase >= 51 && $persentase <= 75) {
        $ket = "Baik";
    } else {
        $ket = "Sangat Baik";
    }

    // Tutup hasil kueri
    mysqli_free_result($result);
} else {
    echo "Kueri database gagal: " . mysqli_error($conn);
}

// Tutup koneksi database
mysqli_close($conn);
?>

<div class="box-body">
    <h2 class="text-center">CSI Result</h2>
    <div class="col-lg-4 col-xs-6"></div>
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <!-- Menampilkan persentase dan keterangan -->
                <h3 class="text-center"><?= number_format($persentase, 2) ?><sup style="font-size: 20px">%</sup></h3>
                <p class="text-center"><?= $ket ?></p>
            </div>
            <div class="icon">
                <br> <i class="ion ion-stats-bars"></i>
            </div>
            <br>
            <br>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6"></div>
</div>


</section>








