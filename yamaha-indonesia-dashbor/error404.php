<?php 
header("HTTP/1.0 404 Not Found");
$baseURL = 'http://'.$_SERVER['SERVER_NAME'].'/inventory/';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory</title>
    <link href="<?php echo $baseURL; ?>assets/others/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $baseURL; ?>assets/others/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $baseURL; ?>assets/css/custom.min.css" rel="stylesheet">
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center text-center">
              <h1 class="error-number">404</h1>
              <h2>Siapin dulu dong codingnya</h2>
              <p>This page you are looking for does not exist, <a href="<?php echo $baseURL; ?>main">Log in?</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php die();?>