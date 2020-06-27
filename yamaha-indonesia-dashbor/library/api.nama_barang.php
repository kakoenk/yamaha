<?php

//die ('ok');
session_start();
#konek ke web server lokal
$myHost = "localhost"; //nama server
$myUser = "root";// nama user data base
$myPass = "";//password yang digunakan
$myDbs	= "ymmi";//nama database yang kita buat

//melakukan proses koneksi database
$koneksidb =mysqli_connect($myHost,$myUser,$myPass,$myDbs);

//include_once "inc.connection.php";
//include_once "inc.seslogin.php";
//include_once "inc.library.php";

$mySql = "SELECT * FROM barang WHERE kd_model='".$_REQUEST['dataModel']."' ORDER BY nm_barang";
$myQry = mysqli_query($koneksidb, $mySql);
$i=0;

while ($myData = mysqli_fetch_array($myQry)){
	$data[$i]['value'] = $myData['kd_barang'];
	$data[$i]['text'] = $myData['nm_barang'];
	$i++;
} 


echo json_encode($data);

?>