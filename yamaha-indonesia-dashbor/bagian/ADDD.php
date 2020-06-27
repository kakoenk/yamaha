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
<div class ="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>General <small>Suplier</small></h3>
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
if(isset($_POST['btnSimpan'])){
	/*untuk menerima parsing data dari form
	  nama $_POST['txtNama'] disesuaikan pada form yang kita buat dibawah dst.*/
	$txtSuplier = $_POST['txtSuplier']; //xyz
	$txtSuplier = str_replace("'","&acute;",$txtSuplier);//menghalangi penulisan tanda petik

	$txtKeterangan = $_POST['txtKeterangan'];
	$txtKeterangan = str_replace("'","&acute;",$txtKeterangan);//menghalangi penulisan tanda petik

	$txtAlamat = $_POST['txtAlamat']; 
	$txtAlamat = str_replace("'","&acute;",$txtAlamat);//menghalangi penulisan tanda petik

	$txtTelepon = $_POST['txtTelepon']; 
	$txtTelepon = str_replace("'","&acute;",$txtTelepon);//menghalangi penulisan tanda petik

	
	$cmbKategori = $_POST['cmbKategori'];

	/*batas untuk menerima parsing data dari form*/

	//untuk menampilkan pesan error nama variabel harus disesuaikan dengan yang atas

	$pesanError = array();
	if (trim($txtSuplier)==""){
		$pesanError[]="Nama Suplier<b>tidak boleh kosong !";
	}
	if (trim($txtKeterangan)==""){
		$pesanError[]="Data <b>Keterangan</b> tidak boleh kosong !";
	}
	if (trim($txtAlamat)==""){
		$pesanError[]="<b>Alamat</b> tidak boleh kosong !";
	}
	if (trim($txtTelepon)==""){
		$pesanError[]="Nomor <b>Telepon</b> tidak boleh kosong !";
	}
	if (trim($cmbKategori)==""){
		$pesanError[]="Data <b>Kategori</b> tidak boleh kosong !";
	}

	//batas untuk menampilkan pesan error

	//CEK APAKAH NAMA BARNG SUDAH ADA ATAU BELUM
	$sqlCek="SELECT * FROM suplier WHERE nm_Suplier='$txtSuplier'";
	$qryCek=mysqli_query($koneksidb, $sqlCek);

	//KALAU SUDAH ADA WARNING DAN KELUAR
	if(mysqli_num_rows($sqlCek)>=1){
		$pesanError[]= "Maaf, Nama Suplier <b> $txtSuplier </b> sudah dipakai, silahkan ganti dengan nama yang baru";
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

		$kodeSuplier = buatKode ("suplier","S");
		$path = realpath(dirname(__FILE__)).'/files/'.$kodeSuplier;
			mkdir($path);
		//untuk upload file jika diperlukan
		 


		//batas untuk upload file jika diperlukan  txtketerangan


	//mengisi tabel
		$mysql ="INSERT INTO suplier (kd_Suplier, nm_Suplier, keterangan, alamat, telepon, kd_Kategori)

		VALUES ('$kodeSuplier','$txtSuplier','$txtKeterangan','$txtAlamat','$txtTelepon','$cmbKategori')";

		$myQry = mysqli_query($koneksidb,$mysql);
		if ($myQry){
			//mengembalikan ke folder awal jika berhasil disimpan data
			echo "<meta http-equiv='refresh' content='0; url=".$baseURL."suplier/datasup'>";
		}
		exit;


//FORM ISIAN DATA
		/*<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
		action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-"*/
	}





}
?>					

<!-- BATAS HEADER TITLE -->

<form id="theform" data-parslay-validate class="form-horizontal form-label-left" 
	action ="<?php $srever['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama Suplier<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="first-name"  class="form-control col-md-7 col-xs-12" name="txtSuplier"
			 data-parsley-error-message="Field ini harus di isi">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="keterangan">Keterangan<span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<textarea id="keterangan" rows="3"  class="form-control" name="txtKeterangan" data-parslay-error-message="field ini harus di isi"><?php echo $dataKeterangan; ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="alamat">Alamat<span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="alamat"   class="form-control col-md-7 col-xs-12" name="txtAlamat" data-parslay-error-message="field ini harus di isi" value="<?php echo $dataAlamat;?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telepon">Telepon<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="text" id="telepon"   class="form-control col-md-7 col-xs-12" name="txtTelepon" data-parslay-error-message="field ini harus di isi" value="<?php echo $dataTelepon;?>">
	</div>
</div>
	
	<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori">Kategori<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select class="form-control" name="cmbKategori" required="" data-parslay-error-message="field ini harus di isi">
		<option value="kosong"></option>
		<?php 
		$mysql ="SELECT * FROM kategori ORDER BY nm_kategori";
		$myQry = mysqli_query($koneksidb, $mysql);
		while ($mydata = mysqli_fetch_array($myQry)){
			if ($myData['kd_kategori']==$dataKategori) {
				$cek="selected";
			}else {$cek="";}
			echo "<option value='$mydata[kd_kategori]' $cek>$mydata[nm_kategori]</option>";
		}
		?>
	</select>
	</div>
	</div>

	
	<div class="in-solid"></div>
	<div class="form-group">
	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
		<button type="button" class="btn btn-primary" onclick="goBack()">Cancel</button>
		<button type="submit" class="btn btn-success" name="btnSimpan">Simpan</button>
	</div>
</div>
</form>






					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include "base_template_footer.php";?>
</div>
</div>

<script src="<?php echo $baseURL;?>assets/others/parsleyjs/dist/parsley.min.js"></script>
<script src="<?php echo $baseURL;?>assets/js/fileinputx.min.js"></script>

<script>
	
	pagename='suplier/datasup';
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
	});
	
	 
</script>

</body>
