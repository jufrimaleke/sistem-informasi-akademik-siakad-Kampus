<?php
$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

$id_jenisBayar = $_POST['id_jenisPembayaran'];

$result = mysqli_query($conn, "SELECT * FROM jenis_pembayaran WHERE id_jenisPembayaran = '$id_jenisBayar'");
$data = mysqli_fetch_array($result);

if ($data) {
    echo json_encode(array('payment' => $data['payment'], 'payment_tipe' => $data['payment_tipe']));
} else {
    echo json_encode(array('error' => 'Data not found'));
}

mysqli_close($conn);

?>

