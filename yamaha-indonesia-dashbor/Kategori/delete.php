<?php
include_once "library/inc.seslogin.php";
//ini untuk ngecek, apakah yang akses admin atau petugas
/*if (!$_SESSION['SES_ADMIN'] && !$_SESSION['SES_PETUGAS']){
	echo "<meta http-equiv='refresh' content='0; url=".$baseURL."'>";
	exit;
}*/
//ini digunakan untuk mengambil berdasarkan kode
if (isset($_GET['kode'])){
	$Kode = $_GET['kode'];
//perhatikan nama tabel yang digunakan
$mySql = "DELETE FROM kategori WHERE kd_model='$Kode'";
$myQry = mysqli_query($koneksidb, $mySql);
//menegmbalikan ke folder berikutnya dan pada file data.php
echo "<meta http-equiv='refresh' content='0; url=".$baseURL."Kategori/kategori'>";
}
else{
	echo "<b> Kategori yang dihapus tidak ada</b>";
}
?>