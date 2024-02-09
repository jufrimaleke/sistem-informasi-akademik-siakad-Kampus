

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Box Comment -->
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <!-- /.user-block -->
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div align="right" class="col-sm-12">
                            <form method="POST" role="form" action="" enctype="multipart/form-data">
                                <p>
                                    <label></label>
                                    <select>
                                        <option></option>
                                        <option></option>
                                    </select>
                                    <label></label>
                                    <select>

                                    </select>
                                    <form method="post">
                                        <button type="submit" name="tampil" class="btn btn-success">
                                            <i class="fa fa-search"></i> FILTER</button>
                                        <input type="hidden" name="tampil" class="btn btn-success" value="1">
                                        <a class="btn btn-primary" href="">
                                                <i class="fa fa-print"></i> PRINT</a>
                                        </form>
                                </p>
                            </form>
                        </div>
                        <table class="table table-striped table-bordered bootstrap-datatable table-responsive">
                            <thead>
                                <tr class="text-center bg-primary">
                                    <th style="text-align: center;">
                                        <font color=white>NO.</font>
                                    </th>
                                    <th style="text-align: center;">
                                        <font color=white>SEMESTER</font>
                                    </th>
                                    <th style="text-align: center;">
                                        <font color=white>TAHUN AKADEMIK</font>
                                    </th>
                                    <th style="text-align: center;">
                                        <font color=white>SKOR KOMPONEN</font>
                                    </th>
                                    <th style="text-align: center;">
                                        <font color=white>JUMLAH RESPONDEN</font>
                                    </th>
                                    <th style="text-align: center;">
                                        <font color=white>PREDIKAT</font>
                                    </th>
                                    <th style="text-align: center;">
                                        <font color=white>ACTION</font>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    <tr class="text-center">
                                        <td></td>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       
                                        <td></td>
                                        <td></td>

                                        <td>
                                            <form method="post" action="">
                                                <input type="hidden" name="sem" value="">
                                                <input type="hidden" name="ta" value="">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-eye"></i> Detail</button>
                                            </form>
                                            <form method="post" action="">
                                                <input type="hidden" name="sem" value="">
                                                <input type="hidden" name="ta" value="">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-archive"></i> Lihat Saran</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                       
                            <tr>
                                <td colspan="7">
                                    <p class="text-center">
                                        --- Tidak Ada Data ---
                                    </p>
                                </td>
                            </tr>
                     

                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>