<?php

$conn = mysqli_connect("localhost", "root", "", "siakadstite2");

$query = mysqli_query($conn, "SELECT nama_mk FROM mata_kuliah");

// Mengecek apakah query berhasil dijalankan
if ($query) {
    $return_arr = array();
    
    while ($row = mysqli_fetch_assoc($query)) {
        $return_arr[] = $row['nama_mk'];
    }
    
    echo json_encode($return_arr);
} else {
    echo "Query error: " . mysqli_error($conn);
}

?>
