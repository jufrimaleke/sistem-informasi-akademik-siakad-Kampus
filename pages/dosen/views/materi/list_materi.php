<?php 
  include "../../../../config/fungsi.php";

$list = $_POST["prov_id"];

   $materi = mysqli_query($conn, "SELECT * FROM materi
          INNER JOIN mata_kuliah ON materi.id_mk = mata_kuliah.id_mk
          WHERE materi.id_mk = $list");

?>           
<div class="box-body">
<div class="table-responsive">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
      <th>No.</th>
      <th hidden="true">ID</th>
      <th>Mata Kuliah</th>
      <th>Judul</th>
      <th>File</th>
      <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
      <?php $no = 1;  ?>
      <?php foreach ($materi as $row) : ?>
    <tr>                  
      <td><?= $no; ?></td>
      <td hidden="true"><?= $row['id_materi'] ?></td>
      <td><?= $row['nama_mk']?></td>
      <td><?= $row['judul']?></td> 
      <td><a href="views/materi/download.php?file=<?= $row["file"]; ?>"><?= $row['file'] ?></a></td> 
      <td>                  
         <a href="?page=materi&aksi=ubah&id_materi=<?= $row["id_materi"]; ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
         <a href="?page=materi&aksi=hapus&id_materi=<?= $row["id_materi"]; ?>"onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
      </td> 
    </tr>      
      <?php $no++; ?>
      <?php endforeach; ?>
    </tfoot>
  </table>
  </div>
</div>
