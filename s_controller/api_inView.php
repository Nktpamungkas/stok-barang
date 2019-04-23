<?php
 //Memanggil conn.php yang telah kita buat sebelumnya
 include_once 'database/connection.php';

 $id = $_GET['id'];
 // Syntax MySql untuk melihat semua record yang
 // ada di tabel animal
 $sql = "SELECT * FROM masterDatabarang WHERE id='$id'";
  
 //Execetute Query diatas
 $query = mysql_query($sql);
 while($dt=mysql_fetch_array($query)){
  $item0=$dt['kode_brg'];
  $item=$dt["jenis_brg"];
  $item2=$dt["stok"];
  $item3=$dt["unit"];
  $item4=$dt["kategori"];
 }
 
 //Menampung data yang dihasilkan
 $json = array(
 	'kode_brg' => $item0,
    'jenisbarang' => $item,
    'stokawal' => $item2,
    'unit' => $item3,
    'kategori' => $item4
   );
 
 //Merubah data kedalam bentuk JSON
 header('Content-Type: application/json');
 echo json_encode($json);
?>