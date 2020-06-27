<body class="login">    
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
			<br><br><br><br>
			<!-- digunakan untuk menampilkan logo dengan nama logo.png -->
			<img src="assets/images/logomusic.png" width="300" height="130" alt="Logo">						
			<form name="logForm" id="theform" data-parsley-validate action="login_validasi" method="post">
				<div class="separator">
					<div class="clearfix"></div>
				</div>							
				<h2>
				<font color="#8A2BE2">PT.YAMAHA INDONESIA</font>
				</h2>
				<br />
				<!-- untuk menampilkan pesan error "Invalid Username or Password." yang dihasilkan dari 
					file login_validasi.php -->
				<?php if ($errormsg) { ?>
						<div class="alert alert-danger alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<strong>Error</strong>: <?php echo $errormsg;?>
						</div>                  		
				<?php } ?>              
				<div>
					<input type="text" class="form-control glyphicon-lock" placeholder="Username" required="required" name="txtUser"/>
				</div>
				<div>
					<input type="password" class="form-control" placeholder="Password" required="required" name="txtPassword"/>
				</div>
				<div>
					<input type="submit" class="btn btn-default submit" name="btnLogin" value="Log in" />
				</div>

				<div class="clearfix"></div>

				<div class="separator">
					<div class="clearfix"></div>
					<br />
					<div>
						<p>© 2020 All Rights Reserved.</p>
					</div>
				</div>
            </form>
          </section>
        </div>
      </div>
    </div>
</body>
