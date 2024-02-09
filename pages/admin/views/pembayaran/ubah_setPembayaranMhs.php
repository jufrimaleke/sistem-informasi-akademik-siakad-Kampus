<?php 
include "../../config/fungsi.php";

$nim = $_GET['nim'];
$id_set = $_GET['id_set'];


$id_smt = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'");
  $data_idsmt = mysqli_fetch_assoc($id_smt);


 $mhs = mysqli_query($conn, "SELECT 
 				mahasiswa.nim, 
 				mahasiswa.nama, 
 				mahasiswa.id_jurusan, 
 				jurusan.id_jurusan, jurusan.nama_jurusan FROM mahasiswa INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan WHERE mahasiswa.nim = $nim");

$data_mhs = mysqli_fetch_assoc($mhs);

 
 $query_set = mysqli_query($conn, "SELECT * FROM set_pembayaran INNER JOIN jenis_pembayaran ON set_pembayaran.id_jenisPembayaran = jenis_pembayaran.id_jenisPembayaran 
 		INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran WHERE set_pembayaran.nim = $nim AND set_pembayaran.id_semester = '".$data_idsmt['id_semester']."'");

 $data_set = mysqli_fetch_assoc($query_set);


 ?>
<section class="content-header">
  <h1>
    SET TARIF PEMBAYARAN PER MAHASISWA
    
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="#"> pembayaran</a></li>
    <li class="active"> tarif pembayaran mahasiswa</li>
  </ol>    
</section>
<section class="content">
	<div class="row">
		<form action="views/pembayaran/proses_ubahSetPembayaranPerMhs.php" method="POST">
		<div class="col-md-6">
			<div class="box box-danger">
			<div class="box-body">
			<div class="form-group">
							<input type="hidden" name="id_set" value="<?php echo $data_set['id_set'] ?>">
							<input type="hidden" name="nim" value="<?php echo $nim ?>">
	            <input type="hidden" name="tahunAkademik" value="<?= $data_idsmt['id_semester'] ?>">
	            <label for="angkatan">Tahun Ajaran :</label>
	            <input type="text" class="form-control" value="<?= $data_idsmt['nama_semester'] ?>" disabled>
            </div>
            <div class="form-group">
			    <label for="jrs">Jurusan :</label>
			    <input type="text" name="jrs" value="<?= $data_mhs['nama_jurusan']  ?>" class="form-control" readonly>
			</div>
			<div class="form-group">
			    <label for="mhs">Mahasiswa :</label>
			    <input type="text" name="nama_mhs" value="<?= $data_mhs['nama'] ?>"class="form-control" readonly>
			</div>
		 <div class="form-group">
          <label for="id_jenisPembayaran">Jenis Pembayaran:</label>
          <select name="id_jenisPembayaran" class="form-control" id="id_jenisPembayaran" 
          onchange="jenisBayar()" required>
          
          	<option><?= $data_set['nama_pembayaran'] ?></option>
             <?php 
                $jenis_pembayaran1 = mysqli_query($conn, "SELECT * FROM jenis_pembayaran inner join nama_pembayaran on jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran");

              while($data = mysqli_fetch_assoc($jenis_pembayaran1)){
              ?>

                  <option value="<?php echo $data['id_jenisPembayaran'];  ?>"><?php echo $data['nama_pembayaran'] ?></option>

              <?php } ?>
      </select>
      </div>
				<p class="text-muted">*) Kolom wajib diisi.</p>
			</div>
		</div>			
			</div>
			<div class="col-md-6">
				<div class="box box-success">
					<div class="box-header">
						<h3 class="box-title">Tarif Tagihan Mahasiswa</h3>
					</div>
					<div class="box-body table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td><strong>Tipe</strong></td>
									<td><input type="text" class="form-control" name="tipe" readonly id="payment_tipe" value="<?= $data_set['payment_tipe'] ?>">
									</td>
								</tr>
								<tr>
									<td>
										<strong>Tarif (Rp.)</strong>
									</td>
									<td>
										<input type="text" name="jumlah_pembayaran" id="biayaInput" class="form-control" required oninput="formatBiaya()" onfocusout="formatBiaya()" value="<?= $data_set['payment'] ?>" readonly>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="box-footer">
				    <?php 
				    $query_mhs = mysqli_query($conn, "SELECT id_set, id_semester, jumlah_yangdibayar FROM set_pembayaran WHERE id_set = '$id_set' AND id_semester = '".$data_idsmt['id_semester']."'");
				    
				    $ret_mhs = mysqli_fetch_assoc($query_mhs);
				    
				    $jumlah_yangdibayar = str_replace(',','',$ret_mhs['jumlah_yangdibayar']);


				    if ($jumlah_yangdibayar == 0) { ?>
				        <button type="submit" name="ubah_setpembayaran" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
				        <a href="?page=pembayaran" class="btn btn-default"><i class="fa fa-repeat"></i> Cancel</a>
				    <?php } else { ?>
				        <button type="submit" disabled name="ubah_setpembayaran" class="btn btn-success"><i class="fa fa-save"></i> Sudah ada transaksi</button>
				        <a href="?page=pembayaran" class="btn btn-default"><i class="fa fa-repeat"></i> Cancel</a>
				    <?php } ?>
				</div>


			</div>			
		</div>
	</form>	
	</div>
	
</section>

<script>
    function jenisBayar() {
        var id = $("#id_jenisPembayaran").val();
        $.ajax({
            url: "views/pembayaran/dataId.php",
            method: "POST", // Ganti ke POST
            data: { id_jenisPembayaran: id },
            dataType: "json",
            success: function (data) {
                $('#biayaInput').val(data.payment);
                 $('#payment_tipe').val(data.payment_tipe);
            }
            
        })
    }
</script>

