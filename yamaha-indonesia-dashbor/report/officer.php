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
<!--HEADER TITLE BERMASALAH OTHERS -->
<link href="<?php echo $baseURL;?>assets/others/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $baseURL;?>assets/others/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<!-- PRINTING-->
<link href="<?php echo $baseURL; ?>assets/css/printing.css" rel="stylesheet">
	<div class="right_col" role="main" id="section-to-print">
	<div class="">
	<div class="page-title section-not-to-print">
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
#deklarasi tanggal
$filterSQL = "";
$tglAwal = "01-".date('m-Y');
$tglAkhir = date('d-m-Y');

#SET TANGGAL SEKARANG
$tglAwal = isset($_POST['txtTanggalAwal']) ? $_POST['txtTanggalAwal'] : $tglAwal;
$tglAkhir = isset($_POST['txtTanggalAkhir']) ? $_POST['txtTanggalAkhir'] : $tglAkhir; 

if(isset($_REQUEST['txtTanggal'])){
list($tglAwal,$tglAkhir) = explode(' s/d ', trim($_REQUEST['txtTanggal']));
}
//jika filter tombol tanggal tampil diklik
$filterSQL = "WHERE (DATE_FORMAT(`timestamp`, '%d-%m-%Y') BETWEEN '".($tglAwal)."' AND '".($tglAkhir)."')";
	?>

<form action ="" method ="post" name="form1" class="form-horizontal form-label-left" id="section-not-to-print">
	<div class="form-group">	
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="aaa">Periode</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<div class="controls">
					<div class="input-prepend input-group">
						<span class="add-on input-group-addon">
							 <i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							 
							<input type="text" name="txtTanggal" id="txtTanggal" class="form-control" value="" />
						</div>
					</div>
				</div>
			</div>
			<input name="btnTampil" class="btn btn-succes" type="submit" value="submit"/>
		</div>
	</form>

	<div id="only-on-print">
		<h4>Periode: <?php echo "$tglAwal s/d $tglAkhir" ;?></h4>
	</div>

<!--BATAS DIGUNAKAN UNTUK PROSES PENCARIAN
	BERDASARKAN KATEGORI (DISESUAIKAN DENGAN PENCARIAN) -->
	
<!-- FORM PENCARIAN BERDASARKAN KATEGORI-->
<!-- BATAS FORM PENCARIAN BERDASARKAN KATEGORI -->
<table id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th width="23" align="center"><strong>No</strong></th>
			<th width="150"><strong>No Pengiriman</strong></th>
			<th width="150"><strong>Tanggal Kirim</strong></th>
			<th width="150"><strong>Pengirim</strong></th>
			<th width="150"><strong>Penerima</strong></th>
			<th width="150"><strong>Kode Barang</strong></th>
			<th width="200"><strong>Nama Barang</strong></th>
			<th width="150"><strong>Model Piano</strong></th>			
			<th width="150"><strong>Jumlah Kirim</strong></th>
			<th width="150"><strong>Jumlah Terima</strong></th>
			<th width="300"><strong>Keterangan</strong></th>		 	 
		</tr>
	</thead>
	<?php

	$mySql ="SELECT a.no_pengiriman, a.tgl_po, a.kd_pengirim, a.kd_penerima, a.kd_barang, a.nm_barang, d.nm_model, a.pengirim, a.penerima, a.jumlah, a.jumlah_terima, a.keterangan 
		FROM tmp_penerimaan a 
		LEFT JOIN bagian b ON b.kd_bagian=a.pengirim 
		LEFT JOIN barang c ON c.kd_barang=a.kd_barang 
		LEFT JOIN model d ON d.kd_model=c.kd_model
		LEFT JOIN petugas e ON e.kd_petugas=a.kd_pengirim WHERE jumlah_terima is not null AND a.jumlah!=a.jumlah_terima";
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
		<td><?php echo $myData['no_pengiriman']?></td>
		<td><?php echo $myData['tgl_po']?></td>
		<td><?php echo $myData['kd_pengirim']?></td>
		<td><?php echo $myData['kd_penerima']?></td>
		<td><?php echo $myData['kd_barang']?></td>
		<td><?php echo $myData['nm_barang']?></td>
		<td><?php echo $myData['nm_model']?></td>
		<td><?php echo $myData['jumlah']?></td>
		<td><?php echo $myData['jumlah_terima']?></td>
		<td><?php echo $myData['keterangan']?></td>
	</tr>              
<?php }?>
<!--BATAS PERULANGAN DATA-->
</table>

<!--button print dan excel-->
<div class="pull-right">
<div id="section-not-to-print">
	<form action="<?php echo $baseURL;?>report_xls/officer" method="post" name="form2">
			<input type="hidden" name="tglAwal" value="<?php echo $tglAwal; ?>" />
			<input type="hidden" name="tglAkhir" value="<?php echo $tglAkhir; ?>" />
		<button type="button" class="btn btn-info btn-lg goPrint"> <span class="glyphicon glyphicon-print"></span>Print</button>
	</form>
</div>
</div>
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
<script src="<?php echo $baseURL;?>assets/others/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $baseURL;?>assets/others/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!--<script src="<?php echo $baseURL;?>assets/others/dataTables.net-buttons/js/dataTables.bootstrap.buttons.min.js"></script>
DATA RANGEPICKER-->
<script src="<?php echo $baseURL;?>assets/js/moment/moment.min.js"></script>

<script type="text/javascript" src="<?php echo $baseURL;?>assets/others/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $baseURL;?>assets/others/bootstrap-daterangepicker/daterangepicker.css"/>




<!-- Datatables-->
<script>
	pagename='report/officer';
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