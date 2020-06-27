<?php
if(!defined('OFFDIRECT')) include 'error404.php';
include_once "library/inc.seslogin.php";
if (!$_SESSION['SES_ADMIN']) {
	echo "<meta http-equiv='refresh' content='0; url=".$baseURL."'>";
	exit;
}

set_time_limit(0);

if(isset($_POST['btnBackupDB'])) {
	$ofile=realpath(dirname(__FILE__)).'/files/'.'dbinventory'.date("Ymd").'.sql';
	
	$result = mysqli_query($koneksidb,"SHOW VARIABLES LIKE 'basedir'");
	$row = mysqli_fetch_assoc($result);
	$mysqlpath=$row['Value'].'/bin/';
	exec($mysqlpath."mysqldump --user={$myUser} --password={$myPass} {$myDbs} > $ofile");
	
 if (file_exists($ofile)) {
 		header_remove(); 
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($ofile).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($ofile)); 
    readfile($ofile); 
    die();
  }	
}
	
if(isset($_POST['btnRestoreDB'])) {
	$result = mysqli_query($koneksidb,"SHOW VARIABLES LIKE 'basedir'");
	$row = mysqli_fetch_assoc($result);
	$mysqlpath=$row['Value'].'/bin/';
	exec($mysqlpath."mysql --user={$myUser} --password={$myPass} {$myDbs} < ".$_FILES['file']['tmp_name']);	
}	
?>
<body class="nav-md">
<style>
.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}            
</style>
	<div class="container body">
		<div class="main_container">
<?php
	include "menu.php";	
	include "base_template_topnav.php";	
?>
		<link href="<?php echo $baseURL;?>/assets/css/fileinput.min.css" rel="stylesheet">

        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Maintenance</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Backup Database</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
										<form id="theform" data-parsley-validate class="form-horizontal form-label-left" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													<button type="submit" class="btn btn-success" name="btnBackupDB">Backup Database</button>
												</div>
											</div>
										</form>

                  </div>                  
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Restore Database</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
										<form id="theform2" data-parsley-validate class="form-horizontal form-label-left" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
											<input type="hidden" name="btnRestoreDB" />
											<?php if(!isset($_POST['btnRestoreDB'])) {?>
											<div class="fileUpload btn btn-primary">
													<span>Restore Database</span>
													<input type="file" class="upload" name="file" id="file"/>
											</div>											
											<?php } else {?>
											<button type="button" class="btn btn-primary" name="btnRestoreDB" disabled>Restore Database</button>
											<?php }?>
											
										</form>                  
                  </div>                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
<?php
	include "base_template_footer.php";	
?>
      </div>
    </div>
    <script>
    	pagename='dbmaintenance';
<?php if(!isset($_POST['btnRestoreDB'])) {?>
			document.getElementById("file").onchange = function() {
					document.getElementById("theform2").submit();
			}    	
<?php } ?>
    </script>
    <!-- Parsley -->
    <script src="<?php echo $baseURL;?>assets/others/parsleyjs/dist/parsley.min.js"></script>
		<script src="<?php echo $baseURL;?>assets/js/fileinputx.min.js"></script>
    
</body>    
