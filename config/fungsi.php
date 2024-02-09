<?php 
include "koneksi.php";


// CRUD PRODI
function tambah_prodi($data) {
    global $conn;

    // Ambil data dari tiap elemen dalam form
    $kode = $data["kode"];
    $nama = $data["nama"];
    $nip = $data["nip"];    

    // Tambahkan user baru ke database menggunakan prepared statement
    $query = "INSERT INTO jurusan VALUES (NULL, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'isss', $kode, $nama, $nip);

    if (mysqli_stmt_execute($stmt)) {
        return mysqli_affected_rows($conn);
    } else {
        // Jika ada error, Anda bisa melakukan logging atau penanganan error lainnya.
        // Misalnya: error_log(mysqli_error($conn));
        return -1; // Atau nilai lain yang menandakan gagal untuk menyimpan data.
    }

    mysqli_stmt_close($stmt);
}


function tambah_kelas($data){
	global $conn;
	$kelas = htmlspecialchars($data["kelas"]);

	mysqli_query($conn, "INSERT INTO kelas VALUES ('','$kelas')");
	return mysqli_affected_rows($conn);
}

function ubah_kelas($data){
	global $conn;
	$id_kelas		= $data["id_kelas"];
	$nama			= htmlspecialchars($data["nama_kelas"]);

	$query = "UPDATE kelas SET
				id_kelas 		= '$id_kelas',
				nama_kelas 		= '$nama'
				WHERE id_kelas  = $id_kelas";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function hapus_kelas($id) {
	global $conn;
	$id = intval($id); // Pastikan $id adalah bilangan bulat (integer)
	$query = "DELETE FROM kelas WHERE id_kelas = ?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return mysqli_affected_rows($conn);
}

function hapus_monitoring($id) {
	global $conn;
	$id = intval($id); // Pastikan $id adalah bilangan bulat (integer)
	$query = "DELETE FROM approve WHERE id = ?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return mysqli_affected_rows($conn);
}

function hapus_prodi($id) {
	global $conn;
	$id = intval($id); // Pastikan $id adalah bilangan bulat (integer)
	$query = "DELETE FROM jurusan WHERE id_jurusan = ?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return mysqli_affected_rows($conn);
}

function ubah_prodi($data) {
	global $conn;
	$id   = $data["id"]; // Pastikan $id adalah bilangan bulat (integer)
	$kode = $data["kode"];
	$prodi = $data["prodi"];
	$nip  = $data["nip"];

	$query = mysqli_prepare($conn, "UPDATE jurusan SET kode_jurusan = ?, nama_jurusan = ?, nip = ? WHERE id_jurusan = ?");
mysqli_stmt_bind_param($query, "isii", $kode, $prodi, $nip, $id);
mysqli_stmt_execute($query);

	
}


function tambah_dosen($data) {
	global $conn;
	$nip     = intval($data["nip"]); // Pastikan NIP adalah bilangan bulat (integer)
	$nama    = htmlspecialchars($data["nama"]);
	$jk  	 = htmlspecialchars($data["jk"]);
	$tgl     = htmlspecialchars($data["tanggal"]);
	$alamat  = htmlspecialchars($data["alamat"]);
	$telp  	 = htmlspecialchars($data["telp"]);
	$email   = htmlspecialchars($data["email"]);
	$didik   = htmlspecialchars($data["pendidikan"]);
	$pass    = $data["password"];
	$pass1   = $data["password1"];

	//cek username sudah ada atau belum
	$stmt = mysqli_prepare($conn, "SELECT nip FROM dosen WHERE nip = ?");
	mysqli_stmt_bind_param($stmt, "i", $nip);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);

	if(mysqli_stmt_num_rows($stmt) > 0){
		echo "<script>
				alert('NIP sudah terdaftar!');
			  </script>";	
		mysqli_stmt_close($stmt);
		return false;
	}

	mysqli_stmt_close($stmt);

	//cek konfirmasi password
	if ($pass !== $pass1){
		echo "<script>
				alert('Konfirmasi password tidak sesuai');
			  </script>";
		return false;
	}

	//enkripsi password
	$pass = password_hash($pass, PASSWORD_DEFAULT);
	
	// Upload gambar
	$gambar = upload();
	if(!$gambar){
		return false;
	}

	$query = "INSERT INTO dosen	VALUES 
				('$nip', '$nama','$jk','$tgl','$alamat','$telp','$email','$didik','$gambar','$pass')";

	mysqli_query($conn, $query);
 
	return mysqli_affected_rows($conn);
}

