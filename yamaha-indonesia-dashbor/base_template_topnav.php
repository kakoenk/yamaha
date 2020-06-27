<div class="top_nav">
  <div class="nav_menu">
	<nav>
	  <div class="nav toggle">
		<a id="menu_toggle"><i class="fa fa-bars"></i></a>
	  </div>
	  <ul class="nav navbar-nav navbar-right">
		<li class="">
		  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		  <!-- digunakan untuk menampilkan gambar user							untuk menampilkan nama pengguna sesuai dengan 
																				proses pada file login_validasi.php -->
			<img src="<?php echo $baseURL; ?>assets/images/user.jpg" alt=""><?php echo ucwords($_SESSION['SES_NAME']);?>
			<span class=" fa fa-angle-down"></span>
		  </a>
		  <ul class="dropdown-menu dropdown-usermenu pull-right">
			<!-- proses ini memanggil file logout.php -->
			<li><a href="<?php echo $baseURL;?>logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
		  </ul>
		</li>
	  </ul>
	</nav>
  </div>
</div>
