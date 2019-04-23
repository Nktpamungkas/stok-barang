<?php
// $server = mysql_connect('svr4','dit','4dm1n');
$server = mysql_connect('localhost','root','');


if ($server) {
	$serverNote = ' ';

	$database = mysql_select_db('stock');

	if ($database) {
		$databaseNote = ' ';
	}else{
		$databaseNote = 'Tidak terkoneksi dengan database';
	}
}else {
	$serverNote = 'Sambungan server tidak terhubung';
}

echo $database = $serverNote.' '.$databaseNote;
?>