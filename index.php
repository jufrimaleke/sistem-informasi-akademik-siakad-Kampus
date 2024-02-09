<?php
date_default_timezone_set('Asia/Singapore');
session_start();
if (isset($_SESSION["admin"])) {
  header("location: pages/admin/index.php");
  exit;
}else if(isset($_SESSION["dosen"])) {
  header("location: pages/dosen/index.php");
  exit;
}else if(isset($_SESSION["mahasiswa"])) {
  header("location: pages/mahasiswa/index.php");
  exit;
}else if(isset($_SESSION["operator"])) {
  header("location: pages/operator/index.php");
  exit;
}

include 'config/koneksi.php';

if (isset($_POST["login"])) {
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

  //cek username
  if (mysqli_num_rows($result) === 1) {
   
    //cek password
    $row = mysqli_fetch_assoc($result); 

    if(md5($password, $row["password"])){
    $_SESSION["admin"] = $username;
    $_SESSION["nama"]  = $row['nama'];

    header("location: pages/admin/home");
      exit;
    }
  }
   $result = mysqli_query($conn, "SELECT nip,nama_dosen,password FROM dosen WHERE nip = '$username'");

  //cek username
  if (mysqli_num_rows($result) === 1) {
   
    //cek password
    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row["password"])){
    $_SESSION["dosen"]        = $username;
    $_SESSION["nama"]         = $row['nama_dosen'];
    $_SESSION["nip"]          = $row['nip'];
    header("location: pages/dosen/home");
      exit;
    }
  }
  $result = mysqli_query($conn, "SELECT nim,nama,password FROM mahasiswa WHERE nim = '$username'");

  //cek username
  if (mysqli_num_rows($result) === 1) {
   
    //cek password
    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row["password"])){
    $_SESSION["mahasiswa"] = $username;
    $_SESSION["nama"]      = $row['nama'];
    $_SESSION["nim"]       = $row['nim'];   
    header("location: pages/mahasiswa/home");
      exit;
    }
  }

  $result = mysqli_query($conn, "SELECT * FROM operator WHERE user = '$username'");
  //cek username
  if (mysqli_num_rows($result) === 1) {
   
    //cek password
    $row = mysqli_fetch_assoc($result); 

    if(sha1($password) == $row["pass"]){
    $_SESSION["operator"] = $username;
    $_SESSION["nama"]  = $row['nama'];

    header("location: pages/operator/home");
      exit;
    }
  }
  $error = true;
  
}
 


 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Halaman Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
  <link rel="shortcut icon" type="text/css" href="assets/img/Logo.PNG">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>


<!-- <body class="hold-transition login-page" style="background-image: url('assets/img/bg.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 80px 80px;">>
   <script>
      // Mengubah ukuran gambar latar belakang dengan JavaScript
      var body = document.body;
      body.style.backgroundSize = "70px 70px"; // Ubah ukuran sesuai keinginan
   </script> -->
<div class="login-box">
  <div class="login-logo">
    
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
     <div class="login-logo">
        <b>SIAKAD STIESULUT MANADO</b><br>
       
        <img src="assets/img/logo3.jpg"style="border-radius: 10px;" width="100" >
      </div>
    <p class="login-box-msg">Sign in to start your session</p>
    
    <!-- warning username dan password salah -->
    <?php if(isset($error)): ?>
    <div class="callout callout-danger">
          <h4>Warning!</h4>

          <p>Username atau Password Salah</p>
    </div>
    <?php endif; ?>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" name="username" required />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
             
        <div class="col-xs-4">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
</div>
<script src="assets/js/backstretch/libs/jquery/jquery.js"></script>
<script src="assets/js/backstretch/jquery.backstretch.min.js"></script>
<script>
  $(document).ready(function () {
    // Menggunakan plugin backstretch untuk mengatur gambar latar belakang.
    $.backstretch("assets/img/bg.JPG", { speed: 500,
    backgroundSize: "cover" });
  });
</script>

</body>
</html>
