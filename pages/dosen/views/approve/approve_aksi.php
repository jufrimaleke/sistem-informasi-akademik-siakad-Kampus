<?php
session_start();
 include "../../../../config/fungsi.php"; 

 $conn = mysqli_connect("localhost", "root", "", "siakadstiks");

$admin = $_SESSION['dosen'];
$query_d = mysqli_query($conn, "SELECT nama_dosen FROM dosen WHERE nip = '$admin'");
$data_d = mysqli_fetch_array($query_d);

$datetime = date("Y-m-d H:i:s");



if (isset($_GET['nim'])) {

    $nim = $_GET['nim'];
    $id = $_GET['id'];

    $sanitizedNim = mysqli_real_escape_string($conn, $nim);
    $sanitizedId = mysqli_real_escape_string($conn, $id);
    $query = mysqli_query($conn, "UPDATE approve SET status = '1', approve_by = '{$data_d['nama_dosen']}', approve_date = '$datetime' WHERE nim = '$sanitizedNim' AND id_semester = '$sanitizedId'");


    if ($query) {
        echo "
			<script>
			    alert('Approve Berhasil.');
			    window.location.href = document.referrer;
			</script>
			";
    } else {
        echo "
			<script>
			    alert('Approve Gagal.');
			    window.location.href = document.referrer;
			</script>
			";
    }

    
    if (isset($_GET['action']) && $_GET['action'] == 'batal') {
    $nim = $_GET['nim'];
    $id = $_GET['id'];

    $sanitizedNim = mysqli_real_escape_string($conn, $nim);
    $sanitizedId = mysqli_real_escape_string($conn, $id);
    
   $queryBatal = mysqli_query($conn, "UPDATE approve SET status = '0' WHERE nim = '$sanitizedNim' AND id_semester = '$sanitizedId'");

    if ($queryBatal) {
        echo "
            <script>
                alert('Batal Berhasil.');
                window.location.href = document.referrer;
            </script>";
    } else {
        echo "
            <script>
                alert('Batal Gagal.');
                window.location.href = document.referrer;
            </script>";
    }

    mysqli_close($conn);

}

} 

















 ?>