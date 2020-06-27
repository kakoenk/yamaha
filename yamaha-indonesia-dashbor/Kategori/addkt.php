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
				<h3>General <small>Model</small></h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Data Model <small>Add</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="=x_content">
<?php
if(isset($_POST['btnSimpan'])){
	/*untuk menerima parsing data dari form
	  nama $_POST['txtNama'] disesuaikan pada form yang kita buat dibawah dst.*/
	$txtKategori = $_POST['txtKategori']; //xyz
	$txtKategori = str_replace("'","&acute;",$txtKategori);//menghalangi penulisan tanda petik
 
	 
	//untuk menampilkan pesan error nama variabel harus disesuaikan dengan yang atas

	$pesanError = array();
	if (trim($txtKategori)==""){
		$pesanError[]="Silahkan tambah kategori";
	}
	//batas untuk menampilkan pesan error

	//CEK APAKAH NAMA BARNG SUDAH ADA ATAU BELUM
	$sqlCek="SELECT * FROM kategori WHERE nm_model='$txtKategori'";
	$qryCek=mysqli_query($koneksidb, $sqlCek);

	//KALAU SUDAH ADA WARNING DAN KELUAR
	if(mysqli_num_rows($sqlCek)>=1){
		$pesanError[]= "Maaf, Nama Kategori <b> $txtKategori </b> sudah dipakai, silahkan ganti dengan nama yang baru";
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

		$kodeKategori = buatKode ("kategori","K");
		
		//untuk upload file jika diperlukan
		 
		}


		//batas untuk upload file jika diperlukan  txtketerangan


	//mengisi tabel
		$mysql ="INSERT INTO kategori (kd_model, nm_model)

		VALUES ('$kodeKategori','$txtKategori')";

		$myQry = mysqli_query($koneksidb,$mysql);
		if ($myQry){
			//mengembalikan ke folder awal jika berhasil disimpan data
			echo "<meta http-equiv='refresh' content='0; url=".$baseURL."kategori/kategori'>";
		}
		exit;


//FORM ISIAN DATA
		/*<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
		action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-"*/
	}






?>					

<!-- BATAS HEADER TITLE -->

<form id="theform" data-parslay-validate class="form-horizontal form-label-left" 
	action ="<?php $srever['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model Piano<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="first-name"  class="form-control col-md-7 col-xs-12" name="txtKategori"
			 data-parsley-error-message="Field ini harus di isi">
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



</body>
