<?php
if(!defined('OFFDIRECT')) include 'error404.php';
/* Jika pengguna sudah LOGIN maka akan eksekusi script pada baris ke-4 hingga baris ke-49*/
if(isset($_SESSION['SES_LOGIN'])) {
?>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
<?php
	include "menu.php";	 //akan memanggil file menu.php sebagai pembuatan menu
	include "base_template_topnav.php";	 //akan memanggil file base_template_topnav.php sebagai header
?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Home</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Selamat Datang</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<!-- UNTUK HOME sesuai dengan keinginan -->
						 
                  </div>                  
                </div>
              </div>
            </div>
          </div>
        </div>
<?php
	include "base_template_footer.php";	//akan memanggil base_template_footer.php sebagai footer
?>
      </div>
    </div>
    <script>
    	pagename='main'; //default eksekusi diberi nama "main"
    </script>
</body>    
<?php
} else {
	//jika tidak melakukan proses login maka akan selalu diarahkan untuk melakukan proses login terbelih dahulu
	include "login.php";	
}
?>