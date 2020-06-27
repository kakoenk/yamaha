<?php
if (PHP_SAPI=='cli') die ();
if (empty ($_SESSION ['SES_LOGIN'])) die ();
require_once 'library/Classes/PHPExcel.php';

$title = "STOCK BARANG";

//creat new php excel
$objPHPExcel = new PHPExcel();

//set document properties
$objPHPExcel->getProperties()->setCreator("ymmi")
							 ->setLastModifiedBy("ymmi")
							 ->setTitle("$title")
							 ->setSubject("$title")
							 ->setDescription("$title")
							 ->setKeywords("$title")
							 ->setCategory("$title");

//add some data
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1','No')
			->setCellValue('B1','Kode')
			->setCellValue('C1','Cabinet')
			->setCellValue('D1','Model')
			->setCellValue('E1','Jumlah');
// SELECT tabel1.*, tabel2.*
// FROM tabel1 RIGHT JOIN tabel2
// ON tabel1.PK=tabel2.FK;
$mySql = "SELECT kategori.*, barang.* FROM kategori RIGHT JOIN barang ON kategori.kd_model=barang.kd_model";
$myQry = mysqli_query($koneksidb, $mySql);
$nomor = 0;
$row   = 1;
while ($myData = mysqli_fetch_array($myQry)){
	$nomor++;
	$row++;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$row, $nomor)
				->setCellValue('B'.$row, $myData['kd_barang'])
				->setCellValue('C'.$row, $myData['cabinet'])
				->setCellValue('D'.$row, $myData['nm_model'])
				->setCellValue('E'.$row, $myData['jumlah']);
}
//style formating excel
$objPHPExcel->getActiveSheet()->getStyle("A1:E1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->getAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->getAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->getAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->getAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->getAutoSize(true);

// RENAME WORKSHEET
$objPHPExcel->getActiveSheet()->setTitle($title);

//set active sheet index to the first sheet, so excel open this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//redirect output to a client web browser (excel 5)
header('Content-Type: application/vdn.ms-excel');
header ('Content-Disposition: attachement; filename="'.$title.'.xls"');
header('Cache-Control: max-age=0');
//if youre serving to 1E 9 then following may be needed
header('Cache-Control : max-age1');
//if youre serving to 1e over ssl, than the following may be needed
header('Experies : Mon, 1 Jan 1999 00:00 GMT');//DATE IN THE
header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');//always modified
header('Cache-Control : cache, must-revalidate');//HTTP1.1
header('Pragma : public'); //HTTP 1.0

$objWriter = PHPExcel_IOFactory ::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

