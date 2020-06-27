<?php
#konek ke web server lokal
$myHost = "localhost"; //nama server
$myUser = "root";// nama user data base
$myPass = "";//password yang digunakan
$myDbs	= "ymmi";//nama database yang kita buat

//melakukan proses koneksi database
$koneksidb =mysqli_connect($myHost,$myUser,$myPass,$myDbs);
if(!koneksidb) {
	//jika gagal koneksi
	echo "Failed Connection !";
}
?>