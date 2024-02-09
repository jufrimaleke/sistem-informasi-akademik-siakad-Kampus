<?php

if (!isset($_SESSION))session_start();

// Load file koneksi.php

include "../../../../config/fungsi.php";



// $id_krs = @$_SESSION['id_jadwal'];



if (isset($_POST['import'])) { // Jika user mengklik tombol Import
    $nama_file_baru = 'data.xlsx';
    // Load librari PHPExcel nya

    require_once '../../../../assets/PHPExcel/PHPExcel.php';
    $excelreader = new PHPExcel_Reader_Excel2007();
    $loadexcel = $excelreader->load('../../../../assets/tmp/mhs/' . $nama_file_baru); // Load file excel yang tadi diupload ke folder tmp

    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

    $sql_insert = "INSERT INTO mahasiswa (nim, nama, nik, jenis_kelamin, tempat_lahir, tgl_lahir, alamat, telp, email, agama, foto, password, nip, id_jurusan, id_angkatan) VALUES (?, ?, ?, ?, ?, ?, ?, '', '', ?, '', ?, ?, ?, ?)";

    $sql_update = "UPDATE mahasiswa SET nama = ?, nik = ?, jenis_kelamin = ?, tempat_lahir = ?, tgl_lahir = ?, alamat = ?, agama = ?, password = ?, nip = ?, id_jurusan = ?, id_angkatan = ? WHERE nim = ?";

    $stmt_insert = $conn->prepare($sql_insert);

    $stmt_update = $conn->prepare($sql_update);



    for ($i = 2; $i <= count($sheet); $i++) {

        $nim             = htmlspecialchars($sheet[$i]['B']);
        $nama            = htmlspecialchars($sheet[$i]['C']);
        $nik             = htmlspecialchars($sheet[$i]['D']);
        $jenis_kelamin   = htmlspecialchars($sheet[$i]['E']);
        $tempat_lahir    = htmlspecialchars($sheet[$i]['F']);
        $tgl_lahir       = htmlspecialchars($sheet[$i]['G']);
        $alamat          = htmlspecialchars($sheet[$i]['H']); 
        $agama           = htmlspecialchars($sheet[$i]['I']);
        $password        = htmlspecialchars($sheet[$i]['J']);
        $nip             = mysqli_real_escape_string($conn, htmlspecialchars($sheet[$i]['K']));
        $id_jurusan      = htmlspecialchars($sheet[$i]['L']);
        $id_angkatan     = htmlspecialchars($sheet[$i]['M']);

        $pass = password_hash($password, PASSWORD_DEFAULT);

        $chek = mysqli_query($conn, "SELECT nip FROM dosen WHERE nip = '$nip'");

        if(mysqli_num_rows($chek) == 0){
        echo "<script>
                alert('Nip tidak sesuai! Harap periksa kembali NIP dosen!');
                window.location.href = document.referrer;
              </script>";   
        return false;
        }



        if ($id_jurusan != 9 && $id_jurusan != 10) {

            echo "<script>
                alert('Data Id Prodi salah.');
                window.location.href = document.referrer;
            </script>";
            exit(); // Berhenti jika data tidak valid
        } else {

            // Periksa apakah data sudah ada di database

            $sql_check = "SELECT nim FROM mahasiswa WHERE nim = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("s", $nim);
            $stmt_check->execute();

            // Mengambil hasil query dalam bentuk array asosiatif
            $stmt_check->bind_result($nim_result);

            if ($stmt_check->fetch()) {
                // Data sudah ada, lakukan query UPDATE
                $stmt_update->bind_param("ssissssssiii",$nim, $nama, $nik, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $alamat, $agama, $pass, $nip, $id_jurusan, $id_angkatan);
                $stmt_update->execute();
            } else {

                // Data belum ada, lakukan query INSERT
                $stmt_insert->bind_param("ssissssssiii", $nim, $nama, $nik, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $alamat, $agama, $pass, $nip, $id_jurusan, $id_angkatan);

                $stmt_insert->execute();
            }

            echo "
                <script>
                    alert('Data berhasil diunggah.');
                    window.location.href = document.referrer;
                </script>
                ";
        }
    }
}

?>

