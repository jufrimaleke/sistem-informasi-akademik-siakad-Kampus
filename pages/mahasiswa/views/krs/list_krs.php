<?php 
session_start();
  include "../../../../config/fungsi.php";


$_SESSION['idsemester'] = $_POST['prov_id'];
$id_semester = $_SESSION['idsemester'];



$nim = $_SESSION['mahasiswa'];


$query = mysqli_query($conn, "SELECT * FROM mahasiswa INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan WHERE nim = $nim");
$data = mysqli_fetch_assoc($query);

$periode = mysqli_query($conn, "SELECT * FROM semester WHERE status = 1");

$periode = mysqli_query($conn, "SELECT * FROM semester WHERE id_semester = '$id_semester'");
$prd = mysqli_fetch_assoc($periode);

 ?>

<?php 
if ($id_semester == null) {
     echo '<div style="background-color: #337ab7; color: #fff; padding: 10px;">
        MOHON MAAFT!! TIDAK ADA DATA YANG DITAMPILKAN
    </div>';
} else { ?>
 <center>
        <legend class="mt-3"><strong>KARTU RENCANA STUDI</strong></legend>

        <table>
            <tr>
                <td><strong>NIM</strong></td>
                <td>&nbsp;: <?php echo $_SESSION['nim']; ?></td>
            </tr>
            <tr>
                <td><strong>Nama Lengkap</strong></td>
                <td>&nbsp;: <?php echo $_SESSION['nama']; ?></td>
            </tr>
            <tr>
                <td><strong>Nama Prodi</strong></td>
                <td>&nbsp;: <?php echo $data['nama_jurusan']; ?> </td>
            </tr>
            <tr>
                <td><strong>Tahun Akademik (Semester)</strong></td>
                <td>&nbsp;: <?php echo $prd['nama_semester'] ?> </td>
            </tr>
        </table>
</center><br><br>

            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
                    <table class="table table-hover"> 
                        <tr>
                            <th>Aksi</th>
                            <th>No</th>
                            <th>Kode MatKul</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>SKS</th>
                        </tr>
                        <?php 
                            $jadwal = mysqli_query($conn, "SELECT * FROM jadwal
                               INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
                               INNER JOIN dosen ON jadwal.nip = dosen.nip
                               INNER JOIN khs ON jadwal.id_jadwal = khs.id_jadwal
                               INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
                               WHERE khs.nim = $nim AND khs.id_semester = '$id_semester'"); 
                        ?> 
                        <?php $no = 1; 
                              $jumlahSks = 0;
                             
                        ?>
                        <?php $query = mysqli_query($conn, "SELECT id_semester from approve"); ?>
                        <?php $idsmt = mysqli_fetch_assoc($query) ?>
                        <?php foreach ($jadwal as $row) : ?>
                            <tr>
                                <td>
                                  <?php $periode = mysqli_query($conn, "SELECT * FROM semester WHERE status = 1 And id_semester = $id_semester"); ?>

                                  <?php if (mysqli_num_rows($periode) == 1) { ?>
                                    <a href="#" class="btn btn-danger btn-xs disabled"><i class="glyphicon glyphicon-trash"></i></a>
                                  <?php } else { ?>
                                    <a href="?page=krs&aksi=hapus&id_khs=<?= $row["id_khs"]; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>

        
                                  <?php } ?>
                                </td>

   
                                <td><?= $no++ ?></td>            
                                <td><?= $row['kode_mk'] ?></td>
                                <td><?= $row['nama_mk'] ?></td>
                                <td><?= $row['nama_kelas'] ?></td>
                                <td><?= $row['sks']; $jumlahSks+= $row['sks']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5" align="right"><strong>Jumlah SKS : </strong></td>
                            <td colspan="1"><strong><?= $jumlahSks; ?></strong></td>
                        </tr><br>

                                <a href="views/krs/cetak.php" class="btn btn-warning btn-ms" target="_blank">
                                    <span class="glyphicon glyphicon-print"></span> Cetak
                                </a>
                                <br><br>
                               
            




                    </table>
                </div>
            </div>
            
    </section>
<?php } ?>