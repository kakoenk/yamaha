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
	/*untuk menerima parsing data dari form
	  nama $_POST['txtNama'] disesuaikan pada form yang kita buat dibawah dst.*/
	$noPenerimaan 		= $_POST[no_penerimaan];
	$txtTanggal 		= $_POST['txtTanggal'];
	//$txtNamaKegiatan 	= $_POST['txtNamaKegiatan'];
	//$cmbTahunKegiatan 	= $_POST['cmbTahunKegiatan'];
	$cmbPengirim	 	= $_POST['cmbPengirim'];
	//$txtNilaiPaguPaket 	= $_POST['txtNilaiPaguPaket'];
	//$cmbJenis		 	= $_POST['cmbJenis'];
	$cmbPenerima	= $_POST['cmbPenerima'];

	/*batas untuk menerima parsing data dari form*/

	//untuk menampilkan pesan error nama variabel harus disesuaikan dengan yang atas

	$pesanError = array();
	if (trim($txtTanggal)==""){
		$pesanError[]="Data <b>Tgl. Pengadaan</b> belum diisi, pilih pada combo !";
	}
	/*if (trim($txtNamaKegiatan)==""){
		$pesanError[]="Data <b>Kegiatan</b> belum diisi !";
	}
	if (trim($cmbTahunKegiatan)==""){
		$pesanError[]="Data <b>Tahun kegiatan</b> belum dipilih, silahkan pilih pada combo !";
	}*/
	// if (trim($cmbPengirim)==""){
	// 	$pesanError[]="Data <b>Vendor</b> belum dipilih, silahkan pilih pada combo !";
	// }/*
	// if (trim($txtNilaiPaguPaket)==""){
	// 	$pesanError[]="Data <b>Nilai Pagu paket</b> belum diisi";
	// }
	// if (trim($cmbJenis)==""){
	// 	$pesanError[]="Data <b>Metode pengadaan</b> belum diisi";
	// }*/
	// if (trim($cmbPenerima)==""){
	// 	$pesanError[]="Data <b>Penerima</b> belum diisi";
	// }
	//batas untuk menampilkan pesan error

	//CEK APAKAH NAMA BARNG SUDAH ADA ATAU BELUM
	// $tmpSql="SELECT COUNT(*) As qty FROM tmp_pengirima WHERE kd_petugas='$userLogin'";
	// $tmpQry=mysqli_query($koneksidb, $tmpSql);
	// $tmpData=mysqli_fetch_array($tmpQry);

	// //KALAU SUDAH ADA WARNING DAN KELUAR
	// if ($tmpData['qty'] < 1){
	// 	$pesanError[]= "<b>DAFTAR BARANG MASIH KOSONG </b>daftar item barang yang dibeli belum dimasukan ";
	// }

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
		//buat kode barang secara generate barang==> nama tabel B==> inisial awal

		//$kodeBaru = buatKode ("penerimaan","P");

		//untuk upload file jika diperlukan



		//batas untuk upload file jika diperlukan  txtketerangan


	//mengisi tabel pengiriman
        $sql = "SELECT * FROM po_item WHERE kd_barang='$_POST[kd_barang]'";
		$myQry = mysqli_query($koneksidb,$sql);
		//$total=mysqli_fetch_array($myQry);
		while($dataTmp = mysqli_fetch_array($myQry)){
							
							//mengisi data
							$mysql ="INSERT INTO penerimaan (no_penerimaan, no_pengiriman, tanggal, kd_petugas)

									VALUES ('$noPenerimaan','$dataTmp[no_pengiriman]','$txtTanggal','$userLogin')";
							mysqli_query($koneksidb, $mysql);

							$sqlterima ="INSERT INTO po_terima (no_pengiriman, kd_barang, nm_barang, jumlah, kd_petugas)

									VALUES ('$dataTmp[no_pengiriman]','$dataTmp[kd_barang]','$dataTmp[nm_barang]','$userLogin')";
							mysqli_query($koneksidb, $sqlterima);
		 
							//update stok
							// $tmpUpdate = "UPDATE st_barang SET jumlah=jumlah+'$dataTmp[jumlah]' WHERE kd_barang='$dataTmp[kd_barang]'";
							// mysqli_query($koneksidb, $tmpUpdate);


						}
					

						//hapus tmp_pengadaan
						// $tmpDelete = "DELETE FROM po_item WHERE kd_barang='$_POST[kd_barang]'";
						// $myQry = mysqli_query($koneksidb, $tmpDelete);

			//mengembalikan ke folder awal jika berhasil disimpan data
			echo "<meta http-equiv='refresh' content='0; url=".$baseURL."procurement/terima'>";
		}
		exit;

		//mengisi tabel po_item
		//mengisi tabel









