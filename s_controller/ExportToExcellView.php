<!DOCTYPE html>
<html>
<head>
    <title>::DIT - Laporan Stock Spare Part:</title>
    <link rel="shortcut icon" href="img/logo_ITTI.ico">
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
<?php 
    include_once 'database/connection.php';
    $tgl1 = date_create($_GET['tgl1']);
    $tanggal1 =  date_format($tgl1, "d M Y");

    $tgl2 = date_create($_GET['tgl2']);
    $tanggal2 =  date_format($tgl2, "d M Y");

    header("content-type:application/vnd-ms-excel");
    header("content-disposition:attachment;filename=Laporan Stok ( ". $tanggal1." - ".$tanggal2.").xls");
?>
<!-- <page size="A4">  -->
    <table width="100%" border="1">
        <label style="font-weight: bold; font-size: 12px;">LAPORAN STOCK <?php echo $_GET['kategori']; ?></label><br>
        <label style="font-size: 12px;"><u>DEPARTEMEN DIT</u></label><br>
        <label style="font-weight: bold; font-size: 12px;">Periode : 
                <?php 
                $tgl1 = date_create($_GET['tgl1']);
                echo date_format($tgl1, "d M ");
                ?> - 
                <?php 
                $tgl2 = date_create($_GET['tgl2']);
                echo date_format($tgl2, "d M Y");
                ?>
                <br>
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
        
        <tr>
            <?php
                include_once 'database/connection.php';
                $tanggal1 = date_create($_GET['tgl1']);
                $tgl1 = date_format($tanggal1, "Y-m-d");

                $tanggal2 = date_create($_GET['tgl2']);
                $tgl2 = date_format($tanggal2, "Y-m-d");

                $kategori = $_GET['kategori'];

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
    <table width="100%" border="1">
        <tr>
            <th colspan="2" width="300"></th>
            <th colspan="2" width="150">DIBUAT OLEH</th>
            <th colspan="3" width="150">DIPERIKSA OLEH</th>
            <th colspan="3" width="350">DISETUJUI OLEH</th>
        </tr>
        <tr>
            <td colspan="2" width="300" style="text-align: left;">NAMA</td>
            <td colspan="2" width="150" style="text-align: center;"><?php $nama = $_GET['nama'];
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
<!-- </page> -->
</body>
</html>