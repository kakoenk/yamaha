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
<link href="<?php echo $baseURL;?>/assets/css/fileinput.min.css" rel="stylesheet">
<link href="<?php echo $baseURL;?>assets/other/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $baseURL;?>assets/other/datables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<div class ="right_col" role="main">
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
						<h2>Data Lokasi <small>Add</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="=x_content">

<?php
$filterSQL="";
// SETELAH TOMBOL GO DI KLIK AKAN PROSES SCRIPT SEPERTI INI
$Kat 			= isset($_GET['Kat']) ? $_GET['Kat'] : 'semua';//dari URL
$dataBagian 	= $_SESSION['SES_BAGIAN']; //isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : $Kat; //dari form
if (trim($dataBagian)=="semua") {
		$filterSQL ="";		
	}
	else {
		$filterSQL="WHERE a.penerima='$dataBagian' ";
}
?>


<?php
$userLogin = $_SESSION['SES_LOGIN'];
$dataModel = isset ($_POST['cmbModel']) ? $_POST['cmbModel'] : '';
$dataBarang = isset ($_POST['cmbBarang']) ? $_POST['cmbBarang'] : '';

if(isset($_POST['btnSimpan'])){
	 // untuk menerima parsing data dari form
	$noPenerimaan 		= $_POST[no_penerimaan];
	$txtTanggal 		= $_POST['txtTanggal'];
	 
	$cmbPengirim	 	= $_POST['cmbPengirim'];
	 
	$cmbPenerima	= $_POST['cmbPenerima'];

	/*batas untuk menerima parsing data dari form*/

	//untuk menampilkan pesan error nama variabel harus disesuaikan dengan yang atas
	$pesanError = array();
	if (trim($txtTanggal)==""){
		$pesanError[]="Data <b>Tgl. Pengadaan</b> belum diisi, pilih pada combo !";
	}

	if (count($pesanError)>=1 ){
		//kalau sudah ada warning dan keluar
		echo '<div class="alert alert-danger alert-dismissible fade in"role="alert">
		<button type="button" class="close" data-dismis="alert" aria-label="close">
		<span aria-hidden="true">x</span>
		</button>
		<strong>Error</strong></br>';

		foreach ($pesanError as $indeks => $pesan_tampil) echo "$pesan_tampil</br>";
		echo '</div>';
		//batas kalau sudah ada warnign dan keluar

	}else {
		//mengisi tabel pengiriman
        $sql = "SELECT * FROM tmp_penerimaan WHERE no_pengiriman='$_POST[no_pengiriman]'";
		$myQry = mysqli_query($koneksidb,$sql);
		//$total=mysqli_fetch_array($myQry);
		while($dataTmp = mysqli_fetch_array($myQry)){
							
							//mengisi data
							$mysql ="INSERT INTO penerimaan (no_pengiriman,kd_barang, nm_barang,kd_pengirim,	pengirim,penerima, tgl_po, jumlah, jumlah_terima, kd_penerima)

							VALUES ('$dataTmp[no_pengiriman]','$dataTmp[kd_barang]','$dataTmp[nm_barang]','$dataTmp[kd_pengirim]','$dataTmp[pengirim]','$dataTmp[no_penerima]','$dataTmp[tgl_po]','$dataTmp[jumlah]','$dataTmp[jumlah_terima]','$userLogin')";
							mysqli_query($koneksidb, $mysql);

							// $sqlterima ="INSERT INTO po_terima (no_pengiriman, kd_barang, nm_barang, jumlah, kd_petugas)

							// 		VALUES ('$dataTmp['no_pengiriman']','$dataTmp['kd_barang']','$dataTmp['nm_barang']','$userLogin')";
							// mysqli_query($koneksidb, $sqlterima);
		 
							// $tmpUpdate = "UPDATE st_barang SET jumlah=jumlah+'$dataTmp[jumlah_terima]' WHERE kd_barang='$dataTmp[kd_barang]' AND kd_bagian='$dataTmp[penerima]'";
							// mysqli_query($koneksidb, $tmpUpdate);
						}
					

						//hapus tmp_pengadaan
						// $tmpDelete = "DELETE FROM po_item WHERE kd_barang='$_POST[kd_barang]'";
						// $myQry = mysqli_query($koneksidb, $tmpDelete);

			//mengembalikan ke folder awal jika berhasil disimpan data
			echo "<meta http-equiv='refresh' content='0; url=".$baseURL."procurement/terima1'>";
		}
		exit;
	
}
$noTransaksi = buatKode("penerimaan","PE");
$noPengiriman= isset($_POST[no_pengiriman]) ? $_POST[no_pengiriman] : '';
$tglTransaksi = isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date ('d-m-Y');
$dataPengirim = isset($_POST['cmbPengirim']) ? $_POST['cmbPengirim'] : '';
$dataPenerima = isset($_POST['cmbPenerima']) ? $_POST['cmbPenerima'] : '';
$dataJenis = isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataNamaModel = isset($_POST['txtNamaModel']) ? $_POST['txtNamaModel'] : '';

