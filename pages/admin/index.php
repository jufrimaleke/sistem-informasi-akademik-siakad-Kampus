<?php 
date_default_timezone_set('Asia/Singapore');
session_start(); 

if(!isset($_SESSION["admin"])){
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
  <link rel="shortcut icon" type="text/css" href="../../assets/img/Logo2.png">
  <link rel="stylesheet" href="../../assets/css/skins/skin-blue.min.css">


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
              <img src="../../assets/img/logo3.jpg" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"> <?php echo $_SESSION['nama']; ?> </span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="../../assets/img/logo3.jpg" class="img-circle" alt="User Image">

                <p>
                 Admin
                  <small></small>
                </p>
              </li>
              <!-- Menu Body -->
            
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="?page=ubah" class="btn btn-default btn-flat">Profile</a>
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
          <li class="header">Main Menu</li>
          
          <li class="<?= isActive('dashboard') ?>"><a href="?page=dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

          <li class="<?= isActive('prodi') ?>"><a href="?page=prodi"><i class="fa fa-mortar-board"></i> <span>Program Studi</span></a></li>
          <li class="<?= isActive('dosen') ?>"><a href="?page=dosen"><i class="fa fa-user"></i> <span>Dosen</span></a></li>
          



          <li class="treeview <?= isActive('mahasiswa') ?> <?= isActive('transkrip') ?> <?= isActive('khs') ?> <?= isActive('krs') ?> <?= isActive('ubahpass') ?> <?= isActive('khs_mhs') ?>">
              <a href="#">
                  <i class="fa fa-laptop"></i>
                  <span>Mahasiswa</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?= isActive('mahasiswa') ?>"><a href="?page=mahasiswa"><i class="fa fa-users"></i> <span>Mahasiswa</span></a></li>
                 
                   <li class="<?= isActive('transkrip') ?>"><a href="?page=transkrip"><i class="fa fa-list"></i> <span>Transkrip Nilai</span></a></li>
                   <li class="<?= isActive('khs') ?>"><a href="?page=khs"><i class="fa fa-pencil"></i> <span>Input Nilai</span></a></li>
                    <li class="<?= isActive('krs') ?>"><a href="?page=krs"><i class="fa fa-file-pdf-o"></i> <span>Rencana Studi</span></a></li>
                    <li class="<?= isActive('khs_mhs') ?>"><a href="?page=khs_mhs"><i class="fa fa-file-pdf-o"></i> <span>Kartu Hasil Studi</span></a></li>
                    <li class="<?= isActive('ubahpass') ?>"><a href="?page=ubahpass"><i class="fa fa-book"></i> <span>Ubah Password</span></a></li>
                     
              </ul>
          </li>
          <li class="treeview <?= isActive('mk') ?> <?= isActive('jadwal') ?> <?= isActive('kelas') ?>">
              <a href="#">
                  <i class="fa fa-laptop"></i>
                  <span>Perkuliahan</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?= isActive('mk') ?>"><a href="?page=mk"><i class="fa fa-book"></i> <span>Mata Kuliah</span></a></li>
                  <li class="<?= isActive('jadwal') ?>"><a href="?page=jadwal"><i class="fa fa-calendar"></i> <span>Jadwal Kuliah</span></a></li>
                  <li class="<?= isActive('kelas') ?>"><a href="?page=kelas"><i class="fa fa-calendar-check-o"></i> <span>Kelas</span></a></li>
              </ul>
          </li>
          <li class="treeview <?= isActive('set_keuangan') ?> <?= isActive('pembayaran') ?> <?= isActive('jenis_pembayaran') ?><?= isActive('laporan_keu') ?>">
            <a href="#">
              <i class="fa fa-money"></i>
                <span>Keuangan</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              <li class="<?= isActive('set_keuangan') ?>"><a href="?page=set_keuangan"><i class="fa fa-book"></i> <span>Jenis Pembayaran</span></a></li> 

              <li class="<?= isActive('jenis_pembayaran') ?>"><a href="?page=jenis_pembayaran"><i class="fa fa-book"></i> <span>Set Pembayaran</span></a></li>  

              <li class="<?= isActive('pembayaran') ?>"><a href="?page=pembayaran"><i class="fa fa-calendar"></i> <span> Pembayaran</span></a></li>
             
              <li class="<?= isActive('laporan_keu') ?>"><a href="?page=laporan_keu"><i class="fa fa-calendar-check-o"></i> <span>Laporan Keuangan</span></a></li>

            </ul>
          </li>
            <li class="treeview <?= isActive('pengumuman') ?>">
              <a href="#">
                  <i class="fa fa-list"></i>
                  <span>Pengumuman</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?= isActive('pengumuman') ?>"><a href="?page=pengumuman"><i class="fa fa-book"></i> <span>Pengumuman</span></a></li>
              </ul>
          </li>
         
    
          <li class="<?= isActive('semester') ?>"><a href="?page=semester"><i class="fa fa-calendar-check-o"></i> <span>Semester Perkuliahan</span></a></li>
         
          <li class="treeview <?= isActive('konfigurasi') ?> <?= isActive('daftar_mahasiswa_lulus') ?> <?= isActive('daftar_mahasiswa_mendaftar') ?>">
              <a href="#">
                  <i class="fa fa-laptop"></i>
                  <span>Manajemen Maba</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                  <li><a href="?page=konfigurasi" class="<?= isActive('konfigurasi') ?>"><i class="fa fa-gear"></i> Konfigurasi</a></li>
                  <li><a href="#" class="<?= isActive('daftar_mahasiswa_lulus') ?>"><i class="fa fa-list"></i> Daftar Mahasiswa Lulus</a></li>
                  <li><a href="?page=maba" class="<?= isActive('daftar_mahasiswa_mendaftar') ?>"><i class="fa fa-list"></i> Daftar Mahasiswa Mendaftar</a></li>
              </ul>
          </li>

          <li class="treeview <?= isActive('laporan') ?> <?= isActive('lap_krs') ?>">
              <a href="#">
                  <i class="fa fa-laptop"></i>
                  <span>Laporan</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                  <li>
                    <a href="?page=laporan&aksi=lap_krs" class="<?= isActive('konfigurasi') ?>"><i class="fa fa-check"></i> Laporan KRS Mahasiswa</a>
                  </li>
  
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
      if ($page == "approve") {
          if ($aksi == "") {
            include "views/approve/approve.php";
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
        } if ($aksi == "status_kuesioner") {
          include "views/semester/status_kuesioner.php";
        } if ($aksi == "deadline") {
          include "views/semester/date.php";
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

      
        if ($page == "ubahpass") {
          if ($aksi == "") {
            include "views/mahasiswa/listubah.php";
          } if ($aksi == "passmhs") {
            include "views/mahasiswa/ubah_pass.php";
          }
        }

        if ($page == "hasil_sur") {
          if ($aksi == "") {
            include "views/hasil_kue/hasil_kue.php";
          }
        }
        if ($page == "pengumuman") {
          if ($aksi == "") {
            include "views/pengumuman/pengumuman.php";
          } if ($aksi == "aktifkan") {
            include "views/pengumuman/status_diaktifkan.php";
          } if ($aksi == "nonaktifkan") {
            include "views/pengumuman/status_dinonaktifkan.php";
          } if ($aksi == "hapus_pengumuman") {
            include "views/pengumuman/hapus_pengumuman.php";
          } if ($aksi == "ubah_pengumuman") {
            include "views/pengumuman/ubah_pengumuman.php";
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
        } elseif ($aksi == "ubah"){
          include "views/kelas/ubah.php";
        } elseif ($aksi == "hapus"){
          include "views/kelas/hapus.php";
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
       if ($page == "khs_mhs") {
        if ($aksi == "") {
          include "views/khs_mhs/list_khs_mhs.php";
        } elseif ($aksi == "lihat_khs_mhs") {
          include "views/khs_mhs/khs_mhs.php";
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

      if ($page =="ubah") {
         include "views/admin/ubah.php";
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

      if ($page == "set_keuangan") {
        if ($aksi == "") {
          include "views/setKeuangan/setKeuangan.php";  
        } if ($aksi == "tambah") {
          include "views/pertanyaantptk/tambah.php";
        }if ($aksi == "hapus") {
          include "views/pertanyaantptk/hapus.php";
        }
      }

      if ($page == "jenis_pembayaran") {
        if ($aksi == "") {
          include "views/jenisPembayaran/jenis_pembayaran.php";
        }if ($aksi =="hapus") {
          include "views/jenisPembayaran/hapus.php";
        }if ($aksi =="edit") {
          include "views/jenisPembayaran/edit.php";
        }
      }

      
      if ($page == "pembayaran") {
        if ($aksi == "") {
          include "views/pembayaran/pembayaran.php";  
        } if ($aksi == "inputPembayaran") {
          include "views/pembayaran/inputPembayaran.php";
        } if ($aksi == "set_pembayaranPerAngkatan") {
          include "views/pembayaran/set_pembayaranPerAngkatan.php";
        } if ($aksi == "set_pembayaranPerMahasiswa") {
          include "views/pembayaran/set_pembayaranPerMahasiswa.php";
        } if ($aksi == "ubah_setPembayaranMhs") {
          include "views/pembayaran/ubah_setPembayaranMhs.php";
        } if ($aksi == "hapus_setPembayaran") {
          include "views/pembayaran/hapus_set.php";
        } if ($aksi == "inputPembayaranMhs") {
          include "views/pembayaran/inputPembayaran.php";
        } if ($aksi == "batal_transaksi") {
          include "views/pembayaran/batal_transaksi.php";
        } if ($aksi =="approve_p") {
          include "views/pembayaran/approve_pembayaran.php";
        }
      }


      if ($page == "laporan") {
        if ($aksi == "lap_krs") {
          include "views/laporan/lap_krs.php";
        }
      }

       if ($page == "monitoring") {
        if ($aksi == "monitoringApprove") {
          include "views/monitoring/monitoringApprove.php";
        } if ($aksi == "hapus") {
          include "views/monitoring/hapus.php";
        }
      }

      if ($page == "laporan_keu") {
        if ($aksi == "") {
          include "views/laporan_keu/laporan_keu.php";
        } if ($aksi == "detail") {
          include "views/laporan_keu/detail_laporan.php";
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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


 $(function() {
     
      CKEDITOR.replace('editor')
    })
    $(function() {
    
      CKEDITOR.replace('editor1')
    })

</script>


</html>