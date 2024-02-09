<?php
$conn	= mysqli_connect("localhost","root","","siakadstite2");
include "../../../../config/fungsi.php";
  $mahasiswa = mysqli_query($conn, "SELECT * FROM mahasiswa
  		 INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan");

$filename="Data_Mahasiswa.pdf";
$content = ob_get_clean();
$content = '
<style type="text/css">
.tabel { border-collapse:collapse; }
.tabel th { padding:0 5px 0 5px; background-color:#f60; color:#fff; }
table { vertical-align:top; }
tr { vertical-align:top; }
td { vertical-align:top; }
img { width:50px; }
</style>
';
							
$content .= '
<page>
	<table style="width:100%; text-align:center;">
		<tr>
			<td style="width:7%" rowspan="7"><img src="../../../../assets/img/Logo.jpg" width="80" height="80"></td>			
		</tr>
		<tr>
			<td style="width:78%; font-size:15px;">YAYASAN SULAWESI UTARA</td>
		</tr>
		<tr>
			<td style="font-size:15px; width:78%;">SEKOLAH TINGGI ILMU EKONOMI SULAWESI UTARA</td>
		</tr>
		<tr>
			<td style="font-size:12px; width:78%;">STATUS TERAKREDITASI</td>
		</tr>
		<tr>
			<td style="font-size:10px; width:78%;">Jl. R E Martadinata, Dendengan Luar, Kec. Tikala, Kota Manado, Sulawesi Utara </td>
		</tr>
		<tr>
			<td style="font-size:10px; width:78%;">Telp. 08114316860</td>
		</tr><br>
		<hr/>
	</table> 


	<div style="padding:5mm; border:0px;" align="center">
		<span style="font-size:15px;"><b><u>LAPORAN DATA MAHASISWA</u></b></span>
	</div>

	<table border="1px" class="tabel" >
		<tr>
			<th>No.</th>
			<th align="center">NIM</th>
			<th align="center">Nama</th>
			<th align="center">Jenis Kelamin</th>
			<th align="center">Alamat</th>
			<th align="center">Telepon</th>	
			<th align="center">Email</th>	
			<th align="center">Agama</th>
			<th align="center">Prodi</th>		
			<th align="center">Foto</th>
		</tr>';
		$no = 1;
		while ($data = mysqli_num_rows($mahasiswa) > 0) {
		foreach ($mahasiswa as $row) {
			$content .= '
			<tr>
				<td align="center">'.$no++.'</td>
				<td align="center">'.$row["nim"].'</td>
				<td>'.$row["nama"].'</td>
				<td align="center">'.$row["jenis_kelamin"].'</td>
				<td>'.$row["alamat"].'</td>
				<td>'.$row["telp"].'</td>
				<td>'.$row["email"].'</td>	
				<td>'.$row["agama"].'</td>
				<td align="center">'.$row["kode_jurusan"].'</td>					
				<td><img src="https://siakadpolimat.000webhostapp.com/assets/img/'.$row["foto"].'"></td>
			</tr>
			';
		}
$content .= '
		</table>
		<nobreak><br>
		<table cellspacing="0" style="width:100%; text-align:left;">
			<tr>
				<td style="width:70%;"></td>
				<td style="width:20%;">
					<p>Muara Teweh, '; 
					$content .=  date('d F Y');
					$content .= '<br> Wakil Direktur I Bidang Akademik</p> 
						<p>&nbsp;</p>
						ILHAN, SE., MM<br><hr/>
						NIP.175610008
				</td>
			</tr>
		</table>
		</nobreak>
</page>

';

require ("../../../../assets/html2pdf/html2pdf.class.php");
$html2pdf = new HTML2PDF('L','A4','en'); 
$html2pdf->WriteHTML($content);
$html2pdf->Output($filename);
}
?>