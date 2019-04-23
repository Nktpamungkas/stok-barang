<?php
    if (isset($_SESSION['userId'])) {
        // Sessi Ada
        $idStaff = $_SESSION['userId'];
        include_once 'database/connection.php';
        $dataUserBySesion = mysql_query("SELECT * FROM staf WHERE id_staff = '$idStaff'");
        $fetchDataUserBySesion = mysql_fetch_assoc($dataUserBySesion);
    } else {
        header("Location: ?");
    }
?>
<?php
    if(isset($_POST['submit'])){
        include_once 'database/connection.php';

        $kode_brg = $_POST['kode_brg'];
        $jenis_brg = $_POST['jenis_brg'];
        $stok_awal = $_POST['stok_awal'];
        $unit = $_POST['unit'];
        $kategori = $_POST['kategori'];

        $cekkodebrg = "SELECT * FROM masterDataBarang WHERE kode_brg='$kode_brg'";
        $hasilcekkodebrg = mysql_query($cekkodebrg);
        $datahasilcekkodebrg = mysql_fetch_array($hasilcekkodebrg);
        $dataKode_Barang = $datahasilcekkodebrg['kode_brg'];
        $data_kategori = $datahasilcekkodebrg['kategori'];
        
        if ($dataKode_Barang == $kode_brg && $data_kategori == $kategori) {
            $pesanError = 'Kode Barang dan Kategori sudah digunakan sebagai'.$data_kategori;
        }else{
            $save = mysql_query("INSERT INTO masterDataBarang(kode_brg,jenis_brg,stok,unit,kategori)VALUES('$kode_brg','$jenis_brg','$stok_awal','$unit','$kategori')")or die(mysql_error());
            if($save) {
                header("Location: ?s=MasterDataBarang");
            } else {
                header("Location: ?");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>::DIT - STOK:</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="img/logo_ITTI.ico">
    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>

<body>
    <!-- topbar starts -->
    <?php include_once 'TopMenu.php'; ?>
    <!-- topbar ends -->
<div class="ch-container">
    <div class="row">
        
        <!-- left menu starts -->
        <?php include_once 'LeftMenu.php'; ?>
        <!--/span-->
        <!-- left menu ends -->

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <div>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="?s=MasterDataBarang">Data Barang</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <form action="" method="post">
                <center>
                    <?php
                            if (isset($pesanError)) {
                            echo '<b style=color:red>' . $pesanError . '</b>';
                            }
                        ?>
                </center>
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well">
                            <h2><i class="glyphicon glyphicon-plus"></i> Tambah Data Barang </h2>
                            <div class="box-icon">
                                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                                <div class="form-group has-success col-md-4">
                                    <label>Kode Barang</label>
                                    <input type="text" class="form-control input-sm" name="kode_brg" placeholder="" required>
                                </div>
                                <div class="form-group has-success col-md-8">
                                    <label>Jenis Barang</label>
                                    <input type="text" class="form-control input-sm" name="jenis_brg" required>
                                </div>

                                <div class="form-group has-success col-md-2">
                                   <label>Stock Awal</label>
                                    <input type="text" class="form-control input-sm" name="stok_awal" required>
                                </div>
                                <div class="form-group has-success col-md-10">
                                    <label>Unit</label>
                                        <select name="unit" class="form-control input-sm" required>
                                            <option value="" disabled selected>Pilih Unit:</option>
                                            <option value="Unit">Unit</option>
                                            <option value="Feet">Feet</option>
                                            <option value="Meter">Meter</option>
                                            <option value="Pcs">Pcs</option>
                                        </select>
                                </div>
                                <div class="form-group has-success">
                                    <label>Kategori</label>
                                        <select name="kategori" class="form-control input-sm" required>
                                            <option value="" disabled selected>Pilih Kategori:</option>
                                            <option value="Spare Part">Spare Part</option>
                                            <option value="Server">Server</option>
                                            <option value="Rusak">Rusak</option>
                                        </select>
                                </div>
                                <button type="submit" class="btn btn-info btn-sm" name="submit">Simpan Barang</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="box col-md-12">
                <div class="box-inner">
                    <div class="box-content">
                        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width="50">Kode Barang</th>
                                    <th width="500">Jenis Barang</th>
                                    <th width="100">Kategori</th>
                                    <th width="75">Unit</th>
                                    <th width="50" style="text-align: center;">Stock</th>
                                    <th>#Opsi#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include_once 'database/connection.php';
                                    $dataDok = mysql_query("SELECT * FROM masterDataBarang ORDER BY id ASC");
                                    $no = 1;
                                    while ($fetchDataDok = mysql_fetch_array($dataDok)){
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $fetchDataDok['kode_brg']; ?></td>
                                        <td><?php echo $fetchDataDok['jenis_brg']; ?></td>
                                        <td><?php echo $fetchDataDok['kategori']; ?></td>
                                        <td><?php echo $fetchDataDok['unit']; ?></td>
                                        <td style="text-align: center;"><?php echo $fetchDataDok['stok']; ?></td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#myModal<?php echo $fetchDataDok['id']; ?>">
                                            <span class="label label-success">Edit</span></a>
                                            <a href="#" data-toggle="modal" data-target="#delete<?php echo $fetchDataDok['id']; ?>">
                                            <span class="label label-danger">Delete</span></a>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal<?php echo $fetchDataDok['id']; ?>" role="dialog">
                                        <form role="form" action="?s=EditMasterBarang" method="POST">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                                            <h3>Edit User</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                                <?php
                                                                    $id = $fetchDataDok['id']; 
                                                                    $query_edit = mysql_query("SELECT * FROM masterDataBarang WHERE id='$id'");
                                                                    while ($row = mysql_fetch_array($query_edit)) {  
                                                                ?>
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                <p>
                                                                    <label class="control-label">Kode Barang</label>
                                                                    <input type="text" class="form-control input-sm" name="kode_brg" value="<?php echo $row['kode_brg']; ?>" required>
                                                                </p>
                                                                <p>
                                                                    <label class="control-label">Jenis Barang</label>
                                                                    <input type="text" class="form-control input-sm" name="jenis_brg" value="<?php echo $row['jenis_brg']; ?>" required>
                                                                </p>
                                                                <p>
                                                                    <label class="control-label">Stok Awal</label>
                                                                    <input type="text" class="form-control input-sm" name="stok" value="<?php echo $row['stok']; ?>" required>
                                                                </p>
                                                                <p>
                                                                    <label class="control-label">Unit</label>
                                                                    <input type="text" class="form-control input-sm" name="unit" value="<?php echo $row['unit']; ?>" required>
                                                                </p>
                                                                <p>
                                                                    <label class="control-label">Ketegori</label>
                                                                    <input type="text" class="form-control input-sm" name="kategori" value="<?php echo $row['kategori']; ?>" required>
                                                                </p>
                                                        </div>
                                                        <div class="modal-footer">  
                                                            <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </form>
                                    </div>
                                    <!-- End Modal -->

                                    <!-- Modal delete-->
                                    <div class="modal fade" id="delete<?php echo $fetchDataDok['id']; ?>" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                        <h3>Apakah anda yakin menghapus ini? </h3>
                                                    </div>
                                                    <div class="modal-footer">  
                                                        <a href="?s=DeleteMasterBarang&id=<?php echo $fetchDataDok['id']; ?>" class="btn btn-danger">Ya</a>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal delete-->
                
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

    <!-- Ad, you can remove it -->
    <div class="row">
        <div class="col-md-9 col-lg-9 col-xs-9 hidden-xs">
            <!-- Charisma Demo 2 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-5108790028230107"
                 data-ad-slot="3193373905"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
    <!-- Ad ends -->

    <?php include_once 'footer.php'; ?>

</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="js/jquery.cookie.js"></script>
<script src='bower_components/moment/min/moment.min.js'></script>
<script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<script src='js/jquery.dataTables.min.js'></script>
<script src="bower_components/chosen/chosen.jquery.min.js"></script>
<script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
<script src="js/jquery.noty.js"></script>
<script src="bower_components/responsive-tables/responsive-tables.js"></script>
<script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<script src="js/jquery.raty.min.js"></script>
<script src="js/jquery.iphone.toggle.js"></script>
<script src="js/jquery.autogrow-textarea.js"></script>
<script src="js/jquery.uploadify-3.1.min.js"></script>
<script src="js/jquery.history.js"></script>
<script src="js/charisma.js"></script>
</body>
</html>