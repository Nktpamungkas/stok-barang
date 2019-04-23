<?php 
    include_once 'database/connection.php';
    $id = $_GET['id'];

    $DeleteBA = mysql_query("DELETE from masterdatabarang WHERE id ='$id'");
    if($DeleteBA) {
        header("Location: ?s=MasterDataBarang");
    } else {
        echo "QUERY ERROR";
    }
?>