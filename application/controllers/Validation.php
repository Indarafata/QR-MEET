<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validation extends CI_Controller {
	// public function __construct()
	// {
	// 	parent::__construct();
	// 	$this->load->library('ciqrcode'); //pemanggilan library QR CODE

	// }	
       
	// public function index()
	// {
	// 	$this->load->model('model_user','user',TRUE);
	// 	$data['data_sql'] = $this->user->get_meeting_detail();
	// 	$data['error'] = '';
	// 	$data['base_url'] = $this->config->item('base_url');
	// 	$this->load->view('html_head', $data);
	// 	$this->load->view('user', $data);
	// 	$this->load->view('html_foot', $data);
	// }

    // public function makeQr(){
    //     ini_set('display_errors', 1);
    //     ini_set('display_startup_errors', 1);
    //     error_reporting(E_ALL);

    //     $this->load->library('CodeIgniter-PHP-QR-Code/Ciqrcode'); //pemanggilan library QR CODE
    //     $config_qr['cacheable']    = false; //boolean, the default is true
    //     // $config_qr['cachedir']     = 'upload/qr_code'; //string, the default is application/cache/
    //     // $config_qr['errorlog']     = 'upload/qr_code'; //string, the default is application/logs/
    //     // $config_qr['imagedir']     = 'upload/qr_code/appr/'; //direktori penyimpanan qr code
    //     $config_qr['quality']      = true; //boolean, the default is true
    //     $config_qr['size']         = '1024'; //interger, the default is 1024
    //     $config_qr['black']        = array(224,255,255); // array, default is array(255,255,255)
    //     $config_qr['white']        = array(70,130,180); // array, default is array(0,0,0)
    //     $this->ciqrcode->initialize($config);

        
    //     // $data_qr = $this->session->userdata('session_warehouse')->USERNAME;
    //     $data_qr = $_GET['text'];
    //     $data_qr .= "isian isian isian";
    //     // $qr_code = $this->session->userdata('session_warehouse')->USERNAME.'in_eng'.date('y').date('m').sprintf('%07d',(((int)$no_trans)+1)).'.png'; //buat name dari qr code sesuai dengan nim
    //     $params['data'] = $data_qr; //data yang akan di jadikan QR CODE
    //     // $params['level'] = 'H'; //H=High
    //     // $params['size'] = 10;
    //     // $params['savename'] = FCPATH.$config_qr['imagedir'].$qr_code; //simpan image QR CODE ke folder assets/images/
    //     header("Content-Type: image/jpeg");
    //      return $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

    // }

    public function MakeQrMonic()
    {
        $qr    = $_GET['QR'];
        // $usr_id   = $_GET['usr_id'];
        // $checksum = $_GET['checksum'];
        $this->load->library('CodeIgniter-PHP-QR-Code/Ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = false; //boolean, the default is true
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); //array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); //array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        header("Content-Type: image/jpeg");
        // $nilai =   base_url() . 'validasi/qr_ba?id=' . $ba_id . '&usr=' . $usr_id . '&key=' . $checksum;
        // $nilai ='hahahh';
        $nilai = "http://qrmeet.test/kantin/$qr";
        $params['data'] = $nilai;
        return $this->ciqrcode->generate($params);
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */