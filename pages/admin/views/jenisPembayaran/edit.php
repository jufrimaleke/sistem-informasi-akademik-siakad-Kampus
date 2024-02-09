<?php 
require "../../config/fungsi.php";

$id = $_GET["id"];

$query_jenisPembayaran = mysqli_query($conn,"SELECT * FROM jenis_pembayaran 
	INNER JOIN semester ON jenis_pembayaran.id_semester = semester.id_semester
	INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran WHERE id_jenisPembayaran = $id");


$data = mysqli_fetch_assoc($query_jenisPembayaran);


$query_namaPembayaran = mysqli_query($conn, "SELECT * FROM nama_pembayaran");

?>



<section class="content-header">
  <h1>
    Dashboard
     <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
      <li class="active"> Ubah Jenis Pembayaran</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Jenis Pembayaran</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
                 <div class="form-group">
                  <label for="id_mk">ID Jenis Pembayaran</label>
                  <input type="text" class="form-control" name="id_jenisPembayaran" readonly="on" value="<?= $data["id_jenisPembayaran"]; ?>">
                </div>
                 <div class="form-group">
                  <label for="nama">Nama Semester</label>
                  <input type="text" class="form-control" readonly="true" name="smt" autocomplete="off" value="<?= $data['id_semester'] ?>">
                </div>
                <div class="form-group">
                  <label for="nama_pembayaran">Nama Pembayaran</label>
                  <select class="form-control" name="nama_pembayaran" id="nama_pembayaran">
                  	<option value="<?= $data["id_pembayaran"]; ?>"><?= $data["nama_pembayaran"]; ?></option>
                  	<?php foreach ($query_namaPembayaran as $d ) : ?>
                  	<option value="<?= $d['id_pembayaran'] ?>"><?= $d['nama_pembayaran'] ?></option>
                  <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                    <label for="payment_tipe">Payment Tipe</label>
                    <select class="form-control" name="payment_tipe">
                    	<option value="<?= $data['payment_tipe'] ?>"><?= $data['payment_tipe'] ?></option>
                    	<option value="BULAN">BULAN</option>
                    	<option value="SEMESTER">SEMESTER</option>
                    </select>
                </div>
               
                <div class="form-group">
                    <label for="biaya">Biaya</label>
                    <input type="text" name="biaya" id="biayaInput" value="<?= number_format($data['payment']) ?>" class="form-control" required oninput="formatBiaya()" onfocusout="formatBiaya()">
                </div>
               
             	<div class="form-group">
                    <label for="deadline">Pilih Waktu Deadline:</label>
                    <input type="datetime-local" id="deadline" class="form-control" name="deadline" value="<?= $data['deadline_time'] ?>" required>
                </div>
              <div class="modal-footer">
                    
                    <button type="reset" name="reset" class="btn btn-warning">Batal</button>
                    <button type="submit" name="edit_jenis" class="btn btn-success">Edit</button>
                </div>
            </form>
          </div>
        </div>           
       </div>
    </section>


  <?php

  if (isset($_POST['edit_jenis'])) {
  	$id_jenis 				= $_POST['id_jenisPembayaran'];
  	$smt 					= $_POST['smt'];
  	$nama_pembayaran 		= $_POST['nama_pembayaran'];
  	$payment_tipe 			= $_POST['payment_tipe'];
  	$biaya 					= $_POST['biaya'];
  	$deadline_time 			= $_POST['deadline'];

  	$jumlah_pembayaran = str_replace(',', '', $biaya);

  	$query_update = mysqli_query($conn, "UPDATE jenis_pembayaran SET

  					id_jenisPembayaran = '$id_jenis',
  					id_pembayaran 	   = '$nama_pembayaran',
  					id_semester        = '$smt',
  					deadline_time	   = '$deadline_time',
  					payment_tipe	   = '$payment_tipe',
  					payment            = '$jumlah_pembayaran'
  					WHERE id_jenisPembayaran = $id_jenis");

  	if ($query_update) {
  		echo "<script>
        		alert('Ubah Jenis pembayaran berhasil');
        		window.history.back();
        		</script>";
  	}else{
  		echo "gagal" . mysqli_error($conn);;
  	}

  }











   ?>