<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
/* penyesuaian folder aplikasi yang akan kita buat. 
  pada kasus ini kita berada pada folder PW */
$baseURL = 'http://'.$_SERVER['SERVER_NAME'].'/yamaha-indonesia-dashbor/';
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $_GET);

/* untuk mengambil file hasil parsing, jika tidak ada file pada URL yang diambil,
  maka untuk default yang akan dijalankan adalah main.php */
$filename = $_SERVER['QUERY_STRING'];
if ($filename=="") $filename='main';
define('OFFDIRECT', TRUE);

/* jika ada file, maka yang akan dijalankan adalah file tersebut */
$filename = trim($filename,'/');
$filename=$filename.'.php';

/* jika file tidak ditemukan maka yang akan dijalankan ada file error404.php */
if (!file_exists($filename)) include 'error404.php';

session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

date_default_timezone_set("Asia/Jakarta");  

if(strpos(strtolower($filename), 'report_xls') !== false) {
  include $filename;
  exit;
} 
ob_start("ob_html_compress"); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/images/logoyamaha.png">
    <title>YI-ADMIN</title>
  
  <!-- mengambil lokasi file referensi dari hasil download template  -->
    <link href="<?php echo $baseURL; ?>assets/others/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $baseURL; ?>assets/others/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $baseURL; ?>assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo $baseURL; ?>assets/css/custom.css" rel="stylesheet">   
  <script>
    function goBack() {
      window.history.back()
    }
  </script>    
  </head>
  <!-- menjalankan file yg diterima dari hasil URL -->
  <?php include $filename; ?>    
</html> 

<?php
ob_end_flush();
/*
function ob_html_compress($buf){
    return preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),
      array('',' '),
      str_replace(array("\n","\r","\t"),'',$buf));
}
*/
?>
