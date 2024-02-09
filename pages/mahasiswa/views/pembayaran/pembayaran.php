<?php 

$conn = mysqli_connect("localhost", "root", "", "siakadstiesulutbaru");

$nim = $_SESSION['nim'];





$query = mysqli_query($conn,"SELECT * FROM set_pembayaran WHERE nim = '$nim'");
if (mysqli_num_rows($query) !== 0) { ?>

<div class="content">
    <section class="content-header">
        <h1>
          TRANSAKSI PEMBAYARAN MAHASISWA
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">    
            <!-- List Tagihan Bulanan -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">PILIH TAGIHAN </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="success">
                                                <th>No.</th>
                                                <th>Tahun Akademik</th>
                                                <th>Nama Pembayaran</th>
                                                <th>Total Tagihan</th>
                                                <th>Total Pembayaran</th>
                                                <th>Status Bayar</th>
                                                <th>Status Approve</th>
                                                <th>Aksi</th>
                                               
                                            </tr>
                                        </thead>
                                    <tbody>
                                        <?php 
                                        $query_data = mysqli_query($conn,"SELECT 
                                            set_pembayaran.id_set,
                                            set_pembayaran.nim,
                                            set_pembayaran.id_jenisPembayaran,
                                            set_pembayaran.id_semester,
                                            set_pembayaran.jumlah_bayar,
                                            set_pembayaran.jumlah_yangdibayar,
                                            set_pembayaran.approved,
                                            semester.id_semester,
                                            semester.nama_semester,
                                            jenis_pembayaran.id_jenisPembayaran,
                                            jenis_pembayaran.id_pembayaran,
                                            nama_pembayaran.id_pembayaran,
                                            nama_pembayaran.nama_pembayaran
                                            FROM set_pembayaran
                                            INNER JOIN semester ON set_pembayaran.id_semester = semester.id_semester
                                            INNER JOIN jenis_pembayaran ON set_pembayaran.id_jenisPembayaran = jenis_pembayaran.id_jenisPembayaran
                                            INNER JOIN nama_pembayaran ON jenis_pembayaran.id_pembayaran = nama_pembayaran.id_pembayaran WHERE set_pembayaran.nim = $nim");

                                            ?>
                                            <?php $no = 1;  ?>
                                            <?php foreach($query_data as $data) : ?>
                                               
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $data['nama_semester'] ?></td>
                                                    <td><?= $data['nama_pembayaran'] ?></td>
                                                    <td><?= $data['jumlah_bayar'] ?></td>
                                                    <td><?= number_format($data['jumlah_yangdibayar']) ?></td>
                                                    
                                                   
                                                    <?php if (floatval($data['jumlah_yangdibayar']) < floatval($data['jumlah_bayar'])): ?>
                                                      <td><a href="#" class=" btn btn-xs btn-danger">BELUM LUNAS</a></td>
                                                  <?php else: ?>
                                                     <td><a href="#" class=" btn btn-xs btn-success">LUNAS</a></td>
                                                  <?php endif; ?>

                                                  <?php if ($data['approved'] == 1): ?>
                                                      <td>
                                                        <a href="" class=" btn btn-xs btn-success">APPROVED</a>
                                                    </td>
                                                    <?php else : ?>
                                                        <td>
                                                        <a href="" class=" btn btn-xs btn-warning">BELUM DIAPPROVE</a>
                                                    </td>
                                                  <?php endif ?>

                                                  <?php
                                                    $query_smt = mysqli_query($conn, "SELECT id_semester, status FROM semester WHERE status = '1'");
                                                    $d_smt = mysqli_fetch_assoc($query_smt);
                                                    ?>

                                                    <?php if ($d_smt["id_semester"] !== $data["id_semester"]) : ?>
                                                    <td>
                                                        <a href="#" class="btn btn-danger btn-xs" disabled><i class="glyphicon glyphicon-edit"></i> Close</a>
                                                    </td>
                                                    <?php else : ?>
                                                    <td>
                                                        <a href="?page=pembayaran&aksi=inputPembayaranMhs&id_set=<?= $data['id_set'] ?>&id_smt=<?= $d_smt['id_semester'] ?>" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-edit"></i> Bayar</a>
                                                    </td>
                                                    <?php endif ?>
                                                    <?php 

                                                   
                                                   

                                                    ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
                   
            </div>
        </div>
    </section>
</div>


<?php } else {
echo '<div style="background-color: #337ab7; color: #fff; padding: 10px;">
        MOHON MAAFT!! KEUANGAN BELUM DISET
    </div>'; 
}
?>




