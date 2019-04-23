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
if (isset($_POST['submit'])) {
    include_once 'database/connection.php';

    $dateIn = $_POST['dateIn'];
    date_default_timezone_set('Asia/Jakarta');
    $time = date('H:i:s');
    $kode_brg = $_POST['kode_brg'];
    $jenis_brg = $_POST['jenis_brg'];
    $stok_awal = $_POST['stok_awal'];
    $unit = $_POST['unit'];
    $stok_in = $_POST['stok_in'];

    $stokakhir = $stok_awal + $stok_in;

    $kondisi = $_POST['kondisi'];
    $dept = $_POST['dept'];
    $kategori = $_POST['kategori'];

    $save = mysql_query("INSERT INTO in_stok(date_brg,time_brg,kode_brg,jenis_brg,stok_awal,unit,stok_in,stok_akhir,kondisi,dept,kategori)
        VALUES('$dateIn','$time','$kode_brg','$jenis_brg','$stok_awal','$unit','$stok_in','$stokakhir','$kondisi','$dept','$kategori')") or die(mysql_error());

    $QLastId = mysql_query("SELECT id FROM in_stok ORDER BY id DESC limit 1");
    $fetchId = mysql_fetch_assoc($QLastId);
    $LastId = $fetchId['id'];
    
    $update = mysql_query("UPDATE masterDataBarang SET stok='$stokakhir' WHERE kode_brg='$kode_brg' AND kategori = '$kategori'") or die(mysql_error());

    $save_opname = mysql_query("INSERT INTO opname(id_instok,tgl,kode_barang,jenis_barang,stok_awal,unit,masuk,keluar,stok_akhir,kategori) VALUES('$LastId','$dateIn','$kode_brg','$jenis_brg','$stok_awal','$unit','$stok_in','0','$stokakhir','$kategori')") or die(mysql_error());

    if ($save && $update) {
        header("Location: ?s=in");
    } else {
        header("Location: ?");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>::DIT - STOK IN:</title>
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
                             <h2><i class="glyphicon glyphicon-plus"></i> Tambah Data Barang Masuk</h2>
                            <div class="box-icon">
                                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                                <div class="form-group has-success">
                                    <label>Tanggal Masuk Barang</label>
                                    <input type="Date" class="form-control input-sm" name="dateIn" required>
                                </div>
                                <div class="form-group has-success">
                                    <label>Kode Barang</label>
                                    <?php
                                        include_once 'database/connection.php';

                                        echo "<select name='id' data-placeholder='Choose a Kode Barang...' tabindex='2' class='chosen-select form-control input-sm' id='id' onchange='proses()' required>";
                                        $tampil = mysql_query("SELECT * FROM masterDataBarang ORDER BY id");
                                        echo "<option value='' disabled selected>Kode Barang:</option>";

                                        while ($w = mysql_fetch_array($tampil)) {
                                            echo "<option value='" . $w[id] . "'>$w[kode_brg] - $w[kategori]</option>";
                                        }
                                        echo "</select>";
                                    ?>

                                    <input type="hidden" class="form-control input-sm" name="kode_brg" id="kode_brg" >

                                </div>
                                <div class="form-group has-success col-md-6">
                                    <label>Jenis Barang</label>
                                    <input type="text" class="form-control input-sm" name="jenis_brg" id="jb" value="" readonly>
                                </div>

                                <div class="form-group has-success col-md-3">
                                   <label>Stock Awal</label>
                                    <input type="text" class="form-control input-sm" name="stok_awal" id="sa" value="" readonly>
                                </div>

                                <div class="form-group has-success col-md-3">
                                    <label>Unit</label>
                                    <input type="text" class="form-control input-sm" name="unit" id="unit" value="" readonly>
                                </div>

                                <div class="form-group has-success">
                                   <label>Stock Masuk</label>
                                    <input type="text" class="form-control input-sm" name="stok_in" required>
                                </div>

                                <div class="form-group has-success">
                                    <label>Department</label>
                                        <?php
                                        include_once 'database/connection.php';

                                        echo "<select name='dept' class='form-control input-sm' required>";
                                        $tampil = mysql_query("SELECT * FROM departments");
                                        echo "<option value='' disabled selected>Dept:</option>";

                                        while ($w = mysql_fetch_array($tampil)) {
                                            echo "<option value='" . $w[code] . "'>$w[code] - $w[dept_name]</option>";
                                        }
                                        echo "</select>";
                                        ?>
                                </div>

                                <div class="form-group has-success">
                                    <label>Kondisi</label>
                                    <select name="kondisi" class="form-control input-sm" required>
                                        <option value="" disabled selected>Pilih Kondisi:</option>
                                        <option value="Baru">Baru</option>
                                        <option value="Bekas">Bekas</option>
                                        <option value="Rusak">Rusak</option>
                                    </select>
                                </div>

                                <div class="form-group has-success">
                                    <label>Kategori</label>
                                    <input type="text" class="form-control input-sm" name="kategori" id="kategori" value="" readonly>
                                </div>
                                <div class="form-group">
                                     <button type="submit" class="btn btn-info btn-sm" name="submit">IN</button>
                                </div>
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
                                    <th width="175">Tanggal</th>
                                    <th width="500">Jenis Barang</th>
                                    <th width="75" style="text-align: center;">Stock Masuk</th>
                                    <th width="150" style="text-align: center;">Keterangan</th>
                                    <th style="text-align: center;">Masuk Barang Dari</th>
                                    <th width="150">#Opsi#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include_once 'database/connection.php';
                                $dataDok = mysql_query("SELECT id,date_brg as tgl, time_brg as timebrg, jenis_brg as jenis, stok_in as stokin, kategori as kategori, dept FROM in_stok ORDER BY date_brg ASC");
                                $no = 1;
                                while ($fetchDataDok = mysql_fetch_array($dataDok)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php $formatdate = date_create($fetchDataDok['tgl']);
                                            echo date_format($formatdate, "d M y") . ', ' . $fetchDataDok['timebrg']; ?></td>
                                        <td><?php echo $fetchDataDok['jenis']; ?></td>
                                        <td style="text-align: center;"><?php echo $fetchDataDok['stokin']; ?></td>
                                        <td style="text-align: left;"><?php echo $fetchDataDok['kategori']; ?></td>
                                        <td><?php echo $fetchDataDok['dept']; ?></td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#myModal<?php echo $fetchDataDok['id']; ?>">
                                            <span class="label label-success">Edit</span></a>
                                            <a href="#" data-toggle="modal" data-target="#delete<?php echo $fetchDataDok['id']; ?>">
                                            <span class="label label-danger" title="Delete stok masuk">Delete</span></a>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal<?php echo $fetchDataDok['id']; ?>" role="dialog">
                                        <form role="form" action="?s=EditInStok" method="POST">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                        <h3>Edit Stok Masuk</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                            $id = $fetchDataDok['id']; 
                                                            $query_edit = mysql_query("SELECT a.id AS id,
                                                                                              a.date_brg AS date_brg,
                                                                                              a.kode_brg AS kode_brg,
                                                                                              a.jenis_brg AS jenis_brg,
                                                                                              a.kategori AS kategori,
                                                                                              b.stok AS stok,
                                                                                              a.stok_in AS stok_in,
                                                                                              a.dept AS dept
                                                                                        FROM in_stok a LEFT JOIN ( SELECT * FROM masterdatabarang b ) b 
                                                                                            ON a.kode_brg = b.kode_brg WHERE a.id = '$id'");
                                                            $row = mysql_fetch_assoc($query_edit)  
                                                        ?>
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                        <p>
                                                            <label class="control-label">Tgl Masuk Barang</label>
                                                            <input type="date" class="form-control input-sm" name="dateIn" value="<?php echo $row['date_brg']; ?>" required>
                                                        </p>
                                                        <p>
                                                            <label class="control-label">Kode Barang</label>
                                                            <input type="text" class="form-control input-sm" value="<?php echo $row['kode_brg']; ?>" disabled>
                                                        </p>
                                                        <p>
                                                            <label class="control-label">Jenis Barang</label>
                                                            <input type="text" class="form-control input-sm" value="<?php echo $row['jenis_brg']; ?>" disabled>
                                                        </p>
                                                        <p>
                                                            <label class="control-label">Ketegori</label>
                                                            <input type="text" class="form-control input-sm" value="<?php echo $row['kategori']; ?>" disabled>
                                                        </p>
                                                        <p>
                                                            <label class="control-label">Stok Masuk</label>
                                                            <input type="text" class="form-control input-sm" name="stok_in" value="<?php echo $row['stok_in']; ?>" required>
                                                        </p>
                                                        <p>
                                                            <label class="control-label">Stok Akhir</label>
                                                            <input type="text" class="form-control input-sm" name="stok_akhir" value="<?php echo $row['stok']; ?>" required>
                                                        </p>
                                                        <p>
                                                            <label class="control-label">masuk Barang dari</label>
                                                            <input type="text" class="form-control input-sm" value="<?php echo $row['dept']; ?>" disabled>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">  
                                                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
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

<script src="chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>