// if(isset($_POST['btnAdd'])){


// 	$tmpDelete = "DELETE FROM tmp_penerimaan WHERE no_penerimaan='$_POST[no_penerimaan]'";
// 	$myQry = mysqli_query($koneksidb, $tmpDelete);

// 	$tmpInsert = "INSERT INTO tmp_penerimaan ( no_penerimaan, no_pengiriman, kd_barang, nm_barang, kd_petugas, pengirim, penerima, tgl_po, jumlah, validasi, kd_model) 
// 					SELECT '$noTransaksi', a.no_pengiriman,  b.kd_barang,b.nm_barang, '$userLogin', a.pengirim, a.penerima, a.tgl_po, b.jumlah, b.jumlah, c.kd_model FROM pengiriman a 
// 				LEFT JOIN po_item b ON b.no_pengiriman=a.no_pengiriman 
// 				LEFT JOIN barang c ON c.kd_barang=b.kd_barang
// 				LEFT JOIN model d ON d.kd_model=c.kd_model WHERE a.penerima='$dataPenerima'";
// 	$myQry = mysqli_query($koneksidb, $tmpInsert);


// }

?>
<script language="javascript">

	function submitform(){

		$('#NamaBarang').empty();
		$('#NamaBarang').append($('<option>', {
			value: '',
			text : ''
		}));
		$.getJSON('<?php echo $baseURL; ?>library/api.nama_barang.php?dataModel='+$('#Model').val(), function (data){
			
			$.each(data, function(i,item){
				$('#NamaBarang').append($('<option>', {
			value: item.value,
			text : item.text

		}));
	});

  });

}
</script>
<script language="javascript">
	function modalValidasi(noPengiriman,kode,nama,jumlah,terima,keterangan){
		document.getElementById('noPengiriman').value = noPengiriman;
		document.getElementById('edtKode').value = kode;
		document.getElementById('edtNamaBarang').value = nama;
		document.getElementById('edtJumlah').value = jumlah;
		document.getElementById('edtTerima').value = terima;
		document.getElementById('keterangan').value = keterangan;
	}
</script>


<!--MODAL EDIT JUMLAH-->
<div class="modal fade modal-tambah<?php echo $noPengiriman; ?>" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span></button>
			<h4 class="modal-title" id="myModalLabel">Validasi</h4>
		</div>

<div class="modal-body">
	<form id="modalFormEdit" name="modalFormEdit">
		<div class="form-group">
			<label class="control-label">No Pengiriman<span class="required">*</span></label>
			<input type="text" name="noPengiriman" id="noPengiriman" class="form-control" readonly="readonly" required="required" data-parsley-error-message="field ini harus diisi">
			</input>
		</div>
			<div class="form-group">
			<label class="control-label">Kode<span class="required">*</span></label>
			<input type="text" name="edtKode" id="edtKode" class="form-control" readonly="readonly" required="required" data-parsley-error-message="field ini harus diisi">
			</input>
		</div>

		 
		<div class="form-group">
		<label class="control-label" for="NamaBarang">Nama Barang<span class="required">*</span></label>
			<input type="text" name="edtNamaBarang" id="edtNamaBarang" class="form-control" readonly="readonly" required="required" data-parsley-error-message="field ini harus diisi">
			</input>
		</div>
		<div class="form-group">
			<label class="control-label">Jumlah Kirim<span class="required">*</span></label>
			<input type="text" name="edtJumlah" id="edtJumlah" class="form-control" required="required" readonly="readonly" data-parsley-error-message="field ini harus diisi">
			</input>
		</div>
		<div class="form-group">
			<label class="control-label">Jumlah Terima<span class="required">*</span></label>
			<input type="text" name="edtTerima" id="edtTerima" class="form-control" required="required"data-parsley-error-message="field ini harus diisi">
			</input>
		</div>
		<div class="form-group">
			<label class="control-label">Keterangan<span class="required">*</span></label>
			<textarea type="text" name="keterangan" id="keterangan" class="form-control" required="required"data-parsley-error-message="field ini harus diisi">
			</textarea>
		</div>
		</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-success btnEdit" id="btnEdit">Save</button>
							<input type="hidden" name="act" value="add"/>
						</div>
					</form>
				</div>
			</div>
		</div>