function hapusPertanyaan($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM pertanyaan WHERE id = $id");
	return mysqli_affected_rows($conn);

}
function hapusAspek($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM aspek WHERE id_aspek = $id");
	return mysqli_affected_rows($conn);

}
function hapusJenisPembayaran($id){
	global $conn;
	mysqli_query($conn,"DELETE FROM jenis_pembayaran WHERE id_jenisPembayaran = $id");
	return mysqli_affected_rows($conn);

}


// UPLOAD FOTO
function upload() {
	$namaFile   = $_FILES['foto']['name'];
	$ukuranFile = $_FILES['foto']['size'];
	$error 		= $_FILES['foto']['error'];
	$tmpName 	= $_FILES['foto']['tmp_name']; 

	// Cek apakah tidak ada gambar yang diupload
	// tidak ada gambar yang di upload
	if ($error === 4) { 
		$namaFile = "avatar.png";
		return $namaFile;
	}

	//cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg','jpeg','png','gif'];
	//ambil ekstensi file
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
		echo "<script>
			alert('yang anda upload bukan gambar');
			</script>";
		return false;
	}

	//cek jika ukurannya terlalu besar
	if ($ukuranFile > 1000000) {
		echo "<script>
			alert('Ukuran gambar terlalu besar (dibawa 1GB ');
			</script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, '../../assets/img/'. $namaFileBaru);
	return $namaFileBaru;
}

function hapus_dosen($nip){
	global $conn;
	mysqli_query($conn, "DELETE FROM dosen WHERE nip = $nip");
	return mysqli_affected_rows($conn);
}

function ubah_dosen($data){
	global $conn;
	//ambil data dari tiap elemen dalam form
	$nip     = htmlspecialchars($data["nip"]);
	$nama    = htmlspecialchars($data["nama"]);
	$jk  	 = htmlspecialchars($data["jk"]);
	$tgl     = htmlspecialchars($data["tanggal"]);
	$alamat  = htmlspecialchars($data["alamat"]);
	$telp  	 = htmlspecialchars($data["telp"]);
	$email   = htmlspecialchars($data["email"]);
	$didik   = htmlspecialchars($data["pendidikan"]);
	$pass    = mysqli_real_escape_string($conn, $data["password"]);
	$pass1   = mysqli_real_escape_string($conn, $data["password1"]);
	$fotoLama = htmlspecialchars($data["fotoLama"]);

	if ($pass !== $pass1){
		echo "<script>
				alert('konfirmasi password tidak sesuai');
			  </script>";
		return false;
	}

	//enkripsi password
	$pass = password_hash($pass, PASSWORD_DEFAULT);

	//CEK apakah user pilih gambar baru atau tidak
	if($_FILES['foto']['error'] === 4){
		$foto = $fotoLama;
	}else{
		$foto = upload();
	}

	//query insert data
	$query = "UPDATE dosen SET
				nip 					= '$nip',
				nama_dosen 				= '$nama',
				jenis_kelamin 			= '$jk',
				tanggal_lahir 			= '$tgl',
				alamat					= '$alamat',
				telp					= '$telp',
				email  					= '$email',
				pendidikan_terakhir 	= '$didik',
				foto  					= '$foto',
				password 				= '$pass'
				WHERE nip 				= $nip";


	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// CRUD MAHASISWA
function tambah_mahasiswa($data) {
	global $conn;
	$nim     	= htmlspecialchars($data["nim"]);
	$nama    	= htmlspecialchars($data["nama"]);
	$jk  	 	= htmlspecialchars($data["jk"]);
	$tgl     	= htmlspecialchars($data["tanggal"]);
	$nik     	= htmlspecialchars($data["nik"]);
	$tempat	 	= htmlspecialchars($data["tempat"]);
	$alamat  	= htmlspecialchars($data["alamat"]);
	$telp  	 	= htmlspecialchars($data["telp"]);
	$angkatan  	= htmlspecialchars($data["angkatan"]);
	$email   	= htmlspecialchars($data["email"]);
	$agama   	= $_POST["agama"];
	$nip     	= $data["nip"];
	$prodi   	= $data["prodi"];
	$pass    	= mysqli_real_escape_string($conn, $data["password"]);
	$pass1   	= mysqli_real_escape_string($conn, $data["password1"]);


	//cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim = '$nim'");

	if(mysqli_fetch_assoc($result)){
		echo "<script>
				alert('nim sudah terdaftar!');
			  </script>";	
		return false;
	}

	//cek konfirmasi password
	if ($pass !== $pass1){
		echo "<script>
				alert('konfirmasi password tidak sesuai');
			  </script>";
		return false;
	}

	//enkripsi password
	$pass = password_hash($pass, PASSWORD_DEFAULT);
	
	// Upload gambar
	$gambar = upload();
	if(!$gambar){
		return false;
	}
	$query = "INSERT INTO mahasiswa	VALUES 
				('$nim','$nama','$nik','$jk','$tempat','$tgl','$alamat','$telp','$email','$agama','$gambar','$pass','$nip','$prodi','$angkatan')";

	mysqli_query($conn, $query);
 
	return mysqli_affected_rows($conn);

} function ubahPass($data){
	global $conn;
	$nim   = $data["nim"];
	$pass1 = htmlspecialchars($data["pass1"]);
	$pass2 = htmlspecialchars($data["pass2"]);

	if ($pass1 !== $pass2 ) {
		echo "<script>
				alert('Konfirmasi password tidak sesuai');
				 window.history.back();
			  </script>";
		return false;
	}
	$pass = password_hash($pass1, PASSWORD_DEFAULT);

	$query = "UPDATE mahasiswa SET password = '$pass' WHERE nim = '$nim'";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);

}
function ubahAdmin($data) {

	global $conn;

	$id   = $data["id"];
	$pass1 = htmlspecialchars($data["pass1"]);
	$pass2 = htmlspecialchars($data["pass2"]);

	if ($pass1 !== $pass2 ) {
		echo "<script>
				alert('Konfirmasi password tidak sesuai');
				 window.history.back();
			  </script>";
		return false;
	}
	$pass = password_hash($pass1, PASSWORD_DEFAULT);

	$query = "UPDATE admin SET password = '$pass' WHERE id_admin = $id";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);




}

