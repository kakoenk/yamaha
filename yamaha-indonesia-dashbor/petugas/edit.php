
<script src="<?php echo $baseURL; ?>includes/ckeditor/ckeditor.js"></script>
<script src="<?php echo $baseURL; ?>includes/ckfinder/ckfinder.js"></script>
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
				<h3>General <small>Petugas</small></h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Data Petugas <small>Edit</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="=x_content">
<?php
if(isset($_POST['btnSimpan'])){
	/*untuk menerima parsing data dari form
	  nama $_POST['txtNama'] disesuaikan pada form yang kita buat dibawah dst.*/
	$txtNama = $_POST['txtNama']; //xyz
	$txtNama = str_replace("'","&acute;",$txtNama);//menghalangi penulisan tanda petik

	$txtTelepon = $_POST['txtTelepon'];
	$txtTelepon = str_replace("'","&acute;",$txtTelepon);//menghalangi penulisan tanda petik

	$txtUsername = $_POST['txtUsername']; 
	$txtUsername = str_replace("'","&acute;",$txtUsername);//menghalangi penulisan tanda petik

	$txtPass = $_POST['txtPass']; 
	$txtPass = str_replace("'","&acute;",$txtPass);//menghalangi penulisan tanda petik

	$cmbLevel   = $_POST['cmbLevel'];
	$cmbJns = $_POST['cmbJns'];

	$txtalamat = $_POST['txtalamat']; 
	$txtalamat = str_replace("'","&acute;",$txtalamat);//menghalangi penulisan tanda petik


	/*batas untuk menerima parsing data dari form*/

	//untuk menampilkan pesan error nama variabel harus disesuaikan dengan yang atas

	$pesanError = array();
	if (trim($txtNama)==""){
		$pesanError[]="Nama Petugas<b>tidak boleh kosong !";
	}
	if (trim($txtTelepon)==""){
		$pesanError[]="Nomor telepon <b>Keterangan</b> tidak boleh kosong !";
	}
	if (trim($txtUsername)==""){
		$pesanError[]="Username tidak boleh kosong !";
	}
	if (trim($cmbLevel)==""){
		$pesanError[]="Level tidak boleh kosong !";
	}
	if (trim($cmbJns)==""){
		$pesanError[]="Jenis kelamin tidak boleh kosong !";
	}
	if (trim($txtalamat)==""){
		$pesanError[]="Alamat  tidak boleh kosong !";
	}

	//batas untuk menampilkan pesan error
	$Kode = $_POST['txtKode'];

	//CEK APAKAH NAMA BARNG SUDAH ADA ATAU BELUM
	$sqlCek="SELECT * FROM petugas WHERE nm_petugas='$txtNama'NOT (kd_petugas='$kode')";
	$qryCek=mysqli_query($koneksidb, $sqlCek);

	//KALAU SUDAH ADA WARNING DAN KELUAR
	if(mysqli_num_rows($sqlCek)>=1){
		$pesanError[]= "Maaf, Nama Barang <b> $txtNama </b> sudah dipakai, silahkan ganti dengan nama yang baru";
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

		$kodeBarang = $_POST['txtKode'];
		$path = realpath(dirname(__FILE__)).'/files/'.$kode;
		$mysql ="SELECT * FROM barang WHERE kd_barang='$kode'";
		$myQry=mysqli_query($koneksidb, $mySql);
		$myData= mysqli_fetch_array($myQry);
		$myfiles=($myData['files'])? json_decode($myData['files']) : array ();
		foreach ($myfiles as $afile){
			if(!in_array($afile, $_REQUEST['myfiles'])) unlink("$path/$afile");
		}
		$myfiles= ($_REQUEST['myfiles']) ? $_REQUEST['myfiles'] : array();
		$files = '';
		$newfiles= array();
		if ($_FILES['Uploadfiles']['name'][0]!=''){

			mkdir($path);
			
		
		//untuk upload file jika diperlukan
			$newfiles = $_FILES['Uploadfiles']['name'];
		
		 for ($i=0; $i<count($_FILES['Uploadfiles']['name']);$i++){
				move_uploaded_file($_FILES["Uploadfiles"]["tmp_name"][$i],$path.'/'.$_FILES['Uploadfiles']['name'][$i]);
			}
		}
		$files= json_encode(array_merge($myfiles, $newfiles));


		//batas untuk upload file jika diperlukan  txtketerangan
	//mengisi tabel
	 if ($txtPass==""){
			$mySql = "UPDATE petugas SET nm_petugas='$txtNama',
			 no_telepon='$txtTelepon', username='$txtUsername',
			 level='$cmbLevel', jns_kelamin='$cmbJns', alamat='$txtalamat'
			 WHERE kd_petugas='$Kode'";
			 $myQry = mysqli_query($koneksidb,$mySql);
	} else {
			$mysql = "UPDATE petugas SET nm_petugas='$txtNama', 
			no_telepon='$txtTelepon', username='$txtUsername', 
			password=md5('$txtPass'), level='$cmbLevel', jns_kelamin='$cmbJns',
			alamat='$txtalamat' WHERE kd_petugas='$Kode'";
			$myQry = mysqli_query($koneksidb,$mysql);
		}

	 
		if ($myQry){
			//mengembalikan ke folder awal jika berhasil disimpan data
			echo "<meta http-equiv='refresh' content='0; url=".$baseURL."petugas/data'>";
		}
		exit;


//FORM ISIAN DATA
		/*<form id="theform" data-parslay-validate class="form-horizontal form-label-left"
		action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-"*/
	}

}

