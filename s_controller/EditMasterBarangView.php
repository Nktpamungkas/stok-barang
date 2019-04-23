<?php
    include_once 'database/connection.php';

    $id = $_POST['id'];
    $kode_brg = $_POST['kode_brg'];
    $jenis_brg = $_POST['jenis_brg'];
    $stok = $_POST['stok'];
    $unit = $_POST['unit'];
    $kategori = $_POST['kategori'];

    //query update
    $query = "UPDATE masterDataBarang SET kode_brg = '$kode_brg', jenis_brg = '$jenis_brg', stok = '$stok', unit = '$unit', kategori = '$kategori' WHERE id = '$id' ";

    if (mysql_query($query)) {
     # credirect ke page index
     header("location: ?s=masterDataBarang"); 
    }
    else{
     echo "ERROR, Missing : ". mysql_error();
    }
?>