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
<!-- PRINTING-->
<link href="<?php echo $baseURL; ?>assets/css/printing.css" rel="stylesheet">
	<div class="right_col" role="main">
	<div class="">
	<div class="page-title">
	<div class="title_left">
		<h3>General<small>Barang</small></h3>
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
<!-- DIGUNAKAN UNTUK PROSES PENCARIAN BERDASARKAN KATEGORI (DISESUAIKAN DENGAN PENCARIAN) -->
<?php
$filterSQL="";
// SETELAH TOMBOL GO DI KLIK AKAN PROSES SCRIPT SEPERTI INI
$Kat 			= isset($_GET['Kat']) ? $_GET['Kat'] : 'semua';//dari URL
$dataKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $Kat; //dari form
if (trim($dataKategori)=="semua") {
		$filterSQL ="";		
	}
	else {
		$filterSQL="WHERE barang.kd_model='$dataKategori' ";
}
?>
<!--BATAS DIGUNAKAN UNTUK PROSES PENCARIAN
	BERDASARKAN KATEGORI (DISESUAIKAN DENGAN PENCARIAN) -->
	
<!-- FORM PENCARIAN BERDASARKAN KATEGORI-->
<form class="form-horizontal form-label-left" action="<?php $_server['PHP_SELF'];?>"method="post" name="form1" target="_self">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="aaa">Model Piano</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<select id="aaa" class="form-control" name="cmbKategori">
				<option value="semua"></option>
				<?php
				
				$dataSql ="SELECT * FROM kategori ORDER BY kd_model";
				$dataQry = mysqli_query($koneksidb, $dataSql);
				while ($dataRow = mysqli_fetch_array($dataQry)) {
					if ($dataRow['kd_model']== $dataKategori){
						$cek ="selected";

					} else {$cek="";}
					echo "<option value='$dataRow[kd_model]' $cek>$dataRow[nm_model]</option>";
				}
				
				?>
				
			</select>
		</div>
		<input type="submit" class ="btn btn-default" name="btnTampil" value="GO"/>
	</div>
</form>
<!-- BATAS FORM PENCARIAN BERDASARKAN KATEGORI -->
<div class="ln_solid"></div>
<!--DATAGRID BERDASARKAN DATA YANG AKAN KITA TAMPILKAN-->
<table id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th width="23" align="center"><strong>No</strong></th>
			<th width="51"><strong>Kode</strong></th>
			<th width="417"><strong>Cabinet</strong></th>
		 	 
			<th width="70" align="center"><strong>Jumlah</strong></th>
			<th width="100" align="center"><a href="<?php echo $baseURL;?>object/add" target"_self">
				<span class="fa fa-plus-circle"></span> Add Data</a></th>
		</tr>
	</thead>
	<?php
	/* PENCARIAN BERDASARKA DATA DI TABEL*/
	$mySql ="SELECT * FROM barang $filterSQL ORDER BY timestamp DESC, kd_barang DESC";
	$myQry = mysqli_query($koneksidb, $mySql);
	$nomor = $hal;
	//PERULANGAN DATA
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData ['kd_barang'];
		?>
		
	<!--MENAMPILKAN HASIL PENCARIAN DATABASE-->
	<tr>
		<td align="center"><?php echo $nomor;?></td>
		<td><?php echo $myData['kd_barang']?></td>
		<td><?php echo $myData['cabinet']?></td>
		 
		<td align="center"><?php echo $myData['jumlah'];?></td>

		<td align="center">
			<?php if (!$_SESSION['SES_PENGGUNA']):?>
				<a href="<?php echo $baseURL;?>object/edit?kode=<?php echo $Kode; ?>">
					<span class="fa fa-pencil"></span></a>
				<a href="<?php echo $baseURL;?>object/delete?kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Apakah anda yakin ingin menghapus data <?php echo $Kode; ?>')">
					<span class="fa fa-trash"></span></a>
				</td>
				<?php endif;?>
	</tr>              
<?php }?>
<!--BATAS PERULANGAN DATA-->
</table>
<!--BATAS DATAGRID BERDASARKA DATA YANG AKAN KITA TAMPILKAN-->
<!--button print dan excel-->
<div id="section-not-to-print">
	<form action="<?php echo $baseURL;?>report_xls/officer" method="post" name="form2">
			<input type="hidden" name="tglAwal" value="<?php echo $tglAwal; ?>" />
			<input type="hidden" name="tglAkhir" value="<?php echo $tglAkhir; ?>" />
		<button type="button" class="btn btn-succes goPrint">PDF</button>
		<button type="submit" class="btn btn-primary">Excel</button>
	</form>
</div>
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
<script src="<?php echo $baseURL;?>assets/js/moment/moment.min.js"></script>

<script type="text/javascript" src="<?php echo $baseURL;?>assets/others/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $baseURL;?>assets/others/bootstrap-daterangepicker/daterangepicker.css"/>

<!-- Datatables-->
<script>
	pagename='report/officer1';
     $(document).ready(function() {    
    		$('#datatable').DataTable({
					 "columnDefs": [
							{ "orderable": false, "targets": 4 }
			 		 ],    		
					 aLengthMenu: [
									[10, 25, 50, 100, -1],					 				
									[10, 25, 50, 100, "All"]
							]    		
    		});
    		
    		$('.goPrint').click(function(){
					window.print();
				});
				
				$('#txtTanggal').daterangepicker({
						"autoApply": true,
						startDate: '<?php echo $tglAwal; ?>',
    				endDate: '<?php echo $tglAkhir; ?>',
						locale: {
							format: 'DD-MM-YYYY',
							separator: " s/d ",
						},    
				}, function(start, end, label) {
					console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
				});
        
    	});
</script>
</body>
</form>
</body>
