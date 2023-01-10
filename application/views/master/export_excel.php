<?php
include APPPATH.'third_party/PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$excel = new PHPExcel();
// Settingan awal fil excel
$excel->getProperties()->setCreator('TTL')
             ->setLastModifiedBy('TTL')
             ->setTitle($title)
             ->setSubject($title)
             ->setDescription($title)
             ->setKeywords($title);
// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = array(
  'font' => array('bold' => true), // Set font nya jadi bold
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);
// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);
$excel->setActiveSheetIndex(0)->setCellValue('A1', $title); // Set kolom A1 dengan tulisan "DATA TOTALIZER"
$excel->getActiveSheet()->mergeCells('A1:'.chr(ord('A')+count($columns)).'1'); // Set Merge Cell pada kolom A1 sampai E1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20); // Set font size 20 untuk kolom A1
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

// Buat header tabel nya pada baris ke 3
$cell_col = 'A';
$cell_row = 3;
$excel->setActiveSheetIndex(0)->setCellValue($cell_col.$cell_row, "NO"); // Set kolom A3 dengan tulisan "NO"
foreach ($columns as $key => $value) {
  $cell_col++;
  $excel->setActiveSheetIndex(0)->setCellValue($cell_col.$cell_row, $value); // Set kolom A3 dengan tulisan "NO"

  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
  $excel->getActiveSheet()->getStyle($cell_col.$cell_row, $value)->applyFromArray($style_col);
}

$cell_row = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
foreach($data as $no => $val){ // Lakukan looping pada variabel siswa
  $cell_col = 'A';
  $excel->setActiveSheetIndex(0)->setCellValue($cell_col.$cell_row, $no+1); // Set kolom A3 dengan tulisan "NO"
  $excel->getActiveSheet()->getStyle($cell_col.$cell_row)->applyFromArray($style_row);
  foreach ($columns as $key => $value) {
    $cell_col++;
    $excel->setActiveSheetIndex(0)->setCellValue($cell_col.$cell_row, $val->{$value}); // Set kolom A3 dengan tulisan "NO"

    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle($cell_col.$cell_row)->applyFromArray($style_row);
  }
  
  $cell_row++; // Tambah 1 setiap kali looping
}

// Set width kolom
$cell_col = 'A';
$excel->getActiveSheet()->getColumnDimension($cell_col)->setWidth(5); // Set width kolom A
foreach ($columns as $key => $value) {
  $cell_col++;
  $excel->getActiveSheet()->getColumnDimension($cell_col)->setWidth(30); // Set width kolom D
}

// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Rekap");
$excel->setActiveSheetIndex(0);
// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.str_replace(' ', '_', $title).'.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');