<?php
include "../../../../config/fungsi.php";
 $prodi = mysqli_query($conn, "SELECT * FROM jurusan
		 INNER JOIN dosen ON jurusan.nip = dosen.nip");

$filename="Data_Prodi.pdf";
$content = ob_get_clean();
//<span style='font-size: 10pt;'>Jl. Sukarjo Wiryopranoto No. 97B Maphar, Kec. Taman Sari - Jakarta Barat 11160, Telp. (021) 6390363</span>
$content = '
<style type="text/css">
.tabel { border-collapse:collapse; }
.tabel th { padding:0 10px 0 10px; background-color:#f60; color:#fff; }
table { vertical-align:top; }
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
		<span style="font-size:15px;"><u>LAPORAN DATA PROGRAM STUDI</u></span>
	</div>

	<table border="1px" class="tabel" >
		<tr>
			<th>No.</th>
			<th>Kode Prodi</th>
			<th align="center" style="padding:0 70px 0 70px;">Nama Prodi</th>
			<th align="center" style="padding:0 40px 0 40px;">Bidang Studi</th>
			<th align="center" style="padding:0 80px 0 80px;">Ketua Prodi</th>
		</tr>';
		$no = 1;
		while ($data = mysqli_num_rows($prodi) > 0) {
		foreach ($prodi as $row) {
			$content .= '
			<tr>
				<td align="center">'.$no++.'</td>
				<td align="center">'.$row["kode_jurusan"].'</td>
				<td>'.$row["nama_jurusan"].'</td>
				<td>'.$row["bidang_studi"].'</td>
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
$html2pdf = new HTML2PDF('P','A4','en'); 
$html2pdf->WriteHTML($content);
$html2pdf->Output($filename);
}
?>