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
	$txtTanggal 		= $_POST['txtTanggal'];
	//$txtNamaKegiatan 	= $_POST['txtNamaKegiatan'];
	//$cmbTahunKegiatan 	= $_POST['cmbTahunKegiatan'];
	//$cmbSupplier	 	= $_POST['cmbSupplier'];
	//$txtNilaiPaguPaket 	= $_POST['txtNilaiPaguPaket'];
	//$cmbJenis		 	= $_POST['cmbJenis'];
	//$txtDivisiTujuan	= $_POST['txtDivisiTujuan'];
	$noTransaksi		= $_POST['kode'];

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
	 
	 
	if (trim($cmbJenis)==""){
		$pesanError[]="Data <b>Metode pengadaan</b> belum diisi";
	}
	
	//batas untuk menampilkan pesan error

	//CEK APAKAH NAMA BARNG SUDAH ADA ATAU BELUM
	$tmpSql="SELECT COUNT(*) As qty FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
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
		//buat kode barang secara generate barang==> nama tabel B==> inisial awal

		$kodeBaru = buatKode ("po","P");

		//untuk upload file jika diperlukan



		//batas untuk upload file jika diperlukan  txtketerangan


	//mengisi tabel po
        $sql = "SELECT sum(jumlah) as total FROM tmp_pengadaan WHERE no_po='$kodeBaru'";
		$Qry = mysqli_query($koneksidb,$sql);
		$total=mysqli_fetch_array($Qry);

		
		$upSql ="UPDATE po SET nm_bagian='$cmbBagian' WHERE no_po='$noTransaksi'";
		$upQry = mysqli_query($koneksidb,$upSql);
		if ($upQry){
					$slSql ="SELECT kd_gitar,jumlah,harga FROM tmp_pengadaan WHERE no_po='$noTransaksi'";
					$slQry = mysqli_query($koneksidb, $slSql);

					// $upSql ="UPDATE po_item SET harga='$_POST[edtKode]' WHERE kd_barang='$Kode'";
					// $upQry = mysqli_query($koneksidb,$upSql);

						while($myDatax = mysqli_fetch_array($slQry)){


							//select po_item where no_po and kd_barang
							$sl1Sql="SELECT po_item WHERE no_po='$noTransaksi' AND kd_gitar='$myDatax[kd_gitar]";
							$sl1Qry = mysqli_query($koneksidb, $sl1Sql);

							//if ada ==> updadte
							if ($sl1Qry) {
								$up1Sql = "UPDATE po_item SET jumlah='$myDatax[jumlah]',harga='$myDatax[harga_beli]' WHERE no_po='$noTransaksi' AND kd_barang='$myDatax[kd_barang]'";
								$up1Qry = mysqli_query($koneksidb, $up1Sql);
							} else {


							

							//else insert
							//isi detil
							$tmpInsert = "INSERT INTO po_item (no_po, kd_gitar, nm_gitar, jumlah, harga)
								VALUES ('$noTransaksi', '$myDatax[kd_gitar]',
								(select model from barang where kd_gitar='$myDatax[kd_gitar]'),
								'$myDatax[jumlah]',
								'$myDatax[harga]')";
							mysqli_query($koneksidb, $tmpInsert);
						}

							//update stok
							$tmpUpdate = "UPDATE barang SET jumlah=jumlah+'$myDatax[jumlah]' WHERE kd_gitar='$myDatax[kd_gitar]'";
							mysqli_query($koneksidb, $tmpUpdate);


						}

						//hapus tmp_pengadaan
						$tmpDelete = "DELETE FROM tmp_pengadaan WHERE kd_petugas='$userLogin'";
						$myQry = mysqli_query($koneksidb, $tmpDelete);

			//mengembalikan ke folder awal jika berhasil disimpan data
			echo "<meta http-equiv='refresh' content='0; url=".$baseURL."procurement/data'>";
		}
		exit;

		//mengisi tabel po_item
		//mengisi tabel









//FORM ISIAN DATA
		/*<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
		action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-"*/
	}
}
$kode = $_GET['kode'];

$mySql ="SELECT a.no_po, a.tgl_po, b.nm_bagian,b.kd_bagian, a.tanggal, a.total FROM po a LEFT JOIN bagian b ON a.nm_bagian=b.kd_bagian
	 WHERE a.no_po= '$kode'";
	$myQry = mysqli_query($koneksidb, $mySql);
	$nomor = $hal;
	//PERULANGAN DATA
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_po'];

$noTransaksi = $Kode;


$tglTransaksi = isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : $myData['tgl_po'];
$dataBagian = isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : $myData['kd_bagian'];
$dataNamaKategori = isset($_POST['txtNamaKategori']) ? $_POST['txtNamaKategori'] : '';
//$txtDivisiTujuan = isset($_POST['txtDivisiTujuan']) ? $_POST['txtDivisiTujuan'] : $myData['divisi_tujuan'];
$tSql = "INSERT INTO tmp_pengadaan(kd_gitar,no_po,jumlah,harga,kd_petugas) 
SELECT kd_gitar,no_po,jumlah,harga,'$userLogin' FROM po_item WHERE no_po='$noTransaksi'";
mysqli_query($koneksidb, $tSql);

