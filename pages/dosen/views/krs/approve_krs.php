<?php

$conn  = mysqli_connect("localhost","root","","siakadstiks");

if (isset($_POST['approve'])) {
    $nim = $_POST['nim'];

    // Lakukan tindakan approve di sini, misalnya mengubah status di tabel khs
    $query_update = "UPDATE approve SET status = 'approved' WHERE nim = $nim";
    mysqli_query($conn, $query_update);

    // Set session bahwa KRS telah di-approve
    $_SESSION['krs_approved'] = true;

    echo "
            <script>
                alert('KRS Berhasil Dihapus');
                document.location.href = '?page=dosen';
            </script>
        ";
}
?>
