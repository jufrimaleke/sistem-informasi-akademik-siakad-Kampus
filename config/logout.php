<?php 
session_start();
if  (isset($_SESSION["admin"])) {
	unset($_SESSION['admin']);
	echo "<script>window.location='../login';</script>";
}else if (isset($_SESSION["dosen"])) {
	unset($_SESSION['dosen']);
	echo "<script>window.location='../login';</script>";
}else if (isset($_SESSION["mahasiswa"])) {
	unset($_SESSION['mahasiswa']);
	echo "<script>window.location='../login';</script>";
}else if (isset($_SESSION["operator"])) {
	unset($_SESSION['operator']);
	echo "<script>window.location='../login';</script>";
}
 ?>