//$tSql = "INSERT INTO tmp_pengadaan(kd_barang, no_po, jumlah, harga_beli)
//			SELECT kd_barang, no_po, jumlah, harga FROM po_item WHERE no_po='$noTransaksi'";



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
			text : '['+item.value+'] '+item.text

		}));
	});

  });
}
</script>
<script language="javascript">
	function modalEdit(kode,nama,harga,jumlah){
		document.getElementById('edtKode').value = kode;
		document.getElementById('edtNamaBarang').value = nama;
		document.getElementById('edtHarga').value = harga;
		document.getElementById('edtJumlah').value = jumlah;
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
			 <input type="text" name="noTransaksi" id="noTransaksi" value="<?php echo $noTransaksi; ?>" readonly="readonly" class="form-control" required="required" data-parsley-error-message="field ini harus diisi">
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
 
<!--large modal tambah jumlah data-->
<div class="modal fade modal-tambah<?php echo $noTransaksi; ?>" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span></button>
			<h4 class="modal-title" id="myModalLabel">Input Barang</h4>
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
			<label class="control-label">Harga<span class="required">*</span></label>
			<input type="text" name="edtHarga" id="edtHarga" class="form-control" required="required" data-parsley-error-message="field ini harus diisi">
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

<!--large modal tambah jumlah data-->




<!-- BATAS HEADER TITLE -->



<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
	action ="<?php $srever['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
	<input name="txtKode" type="hidden" value="<?php echo $noTransaksi; ?>">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">Kode</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" name="kode" id="kode" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $noTransaksi; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtTanggal">Tanggal PO<span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input id="txtTanggal" type="text" rows="3"  class="form-control" name="txtTanggal" data-parslay-error-message="field ini harus di isi" value="<?php echo $tglTransaksi; ?>" readonly="readonly"></input>
		</div>
	</div>
	 


	<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Bagian">Devisi Bagian<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select class="form-control" name="cmbBagian" required="" data-parslay-error-message="field ini harus di isi">
		<option value="kosong"></option>
		 <?php
		$mysql ="SELECT * FROM bagian ORDER BY nm_bagian";
		$myQry = mysqli_query($koneksidb, $mysql);
		while ($mydata = mysqli_fetch_array($myQry)){
			if ($mydata['kd_bagian']==$dataBagian) {
				$cek="selected";
			}else {$cek="";}
			echo "<option value='$mydata[kd_bagian]' $cek>$mydata[nm_bagian]</option>";
		}
		?> 
	</select>
	</div>
	</div>



 

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
			<th width="23" align="center"><strong>No</strong></th>
			<th width="51"><strong>Kode</strong></th>
			<th width="417"><strong>Model</strong></th>
			<th width="132">Harga</th>
			<th width="70" align="center"><strong>Jumlah</strong></th>
			<th width="100" align="center"><a href="<?php echo $baseURL;?>procurement/add" target"_self">
				  Tools</a></th>
			<th width="1">id</th>
		</tr>
	</thead>
	<tbody>
	<?php

	/* PENCARIAN BERDASARKA DATA DI TABEL*/
	$tmpSql ="SELECT tmp_pengadaan.*, barang.model FROM tmp_pengadaan, barang WHERE tmp_pengadaan.kd_gitar=gitar.kd_gitar AND tmp_pengadaan.kd_petugas='$userLogin' AND tmp_pengadaan.no_po='$noTransaksi' ORDER BY id";
	$tmpQry = mysqli_query($koneksidb, $tmpSql);
	$nomor =0; $subTotal=0; $totalBelanja=0; $qtyItem=0;
	//PERULANGAN DATA
	while ($tmpData = mysqli_fetch_array($tmpQry)) {
		$ID = $tmpData['id'];
		$qtyItem= $qtyItem + $tmpData['jumlah'];
		$subTotal= $subTotal + $tmpData['jumlah'];
		$totalBelanja= $totalBelanja + $subTotal;
		$nomor++;
		?>

	<!--MENAMPILKAN HASIL PENCARIAN DATABASE-->
	<tr>
		<td align="center"><?php echo $nomor;?></td>
		<td><?php echo $tmpData['kd_gitar']?></td>
		<td><?php echo $tmpData['model']?></td>
		<td><?php echo $tmpData['harga']?></td>
		<td align="center"><?php echo $tmpData['jumlah'];?></td>


		<td align="center">
			<?php if (!$_SESSION['SES_PENGGUNA']):?>
				<input type="button" onclick="modalEdit('<?php echo $tmpData[kd_gitar]?>','<?php echo $tmpData[model]?>','<?php echo $tmpData[harga]?>','<?php echo $tmpData[jumlah];?>')" data-toggle="modal" data-target=".modal-tambah<?php echo $noTransaksi; ?>"></input>
				<a href="<?php echo $baseURL;?>procurement/delete?kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Apakah anda yakin ingin menghapus data <?php echo $Kode; ?>')">
					<span class="fa fa-trash"></span></a>
				
				</td>
				<?php endif;?>

		<td><?php echo $myData['harga']?></td>
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
	<?php } ?>
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

	pagename='procurement/data';
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
	$('.btnEdit').on('click', function(){
		if( $('#edtNamaBarang').val() && $('#edtJumlah').val()) {
				$.post( "<?php echo $baseURL;?>library/api.modaledit.php",
			$( "#modalFormEdit" ).serialize(), function(data){
				if(data>0){

					nmbrg=$("#edtBarang option:selected").text().split(" ");

					tbl.row.add([
						tbl.rows().count()+1,
						$('#edtJumlah').val(),
						nmbrg[1],
						nmbrg[3],
						$('#edtHarga').val(),
						'<center><span class="fa fa-trash"></span></center>',
						data,
					] ).draw( false );
					$('#edtJumlah').val('');
					$('#edtHarga').val('');
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
