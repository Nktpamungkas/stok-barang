<!DOCTYPE html>
<html>
<head>
    <title>::DIT - Laporan Stock Spare Part:</title>
    <link rel="shortcut icon" href="img/logo_ITTI.ico">
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">
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
</head>
<style>
    body {
      background: white; 
    }
    page[size="A4"] {
      background: white;
      width: 21cm;
      height: 29.7cm;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }
  
    @media print {
      body, page[size="A4"] {
        margin: 0;
        box-shadow: 0;
      }
    }
    table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.1px;
            text-align: center;
            font-size: 12px;
        }
        table#t01 tr:nth-child(even) {
            background-color: white;
        }
        table#t01 tr:nth-child(odd) {
           background-color: white;
        }
        table#t01 th {
            background-color: black;
            color: white;
        }
</style>
<body>
<br>
<center>
    <a href="?s=Print&kategori=<?php echo $kategori = $_POST['kategori']; ?>&tgl1=<?php echo $tgl1 = $_POST['tgl1']; ?>&tgl2=<?php echo $tgl2 = $_POST['tgl2']; ?>&nama=<?php echo $nama = $_POST['nama']; ?>" class="btn btn-default btn-sm" target="BLANK">Print</a>
    <a href="?s=ExportToExcell&kategori=<?php echo $kategori = $_POST['kategori']; ?>&tgl1=<?php echo $tgl1 = $_POST['tgl1']; ?>&tgl2=<?php echo $tgl2 = $_POST['tgl2']; ?>&nama=<?php echo $nama = $_POST['nama']; ?>" class="btn btn-success btn-sm">Export To Excell</a><br>
</center>

