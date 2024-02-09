<?php
include "../../../../config/fungsi.php";
$jadwal = mysqli_query($conn, "SELECT * FROM jadwal
           INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
           INNER JOIN dosen ON jadwal.nip = dosen.nip");

$filename="Jadwal Kuliah.pdf";
$content = ob_get_clean();
//<span style='font-size: 10pt;'>Jl. Sukarjo Wiryopranoto No. 97B Maphar, Kec. Taman Sari - Jakarta Barat 11160, Telp. (021) 6390363</span>
$content = '
<style type="text/css">
.tabel { border-collapse:collapse; }
.tabel th { padding:0 10px 0 10px; background-color:#f60; color:#fff; }
table { vertical-align:top; align:center;}
tr { vertical-align:top; }
td { vertical-align:top; }
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
		<span style="font-size:15px;"><u>LAPORAN DATA JADWAL KULIAH</u></span>
	</div>
	<table border="1px" class="tabel">
	    <tr>
			<th>No.</th>
			<th align="center" style="padding:0px 20px 0px 20px;">Mata Kuliah</th>
			<th align="center" style="padding:0px 10px 0px 10px;">Semester</th>
			<th align="center" style="padding:0px 20px 0px 20px;">Hari</th>
			<th align="center" style="padding:0px 50px 0px 50px;">Jam</th>
			<th style="padding:0 80 0 80;">Dosen</th>
		</tr>';
		$no = 1;
		while ($data = mysqli_num_rows($jadwal) > 0) {
		foreach ($jadwal as $row) {
			$content .= '
			<tr>
				<td align="center">'.$no++.'</td>
				<td>'.$row["nama_mk"].'</td>
				<td align="center">'.$row["semester"].'</td>
				<td>'.$row["hari"].'</td>
				<td align="center">'.$row["jam_mulai"].' - '.$row["jam_selesai"].'</td>
				<td>'.$row["nama"].'</td>
			</tr>
			';
		}
$content .= ' 
		</table>
		<nobreak><br>
		<table cellspacing="0" style="width:100%; text-align:left;">
			<tr>
				<td style="width:70%;"></td>
				<td style="width:30%;">
					<p>Manado, '; 
					$content .=  date('d F Y');
					$content .= '<br> Wakil Direktur I Bidang Akademik</p> 
						<p>&nbsp;</p>
						..............................................................<br><hr/>
						NIP.123456
				</td>
			</tr>
		</table>
</page>

';

require ("../../../../assets/html2pdf/html2pdf.class.php");
$html2pdf = new HTML2PDF('P','A4','en'); 
$html2pdf->WriteHTML($content);
$html2pdf->Output($filename);
}
?>