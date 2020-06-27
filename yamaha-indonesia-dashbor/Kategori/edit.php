<?php if (!defined('OFFDIRECT')) include '../error404.php';?>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">

<?php 
include_once "library/inc.seslogin.php";
if (!$_SESSION['SES_ADMIN'] && !$_SESSION['SES_PETUGAS']){
	echo "<meta http-equiv='refresh' content='0; url=".$baseURL."'>";
	exit;
}
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
						<h2>Data Model <small>Edit</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="=x_content">
<?php
if(isset($_POST['btnSimpan'])){
		/*untuk menerima parsing data dari form
		  nama $_POST['txtNama'] disesuaikan pada form yang kita buat dibawah dst.*/
		$txtKategori = $_POST['txtKategori']; //xyz
		$txtKategori = str_replace("'","&acute;",$txtKategori);//menghalangi penulisan tanda petik

		/*batas untuk menerima parsing data dari form*/

		//untuk menampilkan pesan error nama variabel harus disesuaikan dengan yang atas

		$pesanError = array();
		if (trim($txtKategori)==""){
			$pesanError[]="Nama model<b>tidak boleh kosong !";
		}

		//batas untuk menampilkan pesan error
		$Kode = $_POST['txtKode'];

		//CEK APAKAH NAMA BARNG SUDAH ADA ATAU BELUM
		$sqlCek="SELECT * FROM model WHERE nm_model='$txtKategori' NOT (kd_model='$Kode')";
		$qryCek=mysqli_query($koneksidb, $sqlCek);

		//KALAU SUDAH ADA WARNING DAN KELUAR
		if(mysqli_num_rows($sqlCek)>=1){
			$pesanError[]= "Maaf, Nama Model <b> $txtKategori </b> sudah dipakai, silahkan ganti dengan nama model yang baru";
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

		//untuk upload file jika diperlukan


		//batas untuk upload file jika diperlukan  txtketerangan


	//mengisi tabel
		$mysql ="UPDATE model SET nm_model='$txtKategori' WHERE kd_model='$Kode'";

	 

		$myQry = mysqli_query($koneksidb,$mysql);
		if ($myQry){
			//mengembalikan ke folder awal jika berhasil disimpan data
			echo "<meta http-equiv='refresh' content='0; url=".$baseURL."Kategori/kategori'>";
		}
		exit;


//FORM ISIAN DATA
		/*<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
		action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-"*/
	}

}

$Kode = $_GET['kode'];
if ($Kode) {
	$mysql = "SELECT * FROM model WHERE kd_model='$Kode'";
	$myQry = mysqli_query($koneksidb, $mysql);
	$myData= mysqli_fetch_array($myQry);
	//data nama akan diguanakan pada form
	$dataKode = $myData['kd_model'];
	$dataKategori =isset ($_POST['txtKategori']) ? $_POST['txtKategori'] : $myData['nm_model'];

?>					

<!-- BATAS HEADER TITLE -->

<form id="theform" data-parslay-validate class="form-horizontal form-label-left" 
	action ="<?php $srever['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
	<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">Kode</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="kode" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $dataKode; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model Piano<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="first-name"  class="form-control col-md-7 col-xs-12" name="txtKategori"
			 data-parsley-error-message="Field ini harus di isi" value="<?php echo $dataKategori ?>">
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
<?php } else { ?>
<div class="alert alert-danger alert-dismissible fade in" role="alert">
<button type="button" class="Close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
<strong>Error</strong></br>Missing Parameter!
</div>
<?php } ?>







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
	
	pagename='Kategori/kategori';
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
	
	 var myfiles = [];
	 $(".myfiles").each(function(){
	 	myfiles.push($(this).val());
	 });
	 var finitialPreview =[];
	 var finitialPreviewConfig=[];
	 $.each( myfiles, function(key, value){
	 	finitialPreview.push("<?php echo 'files/'.$dataKode.'/'?>"+value);
	 	finitialPreviewConfig.push({"caption": value, "key": value});
	 });
	 $(document).on('ready', function(){
	 	$("#Uploadfiles").fileinput({
	 		initialPreview: finitialPreview,
	 		initialPreviewAsData: true,
	 		initialPreviewConfig: finitialPreviewConfig,
	 		overwriteInitial: false,
	 		maxFileSize:1000,
	 		showUpload:false
	 	});
	 	$("#Uploadfiles").on('filedeleted', function(event, key){
	 		console.log(key);
	 		$(".myfiles").each(function(){
	 			if ($(this).val()==key) $(this).remove();
	 		});
	 	});
	 });
</script>

</body>