function hapus_mahasiswa($nim){
	global $conn;
	mysqli_query($conn,"DELETE FROM mahasiswa WHERE nim = $nim");
	return mysqli_affected_rows($conn);
}
function hapus_maba($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM maba WHERE no_pendaftaran = '$id'");
	return mysqli_affected_rows($conn);
}


function ubah_mahasiswa($data){
	global $conn;
	//ambil data dari tiap elemen dalam form

	$nim     	= htmlspecialchars($data["nim"]);
	$nama    	= htmlspecialchars($data["nama"]);
	$jk  	 	= htmlspecialchars($data["jk"]);
	$tempat	 	= htmlspecialchars($data["tempat"]);
	$tgl     	= htmlspecialchars($data["tgl"]);
	$nik     	= htmlspecialchars($data["nik"]);
	$alamat  	= htmlspecialchars($data["alamat"]);
	$telp  	 	= htmlspecialchars($data["telp"]);
	$email   	= htmlspecialchars($data["email"]);
	$agama   	= $data["agama"];
	$fotoLama 	= htmlspecialchars($data["fotoLama"]);
	$angkatan  	= $data["angkatan"];
	$nip     	= $data["nip"];
	$prodi   	= $data["prodi"];
	

	//CEK apakah user pilih gambar baru atau tidak
	if($_FILES['foto']['error'] === 4){
		$foto = $fotoLama;
	}else{
		$foto = upload();
	}

	//query updat data
	$query = "UPDATE mahasiswa SET
				nim 			= '$nim',
				nama 			= '$nama',
				nik      		= '$nik',
				jenis_kelamin 	= '$jk',
				tempat_lahir	= '$tempat',
				tgl_lahir 		= '$tgl',	
				alamat			= '$alamat',
				telp			= '$telp',
				email  			= '$email',
				agama 			= '$agama',
				foto  			= '$foto',
				nip   			= '$nip',
				id_jurusan 		= '$prodi',
				id_angkatan		= '$angkatan'
				WHERE nim 		= '$nim'";


	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// CRUD JADWAL
function tambah_jadwal($data){
	global $conn;
	//ambil data dari tiap elemen dalam form
	$mk 			= htmlspecialchars($data["mk"]);
	$dosen 			= htmlspecialchars($data["dosen"]);
	$thn_akad		= htmlspecialchars($data["thn_akad"]);
	$hari 			= $data["hari"];
	$mulai 			= $data["mulai"];
	$selesai 		= $data["selesai"];
	$jrs 			= $data["jrs"];
	$kelas 			= $data["kelas"];
	$smt 			= $data["smt"];
	
	//tambahkan user baru ke database
	mysqli_query($conn, "INSERT INTO jadwal VALUES ('','$mk','$dosen','$thn_akad','$hari','$mulai','$selesai','$jrs','$kelas', '$smt')");
	return mysqli_affected_rows($conn);
}

function hapus_jadwal($id) {
 	global $conn;
 	mysqli_query($conn, "DELETE FROM jadwal WHERE id_jadwal = '$id'");
 	return mysqli_affected_rows($conn);
}

function ubah_jadwal($data) {
	global $conn;
	$id 	 = $data["id"];
	$mk      = htmlspecialchars($data["mk"]);
	$dosen   = htmlspecialchars($data["dosen"]);
	$sem  	 = htmlspecialchars($data["semester"]);
	$prodi 	 = htmlspecialchars($data["prodi"]);
	$hari    = $data["hari"];
	$mulai   = $data["mulai"];
	$selesai = $data["selesai"];
	$kelas   = $data["kelas"];
	$smt     = $data["smt"];

	$query = "UPDATE jadwal SET
				id_jadwal			= '$id',
				id_mk       		= '$mk',
				nip 				= '$dosen',
				id_semester 		= '$sem',
				hari 				= '$hari',
				jam_mulai			= '$mulai',
				jam_selesai			= '$selesai',
				id_jurusan 			= '$prodi',
				id_kelas 			= '$kelas',
				id_paketSemester 	= '$smt'
				WHERE id_jadwal		= $id";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function tambah_mk($data) {
    global $conn;

    // Ambil data dari tiap elemen dalam form
    $kode = htmlspecialchars($data["kode"]);
    $nama = htmlspecialchars($data["nama"]);
    $sks = htmlspecialchars($data["sks"]);
    $sem = $data["sem"];
    $jrs = $data["jurusan"];

    // Periksa apakah kode mata kuliah sudah terdaftar
    $query_mk = mysqli_prepare($conn, "SELECT kode_mk FROM mata_kuliah WHERE kode_mk = ?");
    mysqli_stmt_bind_param($query_mk, "s", $kode);
    mysqli_stmt_execute($query_mk);
    mysqli_stmt_store_result($query_mk);

    if (mysqli_stmt_num_rows($query_mk) > 0) {
        echo "<script>alert('Kode mk sudah terdaftar')</script>";
        return false;
    }

    // Tambahkan MK baru ke database
    $query_insert = "INSERT INTO mata_kuliah VALUES (NULL, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $query_insert);
    mysqli_stmt_bind_param($stmt_insert, "sssss", $kode, $nama, $sks, $sem, $jrs);

    if (!mysqli_stmt_execute($stmt_insert)) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    return mysqli_affected_rows($conn);
}



function hapus_mk($id) {
 	global $conn;
 	mysqli_query($conn, "DELETE FROM mata_kuliah WHERE id_mk = '$id'");
 	return mysqli_affected_rows($conn);
}

function hapus_setPembayaran($id) {
 	global $conn;
 	mysqli_query($conn, "DELETE FROM set_pembayaran WHERE id_set = '$id'");
 	return mysqli_affected_rows($conn);
}



function ubah_mk($data) {
    global $conn;

    $id_mk   = mysqli_real_escape_string($conn, $_POST["id_mk"]);
    $kode    = mysqli_real_escape_string($conn, $_POST["kode"]);
    $nama    = mysqli_real_escape_string($conn, $_POST["nama"]);
    $sks     = mysqli_real_escape_string($conn, $_POST["sks"]);   
    $sem     = mysqli_real_escape_string($conn, $_POST["semester"]);
    $jurusan = mysqli_real_escape_string($conn, $_POST["jurusan"]);

    $query = "UPDATE mata_kuliah SET
                           kode_mk 			= '$kode',
                           nama_mk 			= '$nama',
                           sks 				= '$sks',
                           id_paketSemester = '$sem',
                           id_jurusan 		= '$jurusan'
                           WHERE id_mk 		= $id_mk";
    	mysqli_query($conn, $query);
		return mysqli_affected_rows($conn);
}



// FUNGSI UNTUK KRS
function tambah_krs($data){
    global $conn;
    $nimProcessed = []; // Array untuk menyimpan NIM yang sudah diproses
    $jumlah = count($_POST['cek']);

    for ($i = 0; $i < $jumlah; $i++) {
        $nim       = $_POST['nim'];
        $prd       = $_POST['prodi'];
        $semester  = $_POST['semester'];
        $kd        = $_POST['cek'][$i];
        $kelas     = $_POST['cek'][$i];

        // Tambahkan data baru ke tabel khs
        $query = "INSERT INTO khs VALUES ('', '$nim', '$kd', '$prd', '$semester', '$kelas','','','','','','')";
        mysqli_query($conn, $query);

        //cek apakah sudah ada data nim pada tabel approve
        $cek = mysqli_query($conn, "SELECT * FROM approve WHERE nim = '$nim' AND id_semester = '$semester'");

        if (mysqli_num_rows($cek) == 0) {

        
        	// Cek apakah NIM sudah diproses sebelumnya
        	if (!in_array($nim, $nimProcessed)) {
            $nimProcessed[] = $nim; // Tambahkan NIM ke array

            // Tambahkan data nim ke tabel approve
            $query_approve = "INSERT INTO approve (nim, id_semester) VALUES ('$nim','$semester')";
            mysqli_query($conn, $query_approve);
        }
    }
    }
    return mysqli_affected_rows($conn);
}








// Hapus KRS
function hapus_krs($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM khs WHERE id_khs = '$id'");
	return mysqli_affected_rows($conn);
}

function tambah_materi($data) {
	global $conn;
	
	$kode_mk = htmlspecialchars($data["mk"]);
	$judul   = htmlspecialchars($data["Judul"]);
	// var_dump($kode_smt); die();
	// Upload gambar
	$file = materi();
	if(!$file){
		return false;
	}

	$query = "INSERT INTO materi VALUES 
				('', '$kode_mk','$judul','$file')";

	mysqli_query($conn, $query);
 
	return mysqli_affected_rows($conn);
}

function materi() {
	$namaFile   = $_FILES['file']['name'];
	$ukuranFile = $_FILES['file']['size'];
	$error 		= $_FILES['file']['error'];
	$tmpName 	= $_FILES['file']['tmp_name']; 

	// Cek apakah tidak ada gambar yang diupload
	// tidak ada gambar yang di upload
	if ($error === 4) { 
		echo "<script>
			alert('pilih dokumen terlebih dahulu');
			</script>";
		return false;
	}

	//cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['pdf','doc','docx','pptx','ppt'];
	//ambil ekstensi file
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
		echo "<script>
			alert('yang anda upload bukan dokumen');
			</script>";
		return false;
	}

	//cek jika ukurannya terlalu besar
	if ($ukuranFile > 1000000) {
		echo "<script>
			alert('Ukuran dokumen terlalu besar');
			</script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= $namaFile;
	

	move_uploaded_file($tmpName, '../../assets/materi/'. $namaFileBaru);
	return $namaFileBaru;
}


function hapus_materi($id_materi) {
 	global $conn;

 	$file = query("SELECT * FROM materi WHERE id_materi = $id_materi")[0];
 	$materi = $file['file'];

 	unlink('../../assets/materi/'.$materi);
 	// var_dump($materi); die();
 	mysqli_query($conn, "DELETE FROM materi WHERE id_materi = '$id_materi'");
 	return mysqli_affected_rows($conn);
}


function ubah_pengumuman($id_pengumuman) {
	global $conn;
	$id_pengumuman 			= htmlspecialchars($_POST['id_pengumuman']);
	$nama_pengumuman 		= htmlspecialchars($_POST['nama_pengumuman']);
	$jenis_pengumuman 		= htmlspecialchars($_POST['jenis_pengumuman']);
	$tujuan_pengumuman 		= htmlspecialchars($_POST['tujuan_pengumuman']);
	$isi_pengumuman 		= $_POST['isi_pengumuman'];
	$status_pengumuman 		= htmlspecialchars($_POST['status_pengumuman']);
	$update_date 			= htmlspecialchars($_POST['update_date']);

	$query = "UPDATE pengumuman SET
					id_pengumuman		= '$id_pengumuman',
					nama_pengumuman		= '$nama_pengumuman',
					jenis_pengumuman	= '$jenis_pengumuman',
					tujuan				= '$tujuan_pengumuman',
					isi_pengumuman		= '$isi_pengumuman',
					status_post			= '$status_pengumuman',
					status_date			= '$update_date'
					WHERE id_pengumuman = '$id_pengumuman'";
		mysqli_query($conn, $query);
		return mysqli_affected_rows($conn);
}