//FORM ISIAN DATA
		/*<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
		action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-"*/
	
}
$noTransaksi = buatKode("penerimaan","PE");
$tglTransaksi = isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date ('d-m-Y');
$dataPengirim = isset($_POST['cmbPengirim']) ? $_POST['cmbPengirim'] : '';
$dataPenerima = isset($_POST['cmbPenerima']) ? $_POST['cmbPenerima'] : '';
$dataJenis = isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataNamaModel = isset($_POST['txtNamaModel']) ? $_POST['txtNamaModel'] : '';

if(isset($_POST['btnAdd'])){


	$tmpDelete = "DELETE FROM tmp_penerimaan WHERE no_penerimaan='$_POST[no_penerimaan]'";
	$myQry = mysqli_query($koneksidb, $tmpDelete);

	$tmpInsert = "INSERT INTO tmp_penerimaan ( no_penerimaan, no_pengiriman, kd_barang, nm_barang, kd_petugas, pengirim, penerima, tgl_po, jumlah, validasi, kd_model) 
					SELECT '$noTransaksi', a.no_pengiriman,  b.kd_barang,b.nm_barang, '$userLogin', a.pengirim, a.penerima, a.tgl_po, b.jumlah, b.jumlah, c.kd_model FROM pengiriman a 
				LEFT JOIN po_item b ON b.no_pengiriman=a.no_pengiriman 
				LEFT JOIN barang c ON c.kd_barang=b.kd_barang
				LEFT JOIN model d ON d.kd_model=c.kd_model WHERE a.penerima='$dataPenerima'";
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
	function modalEdit(kode,nama,jumlah){
		document.getElementById('edtKode').value = kode;
		document.getElementById('edtNamaBarang').value = nama;
		//document.getElementById('edtHarga').value = harga;
		document.getElementById('edtJumlah').value = jumlah;
	}
</script>


<!--MODAL EDIT JUMLAH-->
<div class="modal fade modal-tambah<?php echo $noTransaksi; ?>" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span></button>
			<h4 class="modal-title" id="myModalLabel">Validasi</h4>
		</div>
<div class="modal-body">
	<form id="modalFormEdit" name="modalFormEdit">
	
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">No Transaksi</label>
			 <input type="text" name="noTransaksi" id="noTransaksi" value="<?php echo $noTransaksi; ?>" readonly="readonly" class="form-control" required="required" data-parsley-error-message="field ini harus diisi">
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
			<label class="control-label">Jumlah<span class="required">*</span></label>
			<input type="text" name="edtJumlah" id="edtJumlah" class="form-control" required="required" data-parsley-error-message="field ini harus diisi">
			</input>
		</div>
		</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-succes btnEdit" id="btnEdit">Save</button>
							<input type="hidden" name="act" value="add"/>
						</div>
					</form>
				</div>
			</div>
		</div>

<!--MODAL EDIT JUMLAH-->



<!-- BATAS HEADER TITLE -->



<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
	action ="<?php $srever['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
	<input name="txtKode" type="hidden" value="<?php echo $noTransaksi; ?>">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">Kode</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="kode" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $noTransaksi; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtTanggal">Tanggal Penerimaan<span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input id="txtTanggal" type="date" rows="3"  class="form-control" name="txtTanggal" data-parslay-error-message="field ini harus di isi"><?php echo $txtTanggal; ?></input>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="aaa">Penerima</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<select id="aaa" class="form-control" name="cmbPenerima">
				<option value="kosong"></option>
				<?php
				
				$dataSql ="SELECT * FROM bagian ORDER BY kd_bagian";
				$dataQry = mysqli_query($koneksidb, $dataSql);
				while ($dataRow = mysqli_fetch_array($dataQry)) {
					if ($dataRow['kd_bagian']== $dataBagian){
						$cek ="selected";
						echo "<option value='$dataRow[kd_bagian]' $cek>$dataRow[nm_bagian]</option>";
					} else {$cek="";}
					
				}
				
				?>
				
			</select>
			<input type="submit" class ="btn btn-default" name="btnAdd" value="add"/>
		</div>
		
	</div>

 
<div class="clearfix"></div>
	<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h4>Data Barang</h4>

	</div>

<!-- BATAS HEADER TITLE-->
<!-- DIGUNAKAN UNTUK PROSES PENCARIAN BERDASARKAN KATEGORI (DISESUAIKAN DENGAN PENCARIAN) -->

<!--DATAGRID BERDASARKAN DATA YANG AKAN KITA TAMPILKAN-->
<table id="datatable" class="table table-striped table-bordered">
	<thead>

		<tr>
			<th width="23" align="center"><strong>No</strong></th>
			<th width="150"><strong>No Pengiriman</strong></th>	
			<th width="150"><strong>kd_barang</strong></th>		
			<th width="400"><strong>Nama Barang</strong></th>
			<th width="150"><strong>Model</strong></th>
			<th width="420" align="center"><strong>Pengirim</strong></th>
			<th width="70" align="center"><strong>Jumlah</strong></th>
			<th width="150"><strong>jumlah terima</strong></th>
			<th width="100" align="center">Tools</th>
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
	$tmpSql ="SELECT a.no_pengiriman, a.kd_barang, a.nm_barang, b.nm_model, a.jumlah, a.validasi, c.nm_bagian FROM tmp_penerimaan a 
	 		LEFT JOIN model b ON b.kd_model=a.kd_model
	 		LEFT JOIN bagian c ON c.kd_bagian=a.pengirim WHERE penerima='$dataPenerima'";
	$tmpQry = mysqli_query($koneksidb, $tmpSql);
	$nomor =0; $subTotal=0; $totalBelanja=0; $qtyItem=0;
	//PERULANGAN DATA
	while ($tmpData = mysqli_fetch_array($tmpQry)) {
		$ID = $tmpData['id'];
		$qtyItem= $qtyItem + $tmpData['jumlah'];
		$subTotal= $tmpData['jumlah'];
		$totalBelanja= $totalBelanja + $subTotal;
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
		<td align="center"><?php echo $tmpData['validasi'];?></td>


		<td align="center">
			<?php if (!$_SESSION['SES_PENGGUNA']):?>
				<a onclick="modalEdit('<?php echo $tmpData[kd_barang]?>','<?php echo $tmpData[nm_barang]?>','<?php echo $tmpData[jumlah];?>')" data-toggle="modal" data-target=".modal-tambah<?php echo $noTransaksi; ?>"><span>validasi</span></a>
				<!-- <input type="button" onclick="modalEdit('<?php echo $tmpData[kd_barang]?>','<?php echo $tmpData[nm_barang]?>','<?php echo $tmpData[jumlah];?>')" data-toggle="modal" data-target=".modal-tambah<?php echo $noTransaksi; ?>"></input> -->
				<a href="<?php echo $baseURL;?>procurement/deletep?kode=<?php echo $ID; ?>" target="_self" alt="Delete Data" onclick="return confirm('Apakah anda yakin ingin menghapus data No <?php echo $nomor; ?>')">
					<span class="fa fa-trash"></span></a>
				
				</td>
				<?php endif;?>

		<td></td>
	</tr>
<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5" align="right"><b> TOTAL BARANG : </b></td>
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
		"paging": false,
		"searching": true,
		"info": true,
	});

	$('.btnTambah').on('click', function(){

		if( $('#NamaBarang').val() && $('#txtJumlah').val()) {
				$.post( "<?php echo $baseURL;?>library/api.procurement.php",
			$( "#modalform" ).serialize(), function(data){
				if(data>0){
					
					nmbrg=$("#NamaBarang option:selected").text();

					tbl.row.add([
						tbl.rows().count()+1,
						$('#NamaBarang').val(),
						nmbrg,
						$('#txtJumlah').val(),
						'<center><span class="fa fa-trash"></span></center>',
						data,
					] ).draw( false );
					
					
					$('#model').val('');
					$('#NamaBarang').val('');
					$('#txtJumlah').val('');
					
				}
			});
			$('.bs-example-modal').modal('hide');
		}

		
	});
	$('.btnEdit').on('click', function(){
		if( $('#edtNamaBarang').val() && $('#edtJumlah').val()) {
				$.post( "<?php echo $baseURL;?>library/api.modaledit.php",
			$( "#modalFormEdit" ).serialize(), function(data){
				if(data>0){

					nmbrg=$("#edtBarang option:selected").text().split(" ");

					tbl.row.add([
						tbl.rows().count()+1,
						$('#edtJumlah').val(),
						nmbrg,
						
						'<center><span class="fa fa-trash"></span></center>',
						data,
					] ).draw( false );
					$('#edtJumlah').val('');
					
				}
			});
			$('.modal-tambah').modal('hide');
		}


	});
	$('#dataTable tbody').on('click','.fa-trash', function(){
		obj=$(this).parents('tr');
		id=tbl.row( $(this).parents('tr')).data()[6];
		console.log(id);
		$.post("<?php echo $baseURL;?>library/api.modaledit.php",
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
