<?php if(!defined('OFFDIRECT')) include '../error404.php'; ?>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include "menu.php";	
include "base_template_topnav.php";	
?>

    <!-- Datatables -->
    <link href="<?php echo $baseURL;?>assets/others/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $baseURL;?>assets/others/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">

		<!-- Printing -->
		<link href="<?php echo $baseURL; ?>assets/css/printing.css" rel="stylesheet">

        <div class="right_col" role="main" id="section-to-print">        
          <div class="">
            <div class="page-title section-not-to-print">
              <div class="title_left">
                <h3>Laporan & Cetak Data <small></small></h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Laporan Data Penempatan <small>per Periode</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
<?php

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= "01-".date('m-Y');
$tglAkhir	= date('d-m-Y');

# Set Tanggal skrg
//$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAwal 	= isset($_POST['txtTanggalAwal']) ? $_POST['txtTanggalAwal'] : $tglAwal;

//$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');
$tglAkhir 	= isset($_POST['txtTanggalAkhir']) ? $_POST['txtTanggalAkhir'] : $tglAkhir; 

if(isset($_REQUEST['txtTanggal'])) {
	list($tglAwal,$tglAkhir) = explode(' s/d ', trim($_REQUEST['txtTanggal']));
}

// Jika tombol filter tanggal (Tampilkan) diklik
//if (isset($_POST['btnTampil'])) {
	$filterSQL = "WHERE ( tgl_penempatan BETWEEN '".($tglAwal)."' AND '".($tglAkhir)."')";
//}
//else {
//	$filterSQL = "";
//}

?>

	<form action="" method="post" name="form1" class="form-horizontal form-label-left" id="section-not-to-print">
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="aaa">Periode</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend input-group">
							<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							<input type="text" name="txtTanggal" id="txtTanggal" class="form-control" value="" />
						</div>
					</div>
				</div>	
			</div>
			<input name="btnTampil" class="btn btn-success" type="submit" value="submit" />
		</div>
	</form>

	<div id="only-on-print">
		<h4>Periode: <?php echo "$tglAwal s/d $tglAkhir" ;?></h4>
	</div>
			
	<div class="ln_solid"></div>

	<table id="datatable" class="table table-striped table-bordered">
		<thead>
		<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>No. Transaksi</th>
				<th>Keterangan</th>				
				<th>Lokasi</th>				
				<th>Qty Barang</th>
				<th id="section-not-to-print">Tools</th>
			</tr>
		</thead>
		<tbody>
<?php
	$mySql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
				LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
				$filterSQL
				ORDER BY penempatan.no_penempatan DESC";
	$myQry = mysqli_query($koneksidb, $mySql);
	$nomor = $hal;  
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		
		$noNota = $myData['no_penempatan'];
		$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noNota'";
		$my2Qry = mysqli_query($koneksidb, $my2Sql);
		$my2Data = mysqli_fetch_array($my2Qry);
		
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penempatan']); ?></td>
    <td><?php echo $myData['no_penempatan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['nm_lokasi']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="center" id="section-not-to-print"><a href="<?php echo $baseURL; ?>report/placement_data?code=<?php echo $noNota; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
  </tr>
  <?php } ?>
		</tbody>
	</table> 

	<div id="section-not-to-print">
		<form action="<?php echo $baseURL;?>report_xls/placement_period" method="post" name="form2">
			<input type="hidden" name="tglAwal" value="<?php echo $tglAwal; ?>" />
			<input type="hidden" name="tglAkhir" value="<?php echo $tglAkhir; ?>" />
			<button type="button" class="btn btn-success goPrint" >Print</button>
			<button type="submit" class="btn btn-primary" >Excel</button>		
		</form>		
	</div>
		

                  </div>
                </div>
              </div>

            </div>            
          </div>
        </div>

<?php include "base_template_footer.php";	?>

      </div>
    </div>
    
    <!-- Datatables -->
    <script src="<?php echo $baseURL;?>assets/others/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $baseURL;?>assets/others/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo $baseURL;?>assets/js/moment/moment.min.js"></script>
		<script type="text/javascript" src="<?php echo $baseURL;?>assets/others/bootstrap-daterangepicker/daterangepicker.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $baseURL;?>assets/others/bootstrap-daterangepicker/daterangepicker.css" />    
		
		
    <script>
    	pagename='report/placement_period';
      $(document).ready(function() {    
    		$('#datatable').DataTable({
					 "columnDefs": [
							{ "orderable": false, "targets": 6 }
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