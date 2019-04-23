<?php
    include_once 'database/connection.php';

    $id = $_POST['id'];
    $dateIn = $_POST['dateIn'];
    $stok_akhir = $_POST['stok_akhir'];
    $stok_in = $_POST['stok_in'];

    //query update
    $query_in = "UPDATE in_stok SET dateIn = '$dateIn', 
                                          stok_akhir = '$stok_akhir', 
                                          stok_in = '$stok_in', 
                                    WHERE id = '$id' ";

    if (mysql_query($query_in)) {
        # credirect ke page index
        header("location: ?s=In"); 
    }
    else{
        echo "ERROR, Missing : ". mysql_error();
    }
?>