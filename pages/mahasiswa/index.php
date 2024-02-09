<?php 
session_start(); 
include "../../config/fungsi.php";
if(!isset($_SESSION["mahasiswa"])){
  header("location: ../../index.php");
  exit;
}

$nim = $_SESSION['mahasiswa'];

$mahasiswa = query("SELECT * FROM mahasiswa WHERE nim = $nim");

?>
<!DOCTYPE html>

<html>
<title>Portal Akademik</title>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Starter</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/css/AdminLTE.min.css">
   <!-- DataTables -->
  <link rel="stylesheet" href="../../assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="../../assets/css/skins/skin-blue.min.css">
  <link rel="shortcut icon" type="text/css" href="../../assets/img/Logo.png">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>IA</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SIA</b>KAD</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
         
          <!-- /.messages-menu -->

          <!-- Notifications Menu -->
         
          <!-- Tasks Menu -->
       
           
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <?php foreach ($mahasiswa as $row) :  ?>
              <img src="../../assets/img/<?= $row["foto"]; ?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?= $row["nama"]; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                                         
                <img src="../../assets/img/<?= $row["foto"]; ?>" alt="User Image">
              
                <p>
                 <?= $row["nama"]; ?> <br>
                 <?= $row["nim"]; ?>
                </p>
                 <?php endforeach; ?>
              </li>
              <!-- Menu Body -->
            
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="?page=profil" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="../../config/logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../../assets/img/Logo.png" alt="User Image">
        </div>
        <div class="pull-left info">
          <p> Mahasiswa</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <?php
      $activePage = isset($_GET['page']) ? $_GET['page'] : '';

      function isActive($page)
      {
          global $activePage;
          return ($activePage === $page) ? 'active' : '';
      }
      ?>

      <ul class="sidebar-menu" data-widget="tree">
          <li class="header">HEADER</li>
          <li class="<?= isActive('dashboard') ?>"><a href="?page=dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class="<?= isActive('krs') ?>"><a href="?page=krs"><i class="fa fa-file-pdf-o"></i> <span>Kartu Rencana Studi</span></a></li>
          <li class="<?= isActive('khs') ?>"><a href="?page=khs"><i class="fa fa-file"></i> <span>Kartu Hasil Studi</span></a></li>
          <li class="<?= isActive('transkrip') ?>"><a href="?page=transkrip"><i class="fa fa-file"></i> <span>Transkip Nilai</span></a></li>
          <li class="<?= isActive('materi') ?>"><a href="?page=materi"><i class="fa fa-book"></i> <span>Materi Kuliah</span></a></li>
           <li class="<?= isActive('pass') ?>"><a href="?page=pass"><i class="fa fa-book"></i> <span>Ubah Password</span></a></li>
           <li class="<?= isActive('kuesioner') ?>"><a href="?page=kuesioner"><i class="fa fa-book"></i> <span>Kuesioner</span></a></li>
           <li class="treeview <?= isActive('set_keuangan') ?> <?= isActive('pembayaran') ?> <?= isActive('jenis_pembayaran') ?><?= isActive('hasil_sur') ?>">
            <a href="#">
              <i class="fa fa-money"></i>
                <span>Keuangan</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              
              <li class="<?= isActive('pembayaran') ?>"><a href="?page=pembayaran"><i class="fa fa-calendar"></i> <span> Pembayaran</span></a></li>
             
              <!-- <li class="<?= isActive('hasil_sur') ?>"><a href="?page=hasil_sur"><i class="fa fa-calendar-check-o"></i> <span>Laporan Keuangan</span></a></li> -->

            </ul>
          </li>
      </ul>

      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <?php 

     @$page  = $_GET['page'];
     @$aksi  = $_GET['aksi'];

     if ($page == "dashboard" || $page == "") {          
        include "../dashboard.php";
      } 

      if ($page == "krs") {
        if ($aksi == "") {
          include "views/krs/krs.php";
        } elseif ($aksi == "tambah"){
          include 'views/krs/tambah_krs.php';
        } elseif ($aksi == "hapus") {
          include "views/krs/hapus_krs.php";
        }
      }

       if ($page == "materi") {
        if ($aksi == "") {
          include "views/materi/materi.php";
        } elseif ($aksi == "tambah") {
          include "views/materi/tambah.php";
        }
      }     

      if ($page == "khs") {
        if ($aksi == "") {
          include "views/khs/khs.php";
        } 
      }

      if ($page == "transkrip") {
        if ($aksi == "") {
          include "views/transkrip/transkrip.php";
        } 
      }

      if ($page == "pembayaran") {
        if ($aksi == "") {
          include "views/pembayaran/pembayaran.php";  
        } if ($aksi == "inputPembayaranMhs") {
          include "views/pembayaran/inputPembayaran.php";
        } if ($aksi == "batal_transaksi") {
          include "views/pembayaran/batal_transaksi.php";
        } if ($aksi == "inputPembayaran") {
          include "views/pembayaran/inputPembayaran.php";
        } if ($aksi == "batal_transaksi") {
          include "views/pembayaran/batal_transaksi.php";
        }
      }

      if ($page == "profil") {
        include "views/profil/profil.php";
      }
      if ($page == "pass") {
        include "views/profil/ubah_pass.php";
      }
      if ($page == "kuesioner") {
        include "views/kuesioner/kuesioner.php";
      }
      

     ?>
    
  </div>


  <!-- Main Footer -->
  <footer class="main-footer">  
    <strong>Copyright &copy; 2023 <a href="#">STIE-SULUT</a>.</strong> All rights reserved.
  </footer>

  
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../../assets/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="../../assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../assets/bower_components/fastclick/lib/fastclick.js"></script>
<script src="../../assets/js/demo.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../assets/bower_components/ckeditor/ckeditor.js"></script>

<!-- page script -->
 <script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'lengthMenu'  : [5,10,25],
     
    })
  })
function formatBiaya() {
    // Ambil nilai input biaya
    let biayaInput = document.getElementById('biayaInput');

    // Hapus karakter selain angka dan titik desimal
    let cleanValue = biayaInput.value.replace(/[^\d.]/g, '');

    // Pisahkan nilai menjadi bagian sebelum dan setelah titik desimal
    let parts = cleanValue.split('.');

    // Format bagian pertama sebagai angka dengan separator ribuan
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    // Gabungkan kembali bagian-bagian
    let formattedValue = parts.join('.');

    // Setel kembali nilai input
    biayaInput.value = formattedValue;

    // Nilai biaya yang akan disimpan di database
    let nilaiBiaya = parseFloat(cleanValue);

    // Selanjutnya, Anda dapat mengirim nilaiBiaya ke server atau memproses sesuai kebutuhan.
}
</script>
<script>
    $(function() {
     
      CKEDITOR.replace('editor')
    })
    $(function() {
    
      CKEDITOR.replace('editor1')
    })
  </script>
</html>