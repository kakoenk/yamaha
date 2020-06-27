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
		<h3>General<small>Petugas</small></h3>
	</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h2>Data Petugas<small></small></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
<!-- BATAS HEADER TITLE-->
<!-- DIGUNAKAN UNTUK PROSES PENCARIAN BERDASARKAN KATEGORI (DISESUAIKAN DENGAN PENCARIAN) -->

<!-- BATAS FORM PENCARIAN BERDASARKAN KATEGORI -->
<div class="ln_solid"></div>
<!--DATAGRID BERDASARKAN DATA YANG AKAN KITA TAMPILKAN-->
<table id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th width="23" align="center"><strong>No</strong></th>
			<th width="23" align="center"><strong>NIK</strong></th>
			<th width="150"><strong>Nama Petugas</strong></th>
			<th width="107"><strong>Bagian</strong></th>
			<th width="107"><strong>No Telephone</strong></th>
			<th width="132">User Name</th>
			<th width="70" align="center"><strong>Level</strong></th>
			<th width="132">Jenis Kelamin</th>
			<th width="132">Alamat</th>
			<th width="100" align="center"><a href="<?php echo $baseURL;?>petugas/add" target"_self">
				<span class="fa fa-plus-circle"></span> Add Data</a></th>
		</tr>
	</thead>
	<?php
	/* PENCARIAN BERDASARKA DATA DI TABEL*/
	$mySql ="SELECT * FROM petugas ORDER BY kd_petugas";
	$myQry = mysqli_query($koneksidb, $mySql);
	$nomor = $hal;
	//PERULANGAN DATA
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData ['kd_petugas'];
		?>
		
	<!--MENAMPILKAN HASIL PENCARIAN DATABASE-->
	<tr>
		<td align="center"><?php echo $nomor;?></td>
		<td><?php echo $myData['kd_petugas']?></td>
		<td><?php echo $myData['nm_petugas']?></td>
		<td><?php echo $myData['kd_bagian']?></td>
		<td><?php echo $myData['no_telepon']?></td>
		<td align="center"><?php echo $myData['username'];?></td>
		<td><?php echo $myData['level']?></td>
		<td><?php echo $myData['jns_kelamin']?></td>
		<td><?php echo $myData['alamat']?></td>

		<td align="center">
			<?php if (!$_SESSION['SES_PENGGUNA']):?>
				<a href="<?php echo $baseURL;?>petugas/edit?kode=<?php echo $Kode; ?>">
					<span class="fa fa-pencil"></span></a>
				<a href="<?php echo $baseURL;?>petugas/delete?kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Apakah anda yakin ingin menghapus data <?php echo $Kode; ?>')">
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
	pagename='petugas/data';
	$(document).ready(function(){
		$('#datatable').dataTables({
			"columnDefs": [
			{"orderable": false, "targets": 3}]
		});
	});
</script>
</body>
</form>
</body>
