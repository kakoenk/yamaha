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
				<h3>General <small>Barang</small></h3>
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
$userLogin = $_SESSION['SES_LOGIN'];
$dataKategori = isset ($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
$dataBarang = isset ($_POST['cmbBarang']) ? $_POST['cmbBarang'] : '';

if(isset($_POST['btnSimpan'])){
	/*untuk menerima parsing data dari form
	  nama $_POST['txtNama'] disesuaikan pada form yang kita buat dibawah dst.*/
	$noPenerimaan 		= $_POST['no_pe'];
	//$txtNamaKegiatan 	= $_POST['txtNamaKegiatan'];
	//$cmbTahunKegiatan 	= $_POST['cmbTahunKegiatan'];
	$cmbSupplier	 	= $_POST['cmbSupplier'];
	//$txtNilaiPaguPaket 	= $_POST['txtNilaiPaguPaket'];
	//$cmbJenis		 	= $_POST['cmbJenis'];
	$no_po	= $_POST['no_po'];

	/*batas untuk menerima parsing data dari form*/

	//untuk menampilkan pesan error nama variabel harus disesuaikan dengan yang atas

	// $pesanError = array();
	// if (trim($txtTanggal)==""){
	// 	$pesanError[]="Data <b>Tgl. Pengadaan</b> belum diisi, pilih pada combo !";
	// }
	// /*if (trim($txtNamaKegiatan)==""){
	// 	$pesanError[]="Data <b>Kegiatan</b> belum diisi !";
	// }
	// if (trim($cmbTahunKegiatan)==""){
	// 	$pesanError[]="Data <b>Tahun kegiatan</b> belum dipilih, silahkan pilih pada combo !";
	// }*/
	// if (trim($cmbSupplier)==""){
	// 	$pesanError[]="Data <b>Vendor</b> belum dipilih, silahkan pilih pada combo !";
	// }/*
	// if (trim($txtNilaiPaguPaket)==""){
	// 	$pesanError[]="Data <b>Nilai Pagu paket</b> belum diisi";
	// }
	// if (trim($cmbJenis)==""){
	// 	$pesanError[]="Data <b>Metode pengadaan</b> belum diisi";
	// }*/
	// if (trim($txtDivisiTujuan)==""){
	// 	$pesanError[]="Data <b>Devisi tujuan</b> belum diisi";
	// }
	// //batas untuk menampilkan pesan error

	//CEK APAKAH NAMA BARNG SUDAH ADA ATAU BELUM
	$tmpSql="SELECT COUNT(*) As qty FROM tmp_penerimaan WHERE kd_petugas='$userLogin'";
	$tmpQry=mysqli_query($koneksidb, $tmpSql);
	$tmpData=mysqli_fetch_array($tmpQry);

	//KALAU SUDAH ADA WARNING DAN KELUAR
	if ($tmpData['qty'] < 1){
		$pesanError[]= "<b>DAFTAR BARANG MASIH KOSONG </b>daftar item barang yang dibeli belum dimasukan ";
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
		//kalau belum ada
		//buat kode barang secara generate barang==> nama tabel B==> inisial aw

		//untuk upload file jika diperlukan



		//batas untuk upload file jika diperlukan  txtketerangan


	//mengisi tabel po
        $sql = "SELECT * FROM po_item WHERE no_pengiriman='$_POST[no_pengiriman]'";
		$myQry = mysqli_query($koneksidb,$sql);
		//$total=mysqli_fetch_array($myQry);
		while($dataTmp = mysqli_fetch_array($myQry)){
							
							//mengisi data
							$mysql ="INSERT INTO penerimaan (no_penerimaan, no_pengiriman, kd_barang, nm_barang, jumlah, harga)

									VALUES ('$noPenerimaan','$dataTmp[no_po]','$dataTmp[kd_barang]','$dataTmp[nm_barang]','$dataTmp[jumlah]','$dataTmp[harga]')";
							mysqli_query($koneksidb, $mysql);
		 
							//update stok
							$tmpUpdate = "UPDATE barang SET jumlah=jumlah+'$dataTmp[jumlah]' WHERE kd_barang='$dataTmp[kd_barang]'";
							mysqli_query($koneksidb, $tmpUpdate);


						}
					

						//hapus tmp_pengadaan
						$tmpDelete = "DELETE FROM tmp_penerimaan WHERE no_po='$_POST[no_po]'";
						$myQry = mysqli_query($koneksidb, $tmpDelete);

			//mengembalikan ke folder awal jika berhasil disimpan data
			echo "<meta http-equiv='refresh' content='0; url=".$baseURL."procurement/penerimaan1'>";
		}
		exit;

		//mengisi tabel po_item
		//mengisi tabel









//FORM ISIAN DATA
		/*<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
		action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-"*/
	}



$noTransaksi = buatKode("po","P");
$noPenerimaan = buatKode("po","PE");
$tglTransaksi = isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date ('d-m-Y');
$dataSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$dataJenis = isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataNamaKategori = isset($_POST['txtNamaKategori']) ? $_POST['txtNamaKategori'] : '';
$nopo = isset($_POST['no_po']) ? $_POST['no_po'] : '';
if(isset($_POST['btnTampil'])){

	$tmpDelete = "DELETE FROM tmp_penerimaan WHERE no_po='$_POST[no_po]'";
	 $myQry = mysqli_query($koneksidb, $tmpDelete);

	$tmpInsert = "INSERT INTO tmp_penerimaan (kd_petugas, no_pe, no_po, kd_barang, nm_barang, jumlah, harga) 
					SELECT '$userLogin','$noPenerimaan', no_po,kd_barang,nm_barang,jumlah,harga FROM po_item WHERE no_po='$_POST[no_po]'";
	$myQry = mysqli_query($koneksidb, $tmpInsert);


}
?>
<script language="javascript">

	function submitform(){

		$('#NamaBarang').empty();
		$('#NamaBarang').append($('<option>', {
			value: '',
			text : ''
		}));

		$.getJSON('<?php echo $baseURL; ?>library/api.nama_barang.php?dataKategori='+$('#Kategori').val(), function (data){
			$.each(data, function(i,item){
				$('#NamaBarang').append($('<option>', {
			value: item.value,
			text : '['+item.value+'] '+item.text+' Rp '+item.nilai

		}));
	});

  });

}
function submitSupplier(){

		$('#no_po').empty();
		$('#no_po').append($('<option>', {
			value: '',
			text : ''
		}));
		

		$.getJSON('<?php echo $baseURL; ?>library/api.nama_supplier.php?dataSupplier='+$('#Supplier').val(), function (data){
			$.each(data, function(i,item){
				$('#no_po').append($('<option>', {
			value: item.value,
			text : item.text

		}));
	});

  });

}
</script>
<!--large modal tambah data-->
<div class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span></button>
			<h4 class="modal-title" id="myModalLabel">Input Barang</h4>
		</div>
<div class="modal-body">

	<form id="modalform" name="modalform">
	
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">No Transaksi</label>
			 <input type="text" name="txtKodem" id="txtKodem" value="<?php echo $noTransaksi; ?>" readonly="readonly" class="form-control" required="required" data-parsley-error-message="field ini harus diisi">
			</input>
			</div>

		<div class="form-group">
			<label class="control-label" for="Kategori">Kategori<span class="required">*</span></label>
			<select name="cmbKategori" id="Kategori" onchange="javascript:submitform();" class="form-control" required="required" data-parsley-error-message="field ini harus diisi"><option value=""></option>
				<?php
				$daftarSql = "SELECT * FROM kategori ORDER BY kd_kategori";
				$daftarQry = mysqli_query($koneksidb, $daftarSql);
				while ($daftarData = mysqli_fetch_array($daftarQry)) {
					if ($daftarData['kd_kategori']==$dataKategori){
						$cek=" selected";
					}else {$cek="";}
					echo "<option value='$daftarData[kd_kategori]' $cek> $daftarData[nm_kategori]</option>";
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="NamaBarang">Nama Barang<span class="required">*</span></label>
								<select name="cmbBarang" id="NamaBarang" class="form-control" required="required" data-parsley-error-message="field ini harus diisi">
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Jumlah<span class="required">*</span></label>
								<input type="text" name="txtJumlah" id="txtJumlah" class="form-control" required="required" data-parsley-error-message="field ini harus diisi">
								</input>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-succes btnTambah" id="btnTambah">Save</button>
							<input type="hidden" name="act" value="add"/>
						</div>
					</form>
				</div>
			</div>
		</div>
<!--large modal tambah data-->



<!-- BATAS HEADER TITLE -->



<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
	action ="<?php $srever['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
	<input name="txtKode" type="hidden" value="<?php echo $noPenerimaan; ?>">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">No Penerimaan</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" name="no_pe" id="kode" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $noPenerimaan; ?>">
		</div>
	</div>
	<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Supplier">Nama Supplier<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select class="form-control" id="Supplier" name="cmbSupplier" required="" onchange="javascript:submitSupplier();" data-parslay-error-message="field ini harus di isi">
		<option value="kosong"></option>
		<?php
		$mysql ="SELECT * FROM suplier ORDER BY nm_suplier";
		$myQry = mysqli_query($koneksidb, $mysql);
		while ($mydata = mysqli_fetch_array($myQry)){
			if ($mydata['kd_suplier']==$dataSupplier) {
				$cek="selected";
			}else {$cek="";}
			echo "<option value='$mydata[kd_suplier]' $cek>$mydata[nm_suplier]</option>";
		}
		?>
	</select>
	</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">No PO</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			 <select name="no_po" id="no_po" class="form-control" required="required" data-parsley-error-message="field ini harus diisi">
			 	<option value='<?php echo $_POST['no_po']; ?>'>
			 	<?php echo $_POST['no_po']; ?></option>
		</select>
		</div>
	</div>
	<input type="submit" class ="btn btn-default" name="btnTampil" value="Tampil"/>
	







<div class="clearfix"></div>
	<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h4>Data Barang

	</div>

<!-- BATAS HEADER TITLE-->
<!-- DIGUNAKAN UNTUK PROSES PENCARIAN BERDASARKAN KATEGORI (DISESUAIKAN DENGAN PENCARIAN) -->
<div class="pull-right">
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal"><span class="fa fa-plus-circle"></span>Input Barang</button>
</div></h4>


<!--DATAGRID BERDASARKAN DATA YANG AKAN KITA TAMPILKAN-->
<table id="datatable" class="table table-striped table-bordered">
	<thead>

		<tr>
			<th align="center"><strong>No</strong></th>
			<th align="center"><strong>Kode Barang</strong></th>
			<th align="center"><strong>Nama Barang</strong></th>
			<th align="center"><strong>Harga</strong></th>
			<th align="center"><strong>Jumlah</strong></th>
			<th align="center"><strong>Tools</strong></th>
			 
		</tr>
	</thead>
	<tbody>
	<?php

	/* PENCARIAN BERDASARKA DATA DI TABEL*/
	$mySql ="SELECT * FROM tmp_penerimaan WHERE no_po='$_POST[no_po]'";
	$myQry = mysqli_query($koneksidb, $mySql);
	$nomor = $hal;
	//PERULANGAN DATA
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData ['no_po'];
		?> 
	<!--MENAMPILKAN HASIL PENCARIAN DATABASE-->
	<tr>
		<td align="center"><?php echo $nomor;?></td>
		<td><?php echo $myData['kd_barang']?></td>
		<td><?php echo $myData['nm_barang']?></td>
		<td><?php echo $myData['harga']?></td>
		<td align="center"><?php echo $myData['jumlah'];?></td>
		<td align="center">
			<?php if (!$_SESSION['SES_PENGGUNA']):?>
				<a data-toggle="modal" data-target=".modal-edit<?php echo $Kode; ?>"><span class="fa fa-pencil"></span></a>
				<a href="<?php echo $baseURL;?>procurement/delete?kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Apakah anda yakin ingin menghapus data <?php echo $Kode; ?>')">
					<span class="fa fa-trash"></span></a>
				
				</td>
				<?php endif;?>
	</tr>
<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" align="right"><b> GRAND TOTAL : </b></td>
			<td align="center">&nbsp;</td>
			<td align="right"><strong><?php echo $totalBelanja; ?></strong></td>
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

	pagename='procurement/penerimaan1';
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
		{ "targets": 6, "visible": false, "searchable": false }
		],
		"paging": false,
		"searching": true,
		"info": true,
	});

	$('.btnTambah').on('click', function(){
		if( $('#NamaBarang').val() && $('#txtJumlah').val()) {
				$.post( "<?php echo $baseURL;?>library/api.procurement.php",
			$( "#modalform" ).serialize(), function(data){
				if(data>0){

					nmbrg=$("#NamaBarang option:selected").text().split(" ");

					tbl.row.add([
						tbl.rows().count()+1,
						$('#NamaBarang').val(),
						nmbrg[1],
						nmbrg[3],
						$('#txtJumlah').val(),
						'<center><span class="fa fa-trash"></span></center>',
						data,
					] ).draw( false );
					$('#Kategori').val('');
					$('#NamaBarang').val('');
					$('#txtJumlah').val('');
				}
			});
			$('.bs-example-modal').modal('hide');
		}


	});
	$('#dataTable tbody').on('click','.fa-trash', function(){
		obj=$(this).parents('tr');
		id=tbl.row( $(this).parents('tr')).data()[6];
		console.log(id);
		$.post("<?php echo $baseURL;?>library/api.procurement.php",
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
