<?php 
require "../../config/fungsi.php";


//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

  //cek apakah    data berhasil ditambahkan atau tidak
  if(tambah_mk($_POST) > 0 ){
    echo "
      <script>
        alert('data berhasil ditambahkan:');
        document.location.href = '?page=mk';
      </script>
    ";
  } else {
    echo ("error ". mysqli_error($conn));
    echo "
      <script>
        alert('data gagal ditambahkan:');
        document.location.href = '?page=mk';
      </script>
    ";
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
      <li class="active"> Tambah Mata Kuliah</li>
  </ol> 
</section>

 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Mata Kuliah</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="">
              <div class="box-body">
                <div class="form-group">
                  <label for="kode">ID Semester</label>
                  <input type="text" class="form-control" name="kode" id="kode" autocomplete="off" placeholder="Cth: 20201">
                </div>
                <div class="form-group">
                  <label for="nama">Nama Semester</label>
                  <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" placeholder="Cth: 2021/2022 Ganjil">
                </div>
                <div class="form-group">
                  <div class="radio">
                    <label for="">STATUS</label>
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                      Option one is this and that—be sure to include why it's great
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                      Option two can be something else and selecting it will deselect option one
                    </label>
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="submit" value="tambah" class="btn btn-primary">Simpan</button>
               
              </div>
            </form>
          </div>
        </div>           
       </div>
    </section>