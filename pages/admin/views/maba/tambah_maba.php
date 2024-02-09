<?php
include "../../config/fungsi.php";
if (isset($_POST['kirim'])) {
    $no_pendaftaran         = htmlspecialchars($_POST['no_pendaftaran']);
    $namapendaftar          = htmlspecialchars($_POST['nama_pendaftar']);
    $tempatlahir            = htmlspecialchars($_POST['tempat_lahir']);
    $tanggallahir           = $_POST['tahun']."-".$_POST['bulan']."-".$_POST['tanggal'];
    $jenis_kelamin          = $_POST['jk'];
    $agama                  = $_POST['agama'];
    $sekolah_asal           = htmlspecialchars($_POST['sekolah_asal']);
    $nis                    = htmlspecialchars($_POST['nis']);
    $nope                   = htmlspecialchars($_POST['nope']);
    $no_kel                 = htmlspecialchars($_POST['no_kel']);
    $programstudi           = $_POST['program_studi'];
    $berkas                 = $_POST['berkas'];


  

    $input_maba = mysqli_query($conn, "INSERT INTO maba (no_pendaftaran,nama,tempat_lahir,tgl_lahir,jenis_kelamin,agama,sekolah_asal,nis,nomor_hp,nomor_keluarga,id_jurusan,berkas) VALUES('$no_pendaftaran','$namapendaftar','$tempatlahir','$tanggallahir','$jenis_kelamin','$agama','$sekolah_asal','$nis','$nope','$no_kel','$programstudi','$berkas')");
    if ($input_maba){
       echo "<script>alert('Berhasil Menyimpan')</script>";
    } else {
        echo "Gagal Untuk Menginput".mysqli_error();
    }
}
?>
        <div class="content">
            <div class="callout">
                <div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default bootstrap-admin-no-table-panel">
                                <div class="panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">Input Data Pendaftar</div>
                                </div>
                                   

                                <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                        <fieldset><br>
                                           <?php
                                            function generate_registration_number($length) {
                                                // Daftar karakter yang akan digunakan untuk nomor pendaftaran
                                                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

                                                // Mengacak karakter untuk membuat nomor pendaftaran
                                                $registration_number = '';
                                                for ($i = 0; $i < $length; $i++) {
                                                    $registration_number .= $characters[rand(0, strlen($characters) - 1)];
                                                }

                                                return $registration_number;
                                            }

                                            // Contoh penggunaan dengan panjang nomor pendaftaran 8
                                            $nomor_pendaftaran = generate_registration_number(6);
                                         
                                            ?>


                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="disabledInput">No. Pendaftaran</label>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control" value="<?php echo $nomor_pendaftaran; ?>" required name="no_pendaftaran" readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="typeahead">Nama </label>
                                                <div class="col-lg-6">
                                                    <input type="text" required class="form-control col-md-6" id="typeahead" name="nama_pendaftar">
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="typeahead">Tempat Lahir </label>
                                                <div class="col-lg-6">
                                                    <input type="text" required class="form-control col-md-6" id="typeahead" name="tempat_lahir">
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="date01">Tanggal Lahir</label>
                                                <div class="col-lg-1">
                                                    <input type="text" required class="form-control col-md-6" id="date01" name="tanggal" placeholder="00" >
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="form-control col-lg-4" name="bulan">
                                                        <option></option>
                                                        <option value="01">Januari</option>
                                                        <option value="02">Februari</option>
                                                        <option value="03">Maret</option>
                                                        <option value="04">April</option>
                                                        <option value="05">Mei</option>
                                                        <option value="06">Juni</option>
                                                        <option value="07">Juli</option>
                                                        <option value="08">Agustus</option>
                                                        <option value="09">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" required style="text-align: center" class="form-control col-lg-3" id="typeahead" name="tahun" placeholder="0000">
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="select02">Jenis Kelamin</label>
                                                <div class="col-lg-2">
                                                    <select id="select02" required name="jk" class="form-control" >
                                                        <option></option>
                                                       <option value="L">L</option>
                                                        <option value="P">P</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="select02">Agama</label>
                                                <div class="col-lg-2">
                                                    <select id="select02" required name="agama" class="form-control" >
                                                    	<option></option>
                                                        <option value="ISLAM">Islam</option> 
                                                        <option value="KRISTEN">Kristen</option> 
                                                        <option value="KATHOLIK">Katholik</option> 
                                                        <option value="HINDU">Hindu</option> 
                                                        <option value="BUDHA">Budha</option>  
                                                        <option value="KONGHUCU">Konghucu</option> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="typeahead">Sekolah Asal</label>
                                                <div class="col-lg-6">
                                                    <input type="text" required class="form-control col-md-6" id="typeahead" name="sekolah_asal"> 
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="typeahead">Nis</label>
                                                <div class="col-lg-6">
                                                    <input type="text" required class="form-control col-md-6" id="typeahead" name="nis" required> 
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="typeahead">Nomor HP</label>
                                                <div class="col-lg-6">
                                                    <input type="text" required class="form-control col-md-6" id="typeahead" name="nope">
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="typeahead">Nomor Keluarga</label>
                                                <div class="col-lg-6">
                                                    <input type="text" required class="form-control col-md-6" id="typeahead" name="no_kel">
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="form-group">
                                                <?php 
                                                $prodi = mysqli_query($conn, "SELECT * FROM jurusan");
                                                ?>
                                                <label class="col-lg-2 control-label" for="select02">Program Studi</label>
                                                <div class="col-lg-3">
                                                    <select id="select02" required name="program_studi" class="form-control " required="" >
                                                       <option value="">- Pilih -</option> 
                                                    <?php foreach ($prodi as $row): ?>
                                                      <?php echo '<option name="prodi" value="'.$row["id_jurusan"].'">'.$row["nama_jurusan"].'</option>'; ?>
                                                    <?php endforeach; ?>                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                                <div class="form-group">
                                                <label class="col-lg-2 control-label" for="typeahead">Berkas</label>
                                               <div class="col-lg-6">
                                                <input type="text" required class="form-control col-md-6" id="typeahead" name="berkas">
                                            </div>
                                            </div>
                                           
                                             
                                        </div>
                                        </div>
                                            <div class="col-lg-8"></div>
                                            <button type="submit" class="btn btn-primary" name="kirim">Kirim</button>
                                             <a href="index.php?page=maba" class="btn btn-danger">Batal</a><br><br><br>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
         <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/twitter-bootstrap-hover-dropdown.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap-admin-theme-change-size.js"></script>
        <script type="text/javascript" src="../vendors/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="../vendors/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="../vendors/selectize/dist/js/standalone/selectize.min.js"></script>
        <script type="text/javascript" src="../vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../vendors/bootstrap-wysihtml5-rails-b3/vendor/assets/javascripts/bootstrap-wysihtml5/wysihtml5.js"></script>
        <script type="text/javascript" src="../vendors/bootstrap-wysihtml5-rails-b3/vendor/assets/javascripts/bootstrap-wysihtml5/core-b3.js"></script>
        <script type="text/javascript" src="../vendors/twitter-bootstrap-wizard/jquery.bootstrap.wizard-for.bootstrap3.js"></script>
        <script type="text/javascript" src="../vendors/boostrap3-typeahead/bootstrap3-typeahead.min.js"></script>
       
