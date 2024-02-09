<?php 
  include "../../../../config/fungsi.php";

$list = $_POST["prov_id"];
// var_dump($list); die();
   $materi = mysqli_query($conn, "SELECT * FROM materi
          INNER JOIN mata_kuliah ON materi.id_mk = mata_kuliah.id_mk
          WHERE materi.id_mk = $list");
 ?>
         
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Mata Kuliah</th>
                  <th>Judul</th>
                  <th>File</th>
                </tr>
                </thead>
                <tbody>
                  <?php $no = 1;  ?>
                  <?php foreach ($materi as $row) : ?>
                <tr>                  
                  <td><?= $no; ?></td>
                  <td><?= $row['nama_mk']?></td>
                  <td><?= $row['judul']?></td> 
                  <td><a href="views/materi/download.php?file=<?= $row["file"]; ?>"><?= $row['file'] ?></a></td> 
                </tr>      
                  <?php $no++; ?>
                  <?php endforeach; ?>
                </tfoot>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          
          <!-- /.box -->
    </section>