<!--MODAL EDIT JUMLAH-->
<!--DATAGRID BERDASARKAN DATA YANG AKAN KITA TAMPILKAN-->
<table id="datatable" class="table table-striped table-bordered">
	<thead>

		<tr>
			<th width="23" align="center"><strong>No</strong></th>
			<th width="150"><strong>No Pengiriman</strong></th>	
			<th width="150"><strong>Kode barang</strong></th>		
			<th width="400"><strong>Nama Barang</strong></th>
			<th width="70"><strong>Model</strong></th>
			<th width="250" align="center"><strong>Pengirim</strong></th>
			<th width="70" align="center"><strong>Jumlah</strong></th>
			<th width="70" align="center"><strong>Jumlah Terima</strong></th>
			<th width="150" align="center">Validasi</th>
			<th width="1">id</th>
		</tr>
	</thead>
	<tbody>
	<?php

	/* PENCARIAN BERDASARKA DATA DI TABEL*/
	// $tmpSql ="SELECT tmp_pengiriman.*, barang.nm_barang FROM tmp_pengiriman, barang WHERE tmp_pengiriman.kd_barang=barang.kd_barang AND tmp_pengiriman.kd_petugas='$userLogin' ORDER BY id";
	// $tmpSql =  "SELECT a.no_pengiriman, b.kd_barang, e.nm_model, b.nm_barang, b.jumlah, c.nm_bagian FROM pengiriman a 
	// 			LEFT JOIN po_item b ON b.no_pengiriman=a.no_pengiriman 
	// 			LEFT JOIN bagian c on a.pengirim=c.kd_bagian
	// 			LEFT JOIN barang d on b.kd_barang=d.kd_barang
	// 			LEFT JOIN model e on e.kd_model=d.kd_model $filterSQL";
	// $tmpSql ="SELECT a.no_pengiriman, a.kd_barang, a.nm_barang, b.nm_model, a.jumlah, a.validasi, c.nm_bagian FROM tmp_penerimaan a 
	//  		LEFT JOIN model b ON b.kd_model=a.kd_model
	//  		LEFT JOIN bagian c ON c.kd_bagian=a.pengirim WHERE penerima='$dataPenerima'";
	$tmpSql ="SELECT a.no_pengiriman, a.kd_barang, d.nm_model, a.nm_barang, a.jumlah, b.nm_bagian,  a.penerima, a.jumlah_terima, a.keterangan FROM tmp_penerimaan a 
		LEFT JOIN bagian b ON b.kd_bagian=a.pengirim 
		LEFT JOIN barang c ON c.kd_barang=a.kd_barang 
		LEFT JOIN model d ON d.kd_model=c.kd_model $filterSQL ORDER BY jumlah_terima";
	$tmpQry = mysqli_query($koneksidb, $tmpSql);
	$nomor =0; $subTotal=0; $totalBelanja=0; $qtyItem=0;
	//PERULANGAN DATA
	while ($tmpData = mysqli_fetch_array($tmpQry)) {
		$ID = $tmpData['id'];
		$qtyItem= $qtyItem + $tmpData['jumlah'];
		$subTotal= $tmpData['jumlah'];
		$subTerima= $tmpData['jumlah_terima'];
		$totalBelanja= $totalBelanja + $subTotal;
		$totalTerima= $totalTerima + $subTerima;
		$nomor++;
		?>

	<!--MENAMPILKAN HASIL PENCARIAN DATABASE-->
	 
	<tr>
		<td align="center"><?php echo $nomor;?></td>
		<td><?php echo $tmpData['no_pengiriman']?></td>
		<td><?php echo $tmpData['kd_barang']?></td>
		<td><?php echo $tmpData['nm_barang']?></td>
		<td><?php echo $tmpData['nm_model']?></td>
		<td><?php echo $tmpData['nm_bagian']?></td>
		<td align="center"><?php echo $tmpData['jumlah'];?></td>
		<td align="center"><?php echo $tmpData['jumlah_terima'];?></td>



		

<td align="center">			 
				<?php if ($tmpData['jumlah_terima']>="1"):?>
					<?php if ($tmpData['jumlah']==$tmpData['jumlah_terima']) :?>
					 <span class="glyphicon glyphicon-ok"></span> 
					 <?php else :?>
					 	<span class="glyphicon glyphicon-remove"></span>
					 	<?php endif;?>
				</td>
				 <?php else: ?>
				 	<a onclick="modalValidasi('<?php echo $tmpData['no_pengiriman']?>','<?php echo $tmpData['kd_barang']?>','<?php echo $tmpData['nm_barang']?>','<?php echo $tmpData['jumlah'];?>','<?php echo $tmpData['jumlah_terima'];?>','<?php echo $tmpData['keterangan'];?>')" data-toggle="modal" data-target=".modal-tambah<?php echo $noPengiriman; ?>"><button class="btn btn-warning">validasi</button></a> 
				 
				
				<?php endif;?>
		</td>

		<td></td>
	</tr>
<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5" align="right"><b> TOTAL BARANG : </b></td>
			<td align="center">&nbsp;</td>
			<td align="right"><strong><?php echo $totalBelanja; ?></strong></td>
			<td align="right"><strong><?php echo $totalTerima; ?></strong></td>
			<td align="center">&nbsp;</td>
		</tr>
	</tfoot>
<!--BATAS PERULANGAN DATA-->

</table>
<!--BATAS DATAGRID BERDASARKA DATA YANG AKAN KITA TAMPILKAN-->
<!--BUTTON SIMPAN -->
	<div class="pull-right">
		<button type="submit" class="btn btn-success" name="btnSimpan">Simpan</button>
	</div>
</div>
</form>
<!-- BATAS BUTTON SIMPAN -->

</div>
</div>
</div>
</div>
</div>
</div>


</div>
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


<!-- data parsley-->
<script src="<?php echo $baseURL;?>assets/others/parsleyjs/dist/parsley.min.js"></script>
<!-- input-->
<script src="<?php echo $baseURL;?>assets/js/fileinputx.min.js"></script>
<!-- data rangepcker-->
<script src="<?php echo $baseURL;?>assets/js/moment/moment.min.js"></script>
<script src="<?php echo $baseURL;?>assets/js/datepicker/daterangepicker.js"></script>
<!--batatable-->
<script src="<?php echo $baseURL;?>assets/others/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $baseURL;?>assets/others/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>

	pagename='procurement/terima';
	$ (document).ready(function(){
		$.listen('parsley:field:validate', function(){
			validateFront();
		});
		$('#theform .btn').on('click', function(){
			$('#theform').parsley().validate();
			validateFront();
		});
		var validateFront= function(){
			if (true=== $ ('#theform').parsley().isValid()){
				$('.bs-callout-info').removeClass('hidden');
				$('.bs-callout-warning').addClass('hidden');
			}else {
				$('.bs-callout-info').addClass('hidden');
				$('.bs-callout-warning').removeClass('hidden');
			}
		};

		var tbl = $('#datatable').DataTable({
		"columnDefs": [
		{"orderable": false, "targets": 4 },
		{ "targets": 9, "visible": false, "searchable": false }
		],
		"paging": true,
		"searching": true,
		"info": true,
	});

	
	$('.btnEdit').on('click', function(){
		if( $('#edtNamaBarang').val() && $('#edtTerima').val()) {
				$.post( "<?php echo $baseURL;?>library/api.modalValidasi.php",
			$( "#modalFormEdit" ).serialize(), function(data){
				if(data>0){

					nmbrg=$("#edtBarang option:selected").text().split(" ");

					tbl.row.add([
						tbl.rows().count()+1,
						$('#edtTerima').val(),
						nmbrg[1],
						nmbrg[3],
						$('#edtTerima').val(),
						'<center><span class="fa fa-trash"></span></center>',
						data,
					] ).draw( false );
					$('#edtTerima').val('');
					 
				}
			});
			$('.modal-tambah').modal('hide');
		}


	});
	$('#dataTable tbody').on('click','.fa-trash', function(){
		obj=$(this).parents('tr');
		id=tbl.row( $(this).parents('tr')).data()[6];
		console.log(id);
		$.post("<?php echo $baseURL;?>library/api.modalValidasi.php",
			{act: "delete", id:id}, function(data){
				if(data>0){
					tbl.row(obj).remove().draw();
				}
			});
	});


	});

	$(document).on('ready',function(){
		$("#Uploadfiles").fileinput({
			showUpload: false
		});
	});


</script>

</body>
