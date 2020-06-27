<?php if (!defined('OFFDIRECT')) include '../error404.php';?>
<body class="nav-md">
<div class="container body">
<div class="main_container">

<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include "menu.php";
include "base_template_topnav.php";
?>
<!--HEADER TITLE-->
<link href="<?php echo $baseURL;?>assets/other/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $baseURL;?>assets/other/datables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<div class="right_col" role="main">
	<div class="">
	<div class="page-title">
	<div class="title_left">
		<h3>Pengiriman</h3>
	</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h2>Data Barang<small></small></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		
<!-- BATAS HEADER TITLE-->
<!-- DIGUNAKAN UNTUK PROSES PENCARIAN BERDASARKAN model (DISESUAIKAN DENGAN PENCARIAN) -->
<?php
$filterSQL="";
// SETELAH TOMBOL GO DI KLIK AKAN PROSES SCRIPT SEPERTI INI
$Kat 			= isset($_GET['Kat']) ? $_GET['Kat'] : 'semua';//dari URL
$databagian 	= isset($_POST['cmbbagian']) ? $_POST['cmbbagian'] : $Kat; //dari form
if (trim($databagian)=="semua") {
		$filterSQL ="";
	}
	else {
		$filterSQL="WHERE st_barang.kd_bagian='$databagian' ";
}
?>
<!--BATAS DIGUNAKAN UNTUK PROSES PENCARIAN
	BERDASARKAN MODEL (DISESUAIKAN DENGAN PENCARIAN) -->

<!-- FORM PENCARIAN BERDASARKAN MODEL-->
<form class="form-horizontal form-label-left" action="<?php $_server['PHP_SELF'];?>"method="post" name="form1" target="_self">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="aaa">Model Piano</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<select id="aaa" class="form-control" name="cmbbagian">
				<option value="semua"></option>
				<?php

				$dataSql ="SELECT * FROM bagian ORDER BY kd_bagian";
				$dataQry = mysqli_query($koneksidb, $dataSql);
				while ($dataRow = mysqli_fetch_array($dataQry)) {
					if ($dataRow['kd_bagian']== $databagian){
						$cek ="selected";

					} else {$cek="";}
					echo "<option value='$dataRow[kd_bagian]' $cek>$dataRow[nm_bagian]</option>";
				}

				?>

			</select>
		</div>
		<input type="submit" class ="btn btn-default" name="btnTampil" value="GO"/>
	</div>
</form>
<!-- BATAS FORM PENCARIAN BERDASARKAN model -->
<div class="ln_solid"></div>
<!--DATAGRID BERDASARKAN DATA YANG AKAN KITA TAMPILKAN-->
<table id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th><strong>No</strong></th>
			<th><strong>Kode</strong></th>
			<th><strong>Tanggal Pengiriman</strong></th>
			<th><strong>Devisi Bagian</strong></th>
			<th><strong>Jumlah</strong></th>
			<th><strong>Tanggal entry</strong></th>
			<th><a href="<?php echo $baseURL;?>procurement/add" target"_self">
				<span class="fa fa-plus-circle"></span> Add Data</a></th>
		</tr>
	</thead>
	<?php
	/* PENCARIAN BERDASARKA DATA DI TABEL*/
	$mySql ="SELECT a.no_pengiriman, a.tgl_pengiriman, b.nm_bagian,a.tanggal, a.total FROM pengiriman a LEFT JOIN bagian b ON a.nm_bagian=b.kd_bagian";
	$myQry = mysqli_query($koneksidb, $mySql);
	$nomor = $hal;
	//PERULANGAN DATA
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData ['no_pengiriman'];
		?>

	<!--MENAMPILKAN HASIL PENCARIAN DATABASE-->
	<tr>
		<td align="center"><?php echo $nomor;?></td>
		<td><?php echo $myData['no_pengiriman']?></td>
		<td><?php echo $myData['tgl_po']?></td>
		<td><?php echo $myData['nm_bagian']?></td>
		<td align="center"><?php echo $myData['total']?></td>
		<td><?php echo $myData['tanggal']?></td>
		<td align="center">
			<?php if (!$_SESSION['SES_PENGGUNA']):?>
				<a href="<?php echo $baseURL;?>procurement/edit?kode=<?php echo $Kode; ?>">
					<span class="fa fa-pencil"></span></a>
				<a href="<?php echo $baseURL;?>procurement/delete?kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Apakah anda yakin ingin menghapus data <?php echo $Kode; ?>')">
					<span class="fa fa-trash"></span></a>
				</td>
				<?php endif;?>
	</tr>
<?php }?>
<!--BATAS PERULANGAN DATA-->
</table>
<!--BATAS DATAGRID BERDASARKA DATA YANG AKAN KITA TAMPILKAN-->
</div>
</div>
</div>
</div>
</div>
</div>

<?php include "base_template_footer.php";?>
</div>
</div>
<!--Datatables PEMBENTUKAN TABLE BERDASARKAN DATABASE-->
<script src="<?php echo $baseURL;?>assets/others/datables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $baseURL;?>assets/others/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $baseURL;?>assets/others/dataTables.net-buttons/js/dataTables.bootstrap.buttons.min.js"></script>

<!-- Datatables-->
<script>
	pagename='procurement/data';
	$(document).ready(function(){
		var tbl = $('#datatable').DataTable({
		"columnDefs": [
		{"orderable": false, "targets": 4 },
		{"visible": false, "searchable": false }
		],
		"paging": true,
		"searching": true,
		"info": true,
	});
</script>
</body>
</form>
</body>
