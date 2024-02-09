<?php 
include "../../config/fungsi.php";

  $angkatan = mysqli_query($conn, "SELECT id_angkatan FROM angkatan");
  $jurusan = mysqli_query($conn, "SELECT id_jurusan,kode_jurusan,nama_jurusan FROM jurusan");
  $id_smt = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'");
  $data_idsmt = mysqli_fetch_assoc($id_smt);


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
		<form action="views/pembayaran/proses_setPembayaranPerMhs.php" method="POST">
		<div class="col-md-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-group">
                <input type="hidden" name="tahunAkademik" value="<?= $data_idsmt['id_semester'] ?>">
                <label for="angkatan">Tahun Ajaran :</label>
                <input type="text" class="form-control" value="<?= $data_idsmt['nama_semester'] ?>" readonly>
            </div>
            <div class="form-group">
			    <label for="jrs">Jurusan :</label>
			    <select name="jrs" required class="form-control" id="jrs" onchange="jurusan()">
			        <option value="">-- Pilih -- </option>
			        <?php foreach ($jurusan as $row): ?>
			            <option value="<?= $row["id_jurusan"]; ?>"><?= $row["nama_jurusan"]; ?></option>
			        <?php endforeach; ?>
			    </select>
			</div>
			<div class="form-group">
			    <label for="mhs">Mahasiswa :</label>
			    <select name="nim_mhs" class="form-control" id="mhs">
			        <option>--Pilih--</option>
			    </select>
			</div>
		 <div class="form-group">
          <label for="id_jenisPembayaran">Jenis Pembayaran:</label>
          <select name="id_jenisPembayaran" class="form-control" id="id_jenisPembayaran" 
          onchange="jenisBayar()" required>
          
          	<option>-Pilih-</option>
             <?php 
                $jenis_pembayaran1 = mysqli_query($conn, "SELECT * FROM jenis_pembayaran inner join nama_pembayaran on jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran");

              while($data = mysqli_fetch_assoc($jenis_pembayaran1)){
              ?>

                  <option value="<?php echo $data['id_jenisPembayaran'];  ?>"><?php echo $data['nama_pembayaran'] ?>||<?php echo $data{'id_jenisPembayaran'};  ?></option>

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
									<td><input type="text" class="form-control" id="payment_tipe" name="tipe" readonly>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Tarif (Rp.)</strong>
									</td>
									<td>
										<input type="text" name="jumlah_pembayaran" id="biayaInput" readonly class="form-control" required oninput="formatBiaya()" onfocusout="formatBiaya()">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="box-footer">
						<button type="submit" name="tambah_setPembayaranPerMhs" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
						<a href="?page=pembayaran" class="btn btn-default"><i class="fa fa-repeat"></i> Cancel</a>
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


	    function jurusan() {
	        var id = $("#jrs").val();
	        $.ajax({
	            url: "views/pembayaran/data_mhs.php",
	            method: "POST",
	            data: { jrs: id },
	            dataType: "json",
	            success: function(datajrs) {
	                // Bersihkan opsi sebelum menambahkan yang baru
	                $('#mhs').empty();
	                
	                // Tambahkan opsi baru berdasarkan data yang diterima
	                $.each(datajrs, function(index, mhs) {
	                    $('#mhs').append('<option value="' + mhs.nim + '">' + mhs.nim + ' || ' + mhs.nama + '</option>');
	                });
	            },
	            error: function(xhr, status, error) {
	                console.error(xhr.responseText);
	            }
	        });
	    }
	
</script>

