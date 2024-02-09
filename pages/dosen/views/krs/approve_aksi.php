<?php
 include "../../../../config/fungsi.php"; 
 $conn = mysqli_connect("localhost", "root", "", "siakadstiks");

if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];
    

    $sanitizedNim = mysqli_real_escape_string($conn, $nim);
    
    $query = mysqli_query($conn, "UPDATE approve SET status = '1' WHERE nim = '$sanitizedNim' AND id_semester = '20231'");

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
    $sanitizedNim = mysqli_real_escape_string($conn, $nim);
    
    $queryBatal = mysqli_query($conn, "UPDATE approve SET status = '0' WHERE nim = '$sanitizedNim'");

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