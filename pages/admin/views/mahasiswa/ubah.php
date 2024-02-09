<?php 
  include "../../config/fungsi.php";

  $dosen = mysqli_query($conn, "SELECT nip, nama_dosen FROM dosen");
  $prodi = mysqli_query($conn, "SELECT id_jurusan,nama_jurusan FROM jurusan");
  $angkatan = mysqli_query($conn, "SELECT id_angkatan FROM angkatan");
  // ambil data di URL
  $nim = @$_GET["nim"];
$nim = mysqli_real_escape_string($conn, $nim);

$mhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = '$nim'");

$mahasiswa = mysqli_fetch_assoc($mhs);


$cek_mhs = mysqli_query($conn,"SELECT nim FROM khs WHERE khs.nim = '$nim'");

  if(isset($_POST["submit"])){
 
  // cek apakah  data berhasil diubah atau tidak
  if(ubah_mahasiswa($_POST) > 0 ){
    echo "
      <script>
        alert('data berhasil diubah:');
        document.location.href = '?page=mahasiswa';
      </script>";
  } else {
    echo "
      <script>
        alert('data gagal diubah:');
        document.location.href = '?page=mahasiswa';
      </script>";
  }

}

 ?>


 <section class="content-header">
  <h1>
    Dashboard
     <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
      <li class="active"> Ubah Mahasiswa</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->

          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Mahasiswa</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" name="fotoLama" value="<?= $mahasiswa["foto"]; ?>">
                    <input type="hidden" name="nim" id="nim" placeholder="NIM" value="<?= $mahasiswa['nim'] ?>"> 
                  <div class="form-group">
                    <label for="nim">NIM</label>
                    <?php if (mysqli_num_rows($cek_mhs) > 0) { ?>
                       <input type="text" class="form-control" name="nim1" id="nim1" disabled placeholder="NIM" value="<?= $mahasiswa['nim'] ?>"> 
                    <?php } else {?>
                       <input type="text" class="form-control" name="nim1" id="nim1" placeholder="NIM" value="<?= $mahasiswa['nim'] ?>">
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" autocomplete="off" name="nama" id="nama" value="<?= $mahasiswa['nama'] ?>" placeholder="Nama" required>
                  </div>
                   <div class="form-group">
                      <label for="jk">Jenis Kelamin</label>
                      <select name="jk" class="form-control" id="jk">
                        <option value="">- Pilih -</option>
                        <option value="P" <?php if ($mahasiswa['jenis_kelamin'] == 'P') echo 'selected'; ?>>P</option>
                        <option value="L" <?php if ($mahasiswa['jenis_kelamin'] == 'L') echo 'selected'; ?>>L</option>
                      </select>
                    </div>

                   <div class="form-group">
                    <label for="tempat">Tempat Lahir</label>
                    <input type="text" class="form-control" autocomplete="off" name="tempat" value="<?= $mahasiswa["tempat_lahir"]; ?>" id="tempat" placeholder="Tempat Lahir" required>
                  </div>
                  <div class="form-group">
                    <label for="tgl">Tanggal Lahir</label>
                    <input type="date" class="form-control" autocomplete="off" name="tgl"  value="<?= $mahasiswa["tgl_lahir"]; ?>" placeholder="Tanggal Lahir" required>
                  </div>
                   <div class="form-group">
                    <label for="nik">Nik</label>
                    <input type="text" class="form-control" autocomplete="off" name="nik" value="<?= $mahasiswa["nik"]; ?>" id="nik" placeholder="Nik" required>
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" autocomplete="off" name="alamat" id="alamat" value="<?= $mahasiswa["alamat"]; ?>" placeholder="Alamat" required>
                  </div>
                   <div class="form-group">
                    <label for="telp">Telepon</label>
                    <input type="text" class="form-control" autocomplete="off" name="telp" id="telp" value="<?= $mahasiswa["telp"]; ?>" placeholder="Telepon" required>
                  </div>
                  <div class="form-group">
                    <label for="angkatan">Angkatan</label>
                    <select name="angkatan" class="form-control" id="angkatan">
                     
                      <?php foreach ($angkatan as $angkatan_item): ?>
                          <option value="<?= $angkatan_item["id_angkatan"]; ?>" <?= ($mahasiswa["id_angkatan"] == $angkatan_item["id_angkatan"]) ? "selected" : ""; ?>>
                              <?= $angkatan_item["id_angkatan"]; ?>
                          </option>
                      <?php endforeach; ?>
                  </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" autocomplete="off" name="email" id="email" value="<?= $mahasiswa["email"]; ?>"  required>
                  </div>
                  <div class="form-group">
                  <div class="form-group">
                  <label for="agama">Agama</label>
                    <select name="agama" class="form-control" id="agama" value="<?=$mahasiswa['agama'] ?>"> 
                     
                        <option value="Islam" <?php if ($mahasiswa['agama'] == 'Islam') echo 'selected'; ?>>Islam</option>
                        <option value="Kristen" <?php if ($mahasiswa['agama'] == 'Kristen') echo 'selected'; ?>>Kristen</option>
                        <option value="Katholik" <?php if ($mahasiswa['agama'] == 'Katholik') echo 'selected'; ?>>Katholik</option>
                        <option value="Hindu" <?php if ($mahasiswa['agama'] == 'Hindu') echo 'selected'; ?>>Hindu</option>
                        <option value="Budha" <?php if ($mahasiswa['agama'] == 'Budha') echo 'selected'; ?>>Budha</option>
                        <option value="Konghucu" <?php if ($mahasiswa['agama'] == 'Konghucu') echo 'selected'; ?>>Konghucu</option>
                    </select>
                   </div>
                   <div class="form-group">
                    <label for="foto">Foto</label>
                    <img src="../../assets/img/<?= $mahasiswa["foto"]; ?>" width="50px"><br>
                    <input type="file" class="form-control" name="foto" id="foto">
                  </div>


                  <div class="form-group">
                  <label for="nip">Dosen Wali</label>
                  <select name="nip" class="form-control" id="nip">
                     
                      <?php foreach ($dosen as $dosen_item): ?>
                          <option value="<?= $dosen_item["nip"]; ?>" <?= ($mahasiswa["nip"] == $dosen_item["nip"]) ? "selected" : ""; ?>>
                              <?= $dosen_item["nama_dosen"]; ?>
                          </option>
                      <?php endforeach; ?>
                  </select>


                 




                   </div>   

                  <div class="form-group">
                  <label for="prodi">Program Studi</label>
                    <select name="prodi" class="form-control" id="prodi">
                       
                        <?php foreach ($prodi as $prodi_item): ?>
                            <option value="<?= $prodi_item["id_jurusan"]; ?>" <?= ($mahasiswa["id_jurusan"] == $prodi_item["id_jurusan"]) ? "selected" : ""; ?>>
                                <?= $prodi_item["nama_jurusan"]; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                   </div>  
                <div class="box-footer">
                  <button type="submit" name="submit" value="tambah" class="btn btn-primary">Simpan</button>
                   <a href="index.php?page=mahasiswa" class="btn btn-danger">Batal</a>
                  </div>             
                </div>
              <!-- /.box-body -->            
             
            </form>
          </div>      
     </div>
    </section>



