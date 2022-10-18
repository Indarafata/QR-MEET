<?php
/**
 * Description of Export Controller
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Export_Excel extends CI_Controller {
  // construct
    public function __construct() {
        parent::__construct();
    // load model
        $this->load->model('Export_Excel_Model', 'export');
    }    
   // export xlsx|xls file
    public function index() {
        $data['page'] = 'export-excel';
        $data['title'] = 'Export Excel data | TechArise';
        $data['info'] = $this->export->List();
    // load view file for output
        $this->load->view('export/index', $data);
    }
  // create xlsx
    public function createXLS($id) {
        try{
            $fileName = 'data-'.time().'.xlsx';  

            // load excel library
            $this->load->library('excel');
            $empInfo = $this->export->List($id);

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID USER');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ID MEETING');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'EMAIL');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ID DEPARTMENT');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'COMPANY');
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'JABATAN');
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'CHECKIN DATE');
            
            // set Row
            $rowCount = 2;
            $i = 1;
            foreach ($empInfo as $element) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['ID_USER']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['ID_MEETING']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['EMAIL']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['ID_DEPT']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['COMPANY']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['NAMA_SEK']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['CHECKIN_DATE']);

                $rowCount++;
                $i++;
            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save("temp/excel/".$fileName);
        // download file
            header("Content-Type: application/vnd.ms-excel");
            redirect(base_url()."/temp/excel/".$fileName); 
        }catch(Exception $e){
            // redirect(base_url('index.php/meeting_menu/'));
        }     
    }
}
?>