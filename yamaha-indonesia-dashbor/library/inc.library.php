<?php
# pengaturan tanggal komputer
date_default_timezone_set("asia/jakarta");
#fungsi untuk membuat kode otomatis
function buatKode ($tabel, $inisial){
	global $koneksidb;
	$struktur =mysqli_query($koneksidb, "SELECT * FROM $tabel LIMIT 1");
	$field	  =mysqli_fetch_field_direct($struktur,0)->name;
	//membaca panjang kolom kunci cara 1
	$panjang  =mysqli_fetch_field_direct($struktur,0)->length;
	//membaca panjang kolom cara 2
	//$hasil =mysqli_fetch_field($struktur,0);
	//$panjang =$hasil->max_length;
	$qry 	=mysqli_query($koneksidb, "SELECT MAX(".$field.") FROM ".$tabel);
	$row	=mysqli_fetch_array($qry);
	if ($row[0]==""){
		$angka=0;
	}else{
		$angka	=substr($row[0], strlen($inisial));
	}
	$angka++;
	$angka	=strval($angka);
	$tmp	="";
	for ($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++){
		$tmp=$tmp."0";

	}
	return $inisial.$tmp.$angka;
}