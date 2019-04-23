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

        $dateIn = $_POST['dateIn'];
        date_default_timezone_set('Asia/Jakarta');
        $time = date('H:i:s');
        $kode_brg = $_POST['kode_brg'];
        $jenis_brg = $_POST['jenis_brg'];
        $stok_awal = $_POST['stok_awal'];
        $unit = $_POST['unit'];
        $stok_out = $_POST['stok_out'];
        $stokakhir = $stok_awal - $stok_out;
        $pengguna = $_POST['pengguna'];
        $dept = $_POST['dept'];
        $kategori = $_POST['kategori'];
        
        if ($stok_awal >= $stok_out) {
            $save = mysql_query("INSERT INTO out_stok(date_brg,time_brg,kode_brg,jenis_brg,stok_awal,unit,stok_out,stok_akhir,pengguna,dept,kategori)VALUES('$dateIn','$time','$kode_brg','$jenis_brg','$stok_awal','$unit','$stok_out','$stokakhir','$pengguna','$dept','$kategori')")or die(mysql_error());

            $QLastId = mysql_query("SELECT id FROM out_stok ORDER BY id DESC limit 1");
            $fetchId = mysql_fetch_assoc($QLastId);
            $LastId = $fetchId['id'];

            $update = mysql_query("UPDATE masterDataBarang SET stok='$stokakhir' WHERE kode_brg='$kode_brg' and kategori = '$kategori'")or die(mysql_error());
            
            $save_opname = mysql_query("INSERT INTO opname(id_instok,tgl,kode_barang,jenis_barang,stok_awal,unit,masuk,keluar,stok_akhir,kategori) VALUES('$LastId','$dateIn','$kode_brg','$jenis_brg','$stok_awal','$unit','0','$stok_out','$stokakhir','$kategori')")or die(mysql_error());

            if($save && $update) {
                header("Location: ?s=Out");
            } else {
                header("Location: ?");
            }
        }else{
            $pesanError = "Stok keluar tidak boleh melebihi stok awal.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>::DIT - STOK OUT:</title>
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
    <script src="dist/jquery.mask.min.js"></script>
    <script type="text/javascript">
        function proses(){
            var id = document.getElementById("id").value;

            $.get("?s=api_in&id="+id,function(item){
                document.getElementById("kode_brg").value = item.kode_brg;
                document.getElementById("jb").value = item.jenisbarang;
                document.getElementById("sa").value = item.stokawal;
                document.getElementById("unit").value = item.unit;
                document.getElementById("kategori").value = item.kategori;
            });
        }
    </script>

    <link rel="stylesheet" href="chosen/docsupport/prism.css">
    <link rel="stylesheet" href="chosen/chosen.css">
</head>
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
                    <a href="?s=in">Data Barang Masuk</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <form action="" method="post">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well">
                             <h2><i class="glyphicon glyphicon-plus"></i> Tambah Data Barang Keluar</h2>
                            <div class="box-icon">
                                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                                <div class="form-group has-success">
                                    <label>Tanggal Keluar Barang</label>
                                    <input type="Date" class="form-control input-sm" name="dateIn" required>
                                </div>
                                <div class="form-group has-success">
                                    <label>Kode Barang</label>
                                    <?php
                                        include_once 'database/connection.php';

                                        echo "<select name='id' data-placeholder='Choose a Kode Barang...' tabindex='2' class='chosen-select form-control input-sm' id='id' onchange='proses()' required>";
                                        $tampil=mysql_query("SELECT * FROM masterDataBarang WHERE NOT stok = '0' ORDER BY id");
                                        echo "<option value='' disabled selected>Kode Barang:</option>";

                                        while($w=mysql_fetch_array($tampil))
                                        {
                                            echo "<option value='".$w[id]."'>$w[kode_brg] - $w[kategori]</option>";        
                                        }
                                            echo "</select>";
                                    ?>

                                    <input type="hidden" class="form-control input-sm" name="kode_brg" id="kode_brg" >
                                    <label>Note: Kode Barang yang stoknya 0 tidak muncul di out stok.</label>
                                </div>
                                <div class="form-group has-success col-md-6">
                                    <label>Jenis Barang</label>
                                    <input type="text" class="form-control input-sm" name="jenis_brg" id="jb" readonly value="">
                                </div>

                                <div class="form-group has-success col-md-3">
                                    <label>Stock Awal</label>
                                    <input type="text" class="form-control input-sm" name="stok_awal" id="sa" readonly value="">
                                </div>

                                <div class="form-group has-success col-md-3">
                                    <label>Unit</label>
                                    <input type="text" class="form-control input-sm" name="unit" id="unit" readonly value="">
                                </div>

                                <div class="form-group has-success">
                                    <label>
                                        Stock Out 
                                        <?php
                                            if (isset($pesanError)) {
                                            echo '<b style=color:red>' . $pesanError . '</b>';
                                            }
                                        ?>
                                    </label>
                                    <input type="text" class="form-control input-sm" name="stok_out" required>
                                </div>

                                <div class="form-group has-success">
                                    <label>Department</label>
                                        <?php
                                        include_once 'database/connection.php';

                                        echo "<select name='dept' class='form-control input-sm' required>";
                                        $tampil=mysql_query("SELECT * FROM departments");
                                        echo "<option value='' disabled selected>Dept:</option>";

                                        while($w=mysql_fetch_array($tampil))
                                        {
                                            echo "<option value='".$w[code]."'>$w[code] - $w[dept_name]</option>";        
                                        }
                                            echo "</select>";
                                    ?>
                                </div>

                                <div class="form-group has-success">
                                    <label>Pengguna</label>
                                        <select name="pengguna" class="form-control input-sm" required>
                                            <option value="" disabled selected>Pilih Pengguna:</option>
                                            <option value="Pakai">Pakai</option>
                                            <option value="Pinjam">Pinjam</option>
                                            <option value="Jual">Jual</option>
                                        </select>
                                </div>

                                 <div class="form-group has-success">
                                    <label>Kategori</label>
                                    <input type="text" class="form-control input-sm" name="kategori" id="kategori" readonly value="">
                                </div>

                                <div class="form-group">
                                     <button type="submit" class="btn btn-info btn-sm" name="submit">OUT</button>
                                </div>
                        </div>
                    </div>
                </div>

            <div class="box col-md-12">
                <div class="box-inner">
                    <div class="box-content">
                        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width="175">Tanggal</th>
                                    <th width="500">Jenis Barang</th>
                                    <th width="75" style="text-align: center;">Stock Out</th>
                                    <th width="150" style="text-align: center;">Keterangan</th>
                                    <th style="text-align: center;">Keluar Barang Ke</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include_once 'database/connection.php';
                                    $dataDok = mysql_query("SELECT * FROM out_stok");
                                    $no = 1;
                                    while ($fetchDataDok = mysql_fetch_array($dataDok)){
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php $formatdate = date_create($fetchDataDok['date_brg']);
                                                    echo date_format($formatdate, "d M y").', '.$fetchDataDok['time_brg']; ?></td>
                                        <td><?php echo $fetchDataDok['jenis_brg']; ?></td>
                                        <td style="text-align: center;"><?php echo $fetchDataDok['stok_out']; ?></td>
                                        <td style="text-align: left;"><?php echo $fetchDataDok['kategori']; ?></td>
                                        <td>
                                            <?php echo $fetchDataDok['dept']; ?>
                                            <!-- <a href="#" data-toggle="modal" data-target="#myModal<?php echo $fetchDataDok['id']; ?>">
                                            <span class="label label-success">Edit</span></a>
                                            <a href="?s=DeleteMasterTeknisi&id=<?php echo $fetchDataDok['id']; ?>">
                                            <span class="label label-danger">Delete</span></a> -->
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </form>
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

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3>Settings</h3>
                    </div>
                    <div class="modal-body">
                        <p>
                            <label class="control-label" for="inputError1">Stop Progress</label>
                            <input type="date" class="form-control" id="inputError1" name="startprogres" required>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                        <a href="#" class="btn btn-primary" data-dismiss="modal" name="submit">Save changes</a>
                    </div>

            </div>
        </div>
    </div>
    <!-- End Modal -->

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

<script src="chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>