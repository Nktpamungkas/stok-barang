<?php 
    include_once 'database/connection.php';
    $id = $_GET['id'];

    $DeleteBA = mysql_query("DELETE from in_stok WHERE id ='$id'");
    if($DeleteBA) {
        header("Location: ?s=in");
    } else {
        echo "QUERY ERROR";
    }
?>