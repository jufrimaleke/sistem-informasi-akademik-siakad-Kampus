<?php
$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

$jurusan = $_POST['jrs'];
$resultjrs = mysqli_query($conn, "SELECT nim, nama, id_jurusan FROM mahasiswa WHERE id_jurusan = '$jurusan'");
$datajrs = array();

while ($row = mysqli_fetch_assoc($resultjrs)) {
    $datajrs[] = array('nim' => $row['nim'], 'nama' => $row['nama']);
}

if ($datajrs) {
    echo json_encode($datajrs);
} else {
    echo json_encode(array('error' => 'Data not found'));
}

mysqli_close($conn);
?>
