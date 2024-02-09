<?php 
session_start(); 
include "../../config/fungsi.php";
if(!isset($_SESSION["dosen"])){
  header("location: ../../index.php");
  exit;
}

$nip = $_SESSION['nip'];

$dosen = mysqli_query($conn,"SELECT * FROM dosen WHERE nip = '$nip'");


?>
<!DOCTYPE html>

<html>
<title>Portal Akademik</title>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIAKAD</title>
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
  <link rel="shortcut icon" type="text/css" href="../../assets/img/Logo2.png">
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
               <?php foreach ($dosen as $row) :  ?>
              <img src="../../../assets/img/<?= $row["foto"]; ?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?= $row["nama_dosen"]; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="../../assets/img/<?= $row["foto"]; ?>"  alt="User Image">
               
                <p>
                 <?= $row["nama_dosen"]; ?>                 
                 <?= $row["nip"]; ?>
                </p>
                 <?php endforeach; ?>
              </li>
              <!-- Menu Body -->
            
              <!-- Menu Footer-->
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
           <img src="../../assets/img/logo3.jpg" alt="User Image" style="border-radius: 10px;" >
        </div>
        <div class="pull-left info">
          <p> Dosen</p>
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
          <li class="<?= isActive('khs') ?>"><a href="?page=khs"><i class="fa fa-pencil"></i> <span>Nilai Mahasiswa</span></a></li>
          <li class="<?= isActive('materi') ?>"><a href="?page=materi"><i class="fa fa-book"></i> <span>Materi Kuliah</span></a>
          </li>
           <li class="<?= isActive('approve') ?>"><a href="?page=approve"><i class="fa fa-user"></i> <span>Aprove KRS Mahasiswa</span></a></li>
           <li class="<?= isActive('histori') ?>"><a href="?page=histori"><i class="fa fa-user"></i> <span>Histori Pengajaran</span></a></li>
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


      if ($page == "khs") {
        if ($aksi == "") {
          include "views/khs/hasil-studi.php";
        } elseif ($aksi == "input") {
          include "views/khs/kelas-peserta.php";
        } elseif ($aksi == "import") {
          include "views/khs/form.php";
        } elseif ($aksi == "inputNilai") {
          include "views/khs/input.php";
        }
      }  

       if ($page == "krs") {
        if ($aksi == "") {
          include "views/krs/list_krs.php";
        } elseif ($aksi == "lihat_krs") {
          include "views/krs/krs.php";
        }

      }  
      

      if ($page == "materi") {
        if ($aksi == "") {
          include "views/materi/materi.php";
        } elseif ($aksi == "tambah") {
          include "views/materi/tambah.php";
        } elseif ($aksi == "hapus") {
          include "views/materi/hapus.php";
        }
      }      

      if ($page == "profil") {
        include "views/profil/profil.php";
      }
       if ($page == "approve") {
          if ($aksi == "") {
            include "views/approve/approve.php";
          }
      }  
      if ($page == "histori") {
          if ($aksi == "") {
            include "views/histori/histori.php";
          }
      }      
?>
   
  </div>
  <!-- Main Footer -->
  <footer class="main-footer">  
    <strong>Copyright &copy; 2023 <a href="#">Company</a>.</strong> All rights reserved.
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
</script>
</html>
