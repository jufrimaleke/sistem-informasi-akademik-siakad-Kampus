<?php 
session_start(); 

if(!isset($_SESSION["operator"])){
  header("location: ../../index.php");
  exit;
}
?>
<!DOCTYPE html>

<html>
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
  <link rel="stylesheet" href="../../assets/bower_components/select2.min.css">
  <link rel="shortcut icon" type="text/css" href="../../assets/img/Logo.png">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="../../assets/css/skins/skin-blue.min.css">

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

  
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="../../assets/img/Logo.jpg" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"> <?php echo $_SESSION['nama']; ?> </span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="../../assets/img/Logo.png" class="img-circle" alt="User Image">

                <p>
                 Operator
                  <small></small>
                </p>
              </li>
              <!-- Menu Body -->
            
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
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
          <p> Admin</p>
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
         
          <li class="<?= isActive('jadwal') ?>"><a href="?page=jadwal"><i class="fa fa-calendar"></i> <span>Jadwal Kuliah</span></a></li>
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


      if ($page == "prodi") {
          if ($aksi == "") {
            include "views/prodi/prodi.php";
        } if ($aksi == "tambah") {
           include "views/prodi/tambah.php";
        } if ($aksi == "hapus") {
           include "views/prodi/hapus.php";
        } if ($aksi == "ubah") {
           include "views/prodi/ubah.php";
        }       
      }

      if ($page == "mk") {
        if ($aksi == "") {
          include "views/mk/mk.php";
        } if ($aksi == "tambah") {
          include "views/mk/tambah.php";
        } if ($aksi == "hapus") {
           include "views/mk/hapus.php";
        } if ($aksi == "ubah") {
           include "views/mk/ubah.php";
        } 
      }

      if ($page == "semester") {
        if ($aksi == "") {
          include "views/semester/semester.php";
        } if ($aksi == "tambah") {
          include "views/semester/tambah.php";
        } if ($aksi == "hapus") {
           include "views/semester/hapus.php";
        } if ($aksi == "status") {
           include "views/semester/status.php";
        }
      }        
      
      if ($page == "dosen") {
          if ($aksi == "") {
          include "views/dosen/dosen.php";
        } if ($aksi == "tambah") {
          include "views/dosen/tambah.php";
        } if ($aksi == "hapus") {
           include "views/dosen/hapus.php";
        } if ($aksi == "ubah") {
           include "views/dosen/ubah.php";
        } 
      }

      if ($page == "mahasiswa") {
        if ($aksi == "") {
          include "views/mahasiswa/mahasiswa.php";
        } if ($aksi == "tambah") {
          include "views/mahasiswa/tambah.php";
        } if ($aksi == "hapus") {
           include "views/mahasiswa/hapus.php";
        } if ($aksi == "ubah") {
           include "views/mahasiswa/ubah.php";
        }
      }
  

      if ($page == "jadwal") {
        if ($aksi == "") {
          include "views/jadwal/jadwal.php";
        } if ($aksi == "tambah") {
          include "views/jadwal/tambah.php";
        } if ($aksi == "hapus") {
           include "views/jadwal/hapus.php";
        } if ($aksi == "ubah") {
           include "views/jadwal/ubah.php";
        } 
      }

      if ($page == "krs") {
        if ($aksi == "") {
          include "views/krs/list_krs.php";
        } elseif ($aksi == "tambah"){
          include 'views/krs/tambah_krs.php';
        } elseif ($aksi == "lihat_krs") {
          include "views/krs/krs.php";
        } elseif ($aksi == "hapus") {
          include "views/krs/hapus_krs.php";
        }

      }   
      if ($page == "kelas") {
      if ($aksi == "") {
        include "views/kelas/kelas.php";
        } elseif ($aksi == "tambah"){
          include "views/kelas/tambah.php";
        }
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
       if ($page == "transkrip") {
        if ($aksi == "") {
          include "views/transkrip/list_transkrip_mhs.php";
        } elseif ($aksi == "lihat_transkrip") {
          include "views/transkrip/list_transkrip.php";
        }
      }   

       if ($page == "admin") {
          if ($aksi == "") {
          include "views/admin/admin.php";
        } if ($aksi == "tambah") {
          include "views/admin/tambah.php";
        } if ($aksi == "hapus") {
           include "views/admin/hapus.php";
        } if ($aksi == "ubah") {
           include "views/admin/ubah.php";
        }
      } 

      if ($page == "maba") {
        if ($aksi == "") {
          include "views/maba/daftar_maba.php";
        } if ($aksi == "tambah") {
          include "views/maba/tambah_maba.php";
        } if ($aksi == "hapus") {
          include "views/maba/hapus_maba.php";
        }
      }
          
      
?>
  </div>


 

  
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
      'autoWidth'   : false
    })
  })
</script>

 <!-- <script>
      $(document).ready(function() {
        $('#prodi').change(function() {
          var provinsi_id = $(this).val();

          $.ajax({
            type: 'POST',
            url: 'views/krs/nim.php',
            data: 'prov_id='+provinsi_id,
            success: function(response) {
              $('#nim').html(response);
            }
          });
        })
      });
    </script>

    <script>
      $(document).ready(function() {
        $('#nim').change(function() {
          var nama = $(this).val();

          $.ajax({
            type: 'POST',
            url: 'views/krs/nama.php',
            data: 'nim='+nama,
            success: function(response) {
              $('#nama').html(response);
            }
          });
        })
      });
    </script> -->
</html>