$kode = $_GET['kode'];
if ($kode) {
	$mysql = "SELECT * FROM petugas WHERE kd_petugas='$kode'";
	$myQry = mysqli_query($koneksidb, $mysql);
	$myData= mysqli_fetch_array($myQry);
	//data nama akan diguanakan pada form
	$dataKode = $myData['kd_petugas'];
	$dataNama =isset ($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_petugas'];
	$dataTelepon = isset ($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	$dataUsername = isset ($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
	$dataPass = isset ($_POST['txtPass']) ? $_POST['txtPass'] : $myData['password'];
	$dataLevel = isset ($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $myData['level'];
	$dataJns = isset ($_POST['cmbJns']) ? $_POST['cmbJns'] : $myData['jns_kelamin'];
	$dataAlamat = isset ($_POST['txtalamat']) ? $_POST['txtalamat'] : $myData['alamat'];
	

?>					

<!-- BATAS HEADER TITLE -->

<form id="theform" data-parslay-validate class="form-horizontal form-label-left" 
	action ="<?php $srever['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
	<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">Kode Petugas</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="kode" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $dataKode; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama Petugas<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="first-name"  class="form-control col-md-7 col-xs-12" name="txtNama"
			 data-parsley-error-message="Field ini harus di isi" value="<?php echo $dataNama ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="keterangan">Telepon<span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="telepon"   class="form-control col-md-7 col-xs-12" name="txtTelepon" data-parslay-error-message="field ini harus di isi" value="<?php echo $dataTelepon;?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="merk">Username<span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="username"   class="form-control col-md-7 col-xs-12" name="txtUsername" data-parslay-error-message="field ini harus di isi" value="<?php echo $dataUsername;?>">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="password" id="password"   class="form-control col-md-7 col-xs-12" name="txtPass" data-parslay-error-message="field ini harus di isi">
	</div>
</div>
	
	<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="level">Level<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select id="level" class="form-control" name="cmbLevel"  data-parslay-error-message="field ini harus di isi">
		<option value="kosong"></option>
		<option value="Admin">Admin</option>
		<option value="user">User</option>
	</select>
	</div>
	</div>
	<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="jns_kelamin">Jenis Kelamin<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select class="form-control" name="cmbJns" required="" data-parslay-error-message="field ini harus di isi">
		<option value="kosong"></option>
		<option value="laki-laki">Laki-laki</option>
		<option value="Perempuan">Perempuan</option>
	</select>
	</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="alamat">Alamat<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="text" id="alamat"   class="form-control col-md-7 col-xs-12" name="txtalamat" data-parslay-error-message="field ini harus di isi" value="<?php echo $dataAlamat;?>">
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
	
	pagename='petugas/data';
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
<script type="text/javascript">
	if(typeof CKEDITOR == 'undefined')
	{
		document.write(
			'<strong><span style="color: #ff0000">Error</span>:CKEditor not found</strong>.'+
			'This sample assumes that CKEditor (not included with CKFinder)is installed in'+
			'the "/ckeditor/" path. if you have it installed in a different place, just edit'+
			'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the"BasePath"'+
			'value (line 32).');
	} else {
		var editor = CKEDITOR.replace('keterangan');
		CKFinder.setupCKEditor( editor, '<?php echo $baseURL; ?>includes/ckfinder/' ) ;
	}
</script>

</body>


