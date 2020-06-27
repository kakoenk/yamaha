<?php
if (PHP_SAPI == 'cli') die();
if(empty($_SESSION['SES_LOGIN'])) die();

$tglAwal	= "01-".date('m-Y');
$tglAkhir	= date('d-m-Y');
$tglAwal 	= isset($_POST['tglAwal']) ? $_POST['tglAwal'] : $tglAwal;
$tglAkhir 	= isset($_POST['tglAkhir']) ? $_POST['tglAkhir'] : $tglAkhir; 

require_once 'library/Classes/PHPExcel.php';

$title = "Placement_Period";

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Inventory")
							 ->setLastModifiedBy("Inventory")
							 ->setTitle($title)
							 ->setSubject($title)
							 ->setDescription($title)
							 ->setKeywords($title)
							 ->setCategory($title);

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'No. Transaksi')
            ->setCellValue('D1', 'Keterangan')
            ->setCellValue('E1', 'Lokasi')
            ->setCellValue('F1', 'Qty Barang');

$filterSQL = "WHERE ( tgl_penempatan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
$mySql = "SELECT penempatan.*, lokasi.nm_lokasi FROM penempatan 
				LEFT JOIN lokasi ON penempatan.kd_lokasi=lokasi.kd_lokasi 
				$filterSQL
				ORDER BY penempatan.no_penempatan DESC";
$myQry 	= mysqli_query($koneksidb, $mySql);
$nomor  = 0; 
$row		= 1;
while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
	$row++;	
	$noNota = $myData['no_penempatan'];
	$my2Sql = "SELECT COUNT(*) AS total_barang FROM penempatan_item WHERE no_penempatan='$noNota'";
	
	$my2Qry = mysqli_query($koneksidb, $my2Sql);
	$my2Data = mysqli_fetch_array($my2Qry);
	
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$row, $nomor)
            ->setCellValue('B'.$row, IndonesiaTgl($myData['tgl_penempatan']))
            ->setCellValue('C'.$row, $myData['no_penempatan'])
            ->setCellValue('D'.$row, $myData['keterangan'])
            ->setCellValue('E'.$row, $myData['nm_lokasi'])
            ->setCellValue('F'.$row, $my2Data['total_barang']);
                        
}

// style formatting
$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle($title);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$title.'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 1 Jan 1999 00:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
