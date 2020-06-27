<?php
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

$userLogin = $_SESSION['SES_LOGIN'];
$act	=$_POST['act'];
if($userLogin=='') exit(0);
if($act=='') exit(0);

if($act=='add') {
	$noPengiriman =$_POST['noPengiriman'];
	$edtKode =$_POST['edtKode'];
	$edtJumlah =$_POST['edtJumlah'];
	$edtTerima = $_POST['edtTerima'];
	$keterangan = $_POST['keterangan'];
	if($edtKode=='') exit(0);
	if($edtJumlah=='') exit(0);

	$tmpSql = "UPDATE tmp_penerimaan SET jumlah_terima='$edtTerima',keterangan='$keterangan',kd_penerima='$userLogin' WHERE kd_barang='$edtKode' AND no_pengiriman='$noPengiriman'";

			mysqli_query($koneksidb, $tmpSql) or die(0);
			echo mysqli_insert_id($koneksidb);

} else if($act=='delete'){
	$id=$_POST['id'];
	if($id=='') exit(0);
	$tmpSql= "DELETE FROM tmp_penerimaan WHERE kd_barang='$edtKode' AND no_pengiriman='$noPengiriman'";
	mysli_query($koneksidb, $tmpSql) or die(0);
	echo(1);
}else {
	exit(0);
}
