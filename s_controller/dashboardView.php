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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>::DIT | Stock Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">

    <!-- The styles -->
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

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/logo_ITTI.ico">

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

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <div>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <li>
                        <a href="?s=dashboard">Dashboard</a>
                    </li>
                </ul>
            </div>

            <div class=" row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="?s=masterDataBarang" data-toggle="tooltip" title="<?php
                                include_once 'database/connection.php';

                                $totalStok = "SELECT count(*) AS totalStok FROM masterDataBarang";
                                $hasiltotalStok = mysql_query($totalStok);
                                $datahasiltotalStok = mysql_fetch_array($hasiltotalStok);
                                $total = $datahasiltotalStok['totalStok']; 

                                echo $total;
                            ?> new Stok." class="well top-block" href="#">
                        <i class="glyphicon glyphicon-list-alt blue"></i>

                        <div>Total Stok</div>
                        <div>
                            <?php
                                include_once 'database/connection.php';

                                $totalStok = "SELECT count(*) AS totalStok FROM masterDataBarang";
                                $hasiltotalStok = mysql_query($totalStok);
                                $datahasiltotalStok = mysql_fetch_array($hasiltotalStok);
                                $total = $datahasiltotalStok['totalStok']; 

                                echo $total;
                            ?>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="?s=in" data-toggle="tooltip" title="<?php
                                include_once 'database/connection.php';

                                $totalStok = "SELECT count(*) AS totalStok FROM in_stok";
                                $hasiltotalStok = mysql_query($totalStok);
                                $datahasiltotalStok = mysql_fetch_array($hasiltotalStok);
                                $total = $datahasiltotalStok['totalStok']; 

                                echo $total;
                            ?> new in." class="well top-block" href="#">
                        <i class="glyphicon glyphicon-hand-left green"></i>

                        <div>IN</div>
                        <div>
                            <?php
                                include_once 'database/connection.php';

                                $totalStok = "SELECT count(*) AS totalStok FROM in_stok";
                                $hasiltotalStok = mysql_query($totalStok);
                                $datahasiltotalStok = mysql_fetch_array($hasiltotalStok);
                                $total = $datahasiltotalStok['totalStok']; 

                                echo $total;
                            ?>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="?s=out" data-toggle="tooltip" title="<?php
                                include_once 'database/connection.php';

                                $totalStok = "SELECT count(*) AS totalStok FROM out_stok";
                                $hasiltotalStok = mysql_query($totalStok);
                                $datahasiltotalStok = mysql_fetch_array($hasiltotalStok);
                                $total = $datahasiltotalStok['totalStok']; 

                                echo $total;
                            ?> new out." class="well top-block" href="#">
                        <i class="glyphicon glyphicon-hand-right yellow"></i>

                        <div>OUT</div>
                        <div>
                            <?php
                                include_once 'database/connection.php';

                                $totalStok = "SELECT count(*) AS totalStok FROM out_stok";
                                $hasiltotalStok = mysql_query($totalStok);
                                $datahasiltotalStok = mysql_fetch_array($hasiltotalStok);
                                $total = $datahasiltotalStok['totalStok']; 

                                echo $total;
                            ?>
                        </div>
                    </a>
                </div>

            </div>

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well">
                            <h2><i class="glyphicon glyphicon-info-sign"></i> DATA STOK</h2>
                        </div>
                        <div class="box-content row">
                            <div class="col-lg-12">
                                <div class="box-content">
                                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th width="500">Jenis Barang</th>
                                                <th width="75" style="text-align: center;">Stock</th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include_once 'database/connection.php';
                                                $dataDok = mysql_query("SELECT * FROM masterDataBarang");
                                                $no = 1;
                                                while ($fetchDataDok = mysql_fetch_array($dataDok)){
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $fetchDataDok['jenis_brg']; ?></td>
                                                    <td style="text-align: center;"><?php echo $fetchDataDok['stok']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                     </table>
                                </div>
                            </div>
                        </div>
                        <!-- end of table -->

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
    <!-- Ad ends -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Settings</h3>
                </div>
                <div class="modal-body">
                    <p>Here settings can be configured...</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Save changes</a>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>

</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='bower_components/moment/min/moment.min.js'></script>
<script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='js/jquery.dataTables.min.js'></script>

<!-- select or dropdown enhancer -->
<script src="bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>


</body>
</html>