<div class="box col-md-12">
    <div class="box-inner">
        <div class="box-content">
        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
            <label style="font-weight: bold; font-size: 14px;">LAPORAN STOCK <?php echo $_POST['kategori']; ?></label><br>
            <label style="font-size: 14px;"><u>DEPARTEMEN DIT</u></label><br>
            <label style="font-weight: bold; font-size: 14px;">Periode : 
                    <?php 
                    $tgl1 = date_create($_POST['tgl1']);
                    echo date_format($tgl1, "d M ");
                    ?> - 
                    <?php 
                    $tgl2 = date_create($_POST['tgl2']);
                    echo date_format($tgl2, "d M Y");
                    ?>
                    <br>
            <thead>
            <tr>
                <td width="50">NO</td>
                <td width="150">KODE BARANG</td>
                <td width="300">JENIS BARANG</td>
                <td width="75">STOK AWAL</td>
                <td width="75">UNIT</td>
                <td width="75">MASUK</td>
                <td width="75">KELUAR</td>
                <td width="75">UNIT</td>
                <td width="75">STOK AKHIR</td>
                <td width="200">CATATAN</td>
            </tr>
            </thead>
                        
            <tr>
                <?php
                    include_once 'database/connection.php';
                    $tanggal1 = date_create($_POST['tgl1']);
                    $tgl1 = date_format($tanggal1, "Y-m-d");

                    $tanggal2 = date_create($_POST['tgl2']);
                    $tgl2 = date_format($tanggal2, "Y-m-d");

                    $kategori = $_POST['kategori'];

                    if ($kategori == "ALL") {
                        $dataDok = mysql_query("SELECT  IFNULL(b.id, a.id) AS id,
                                                        a.kode_brg AS kode_brg,
                                                        a.jenis_brg AS jenis_brg,
                                                        IFNULL( b.stok_awal, a.stok ) AS stok_awal,
                                                        a.unit AS unit,
                                                        IFNULL(SUM( b.masuk ), '0') AS masuka, 
                                                        IFNULL(SUM( b.keluar ), '0') AS keluara,
                                                        a.unit AS unit,
                                                        IFNULL(b.stok_awal + SUM( b.masuk ) - SUM( b.keluar ), a.stok) AS stok_akhir 
                                                    FROM
                                                        masterdatabarang a
                                                        LEFT JOIN ( SELECT * FROM opname b WHERE b.tgl BETWEEN '$tgl1' AND '$tgl2' ) b ON a.kode_brg = b.kode_barang 
                                                    GROUP BY
                                                        a.kode_brg,
                                                        b.kode_barang 
                                                    ORDER BY
                                                        a.kode_brg") or die('Error:'.mysql_error());
                    } else {
                        $dataDok = mysql_query("SELECT  IFNULL(b.id, a.id) AS id,
                                                        a.kode_brg AS kode_brg,
                                                        a.jenis_brg AS jenis_brg,
                                                        IFNULL( b.stok_awal, a.stok ) AS stok_awal,
                                                        a.unit AS unit,
                                                        IFNULL(SUM( b.masuk ), '0') AS masuka, 
                                                        IFNULL(SUM( b.keluar ), '0') AS keluara,
                                                        a.unit AS unit,
                                                        IFNULL(b.stok_awal + SUM( b.masuk ) - SUM( b.keluar ), a.stok) AS stok_akhir
                                                    FROM
                                                        masterdatabarang a
                                                        LEFT JOIN ( SELECT * FROM opname b WHERE b.tgl BETWEEN '$tgl1' AND '$tgl2' ) b ON a.kode_brg = b.kode_barang 
                                                    WHERE a.kategori = '$kategori'
                                                    GROUP BY
                                                        a.kode_brg,
                                                        b.kode_barang
                                                    ORDER BY
                                                        a.kode_brg") or die('Error:'.mysql_error());
                    }
                    $no = 1;
                    while ($fetchData = mysql_fetch_array($dataDok)){
                ?>
                <td style="text-align: center;"><?php echo $no++; ?></td>
                <td style="text-align: left;"><?php echo $fetchData['kode_brg']; ?></td>
                <td style="text-align: left;"><?php echo $fetchData['jenis_brg']; ?></td>
                <td style="text-align: center;"><?php echo $fetchData['stok_awal']; ?></td>
                <td style="text-align: center;"><?php echo $fetchData['unit']; ?></td>
                <td style="text-align: center;"><?php echo $fetchData['masuka']; ?></td>
                <td style="text-align: center;"><?php echo $fetchData['keluara']; ?></td>
                <td style="text-align: center;"><?php echo $fetchData['unit']; ?></td>
                <td style="text-align: center;"><?php echo $fetchData['stok_akhir']; ?></td>
                <td style="text-align: center;"></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
            <tr>
                <th colspan="2" width="300"></th>
                <th colspan="2" width="150">DIBUAT OLEH</th>
                <th colspan="3" width="150">DIPERIKSA OLEH</th>
                <th colspan="3" width="350">DISETUJUI OLEH</th>
            </tr>
            <tr>
                <td colspan="2" width="300" style="text-align: left;">NAMA</td>
                <td colspan="2" width="150" style="text-align: center;"><?php $nama = $_POST['nama'];
                                            echo strtoupper($nama); ?></td>
                <td colspan="3" width="150"></td>
                <td colspan="3" width="350" style="text-align: center;">BINTORO</td>
            </tr>
            <tr>
                <td colspan="2" width="300" style="text-align: left;">JABATAN</td>
                <td colspan="2" width="150" style="text-align: center;">STAF</td>
                <td colspan="3" width="150"></td>
                <td colspan="3" width="350" style="text-align: center;">ASISTEN MANAGER</td>
            </tr>
            <tr>
                <td colspan="2" width="300" style="text-align: left;">TANGGAL</td>
                <td colspan="2" width="150" style="text-align: center;"><?php echo Date('d-M-Y'); ?></td>
                <td colspan="3" width="150"></td>
                <td colspan="3" width="350" style="text-align: center;"><?php echo Date('d-M-Y'); ?></td>
            </tr>
            <tr>
                <td colspan="2" width="300"  tyle="text-align: left;" valign="top">TANDA TANGAN</td>
                <td colspan="2" width="150"></td>
                <td colspan="3" width="150"></td>
                <td colspan="3" width="350" height="50"></td>
            </tr>
        </table>
        </div>
    </div>
</div>

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