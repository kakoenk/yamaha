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
				<h3>General <small>Petugas</small></h3>
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
	$txtNik = $_POST['txtNik']; //xyz
	$txtNik = str_replace("'","&acute;",$txtNik);//menghalangi penulisan tanda petik

	$txtNama = $_POST['txtNama']; //xyz
	$txtNama = str_replace("'","&acute;",$txtNama);//menghalangi penulisan tanda petik

	$txtTelepon = $_POST['txtTelepon'];
	$txtTelepon = str_replace("'","&acute;",$txtTelepon);//menghalangi penulisan tanda petik

	$txtUsername = $_POST['txtUsername']; 
	$txtUsername = str_replace("'","&acute;",$txtUsername);//menghalangi penulisan tanda petik

	$txtPass = $_POST['txtPass']; 
	$txtPass = str_replace("'","&acute;",$txtPass);//menghalangi penulisan tanda petik

	$cmbLevel   = $_POST['cmbLevel'];
	$cmbJns = $_POST['cmbLevel'];

	$cmbJns   = $_POST['cmbJns'];
	$cmbJns = $_POST['cmbJns'];


	$txtAlamat = $_POST['txtAlamat']; 
	$txtAlamat = str_replace("'","&acute;",$txtAlamat);//menghalangi penulisan tanda petik

	$cmbBagian = $_POST['cmbBagian'];
	$cmbBagian = str_replace("'","&acute;",$cmbBagian);

	/*batas untuk menerima parsing data dari form*/

	//untuk menampilkan pesan error nama variabel harus disesuaikan dengan yang atas
 
	$pesanError = array();
	if (trim($txtNik)==""){
		$pesanError[]="Nik Petugas<b>tidak boleh kosong !";
	}
	if (trim($txtNama)==""){
		$pesanError[]="Nama Petugas<b>tidak boleh kosong !";
	}
	if (trim($txtTelepon)==""){
		$pesanError[]="Nomor telepon <b>Keterangan</b> tidak boleh kosong !";
	}
	if (trim($txtUsername)==""){
		$pesanError[]="Username <b>Merk</b> tidak boleh kosong !";
	}
	if (trim($txtPass)==""){
		$pesanError[]="Password <b>Harga</b> tidak boleh kosong !";
	}
	if (trim($cmbLevel)==""){
		$pesanError[]="Level <b>Satuan Barang</b> tidak boleh kosong !";
	}
	if (trim($cmbJns)==""){
		$pesanError[]="Jenis kelamin <b>Kategori</b> tidak boleh kosong !";
	}	
	if (trim($txtAlamat)==""){
		$pesanError[]="Alamat tidak boleh kosong !";
	}
	if (trim($cmbBagian)==""){
		$pesanError[]="Bagian tidak boleh kosong !";
	}


	//batas untuk menampilkan pesan error

	//CEK APAKAH NAMA SUDAH ADA ATAU BELUM
	$sqlCek="SELECT * FROM petugas WHERE kd_petugas='$txtNik'";
	$qryCek=mysqli_query($koneksidb, $sqlCek);

	//KALAU SUDAH ADA WARNING DAN KELUAR
	if(mysqli_num_rows($sqlCek)>=1){
		$pesanError[]= "Maaf, Nik <b> $txtNik </b> sudah dipakai, silahkan ganti dengan nik yang baru";
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

		//$kodepetugas = buatKode ("petugas","P");
		

	//mengisi tabel
		$mysql ="INSERT INTO petugas (kd_petugas, nm_petugas, no_telepon, username, password, level, jns_kelamin, alamat, kd_bagian)

		VALUES ('$txtNik','$txtNama','$txtTelepon','$txtUsername',md5('$txtPass'),'$cmbLevel','$cmbJns','$txtAlamat','$cmbBagian')";

		$myQry = mysqli_query($koneksidb,$mysql);
		if ($myQry){
			//mengembalikan ke folder awal jika berhasil disimpan data
			echo "<meta http-equiv='refresh' content='0; url=".$baseURL."petugas/data'>";
		}
		


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
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nik Petugas<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="txtNik"  class="form-control col-md-7 col-xs-12" name="txtNik"
			 data-parsley-error-message="Field ini harus di isi">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama Petugas<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="first-name"  class="form-control col-md-7 col-xs-12" name="txtNama"
			 data-parsley-error-message="Field ini harus di isi">
		</div>
	</div>

	

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="keterangan">Telepon<span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="tel" id="telepon" class="form-control" name="txtTelepon" data-parslay-error-message="field ini harus di isi"><?php echo $dataTelepon; ?></input>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="merk">User Name<span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="merk"   class="form-control col-md-7 col-xs-12" name="txtUsername" data-parslay-error-message="field ini harus di isi" value="<?php echo $dataMerek;?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="merk">Password<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="password" id="harga"   class="form-control col-md-7 col-xs-12" name="txtPass" data-parslay-error-message="field ini harus di isi" value="<?php echo $dataHarga;?>">
	</div>
</div>
	
	<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="satuan">Level<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select id="satuan" class="form-control" name="cmbLevel"  data-parslay-error-message="field ini harus di isi">
		<option value="kosong"></option>
		<option value="admin">admin</option>
		<option value="user">user</option>
		<option value="pimpinan">pimpinan</option>
	</select>
	</div>
	</div>
	<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori">Jenis Kelamin<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select class="form-control" name="cmbJns" required="" data-parslay-error-message="field ini harus di isi">
		<option value="kosong"></option>
		<option value="laki-laki">Laki-laki</option>
		<option value="perempuan">Perempuan</option>
	</select>
	</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="merk">Alamat<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="text" id="alamat"   class="form-control col-md-7 col-xs-12" name="txtAlamat" data-parslay-error-message="field ini harus di isi" value="<?php echo $txtAlamat;?>">
	</div>
</div>
<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori">Bagian<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select class="form-control" name="cmbBagian" required="" data-parslay-error-message="field ini harus di isi">
		<option value="kosong"></option>
		<?php 
		$mysql ="SELECT * FROM bagian ORDER BY nm_bagian";
		$myQry = mysqli_query($koneksidb, $mysql);
		while ($mydata = mysqli_fetch_array($myQry)){
			if ($myData['kd_bagian']==$dataKategori) {
				$cek="selected";
			}else {$cek="";}
			echo "<option value='$mydata[kd_bagian]' $cek>$mydata[nm_bagian]</option>";
		}
		?>
	</select>
	</div>
	</div>
v
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
	
</script>

</body>
