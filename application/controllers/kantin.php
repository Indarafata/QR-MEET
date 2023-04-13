<?php
// session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class kantin extends CI_Controller {

    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->helper(array('captcha', 'form'));
    //     // $this->load->library('session');
    // }
    public function __construct()
	{
		parent::__construct();
        // redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
        $this->load->model('Booth_Transaction_Model');

	}	
	public function index()
	{
        $this->load->view('mahasiswa_role/qr_scanner/qr_scanner');
		// $data['content']		= 'mahasiswa_role/qr_scanner/qr_scanner';
		// $this->load->view('index', $data);
	}

    // public function index() {
    //     // $this->load->model('example_model');
    //     $data['data'] = $this->Booth_Transaction_Model->get_data();
    //     $this->load->view('mahasiswa_role/qr_scanner/validation', $data);
    //  }

	public function confirmation()
    {
		$this->load->view('mahasiswa_role/qr_scanner/confirmation');
        // $data['content']		= 'mahasiswa_role/qr_scanner/confirmation';
		// $this->load->view('index', $data);
    }

    public function validation()
    {
		// $this->load->view('mahasiswa_role/qr_scanner/validation');
        $data['data'] = $this->Booth_Transaction_Model->get_data();
        $this->load->view('mahasiswa_role/qr_scanner/validation', $data);
    }

    public function get_data($id) {
        // $this->load->model('my_model');
        $data = $this->my_model->get_data_by_id($id);
        // Lakukan sesuatu dengan data yang diambil
    }

    public function insert(){
        // echo $_SESSION['logged_in_user_name'];
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        // $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI' SET TIME ZONE 'Asia/Jakarta'");

        $id = $this->Booth_Transaction_Model->count_all_transaction() + 1;
        $urlBooth = $this->input->post('booth');
        $nipMahasiswa = $_SESSION['logged_in_user_name'];
        $date = date("Y-m-d");


        $query = $this->db->query("SELECT COUNT(TRANSACTION_ID) as total FROM MEETING.BOOTH_TRANSACTION WHERE NIP_MAHASISWA LIKE '%$nipMahasiswa%' AND TANGGAL_TRANSAKSI LIKE '%$date%'")->result();
        $queryBooth = $this->db->query("SELECT COUNT(BOOTH_ID) as total FROM MEETING.BOOTH WHERE URL_QR LIKE '%$urlBooth%'")->result();
        if($query[0]->TOTAL == 0 && $queryBooth[0]->TOTAL == 1){
            $data = array(
                'TRANSACTION_ID' => $id,
                'URL_BOOTH' => $urlBooth,
                'NIP_MAHASISWA' => $nipMahasiswa,
                // 'TANGGAL_TRANSAKSI' => date("Y-m-d H:i:s"),
                'TANGGAL_TRANSAKSI' => $date,
                'CREATED_DATE' => date("Y-m-d H:i:s"),
            );
            $this->Booth_Transaction_Model->insert($data);

            echo $query;
            redirect(base_url('index.php/kantin/validation?value=true'));
            // $this->load->view('mahasiswa_role/qr_scanner/validation?result=true');

        }else if($queryBooth[0]->TOTAL != 1){
            // redirect(base_url('index.php/mahasiswa_menu/create_mahasiswa'));
            redirect(base_url('index.php/kantin/validation?value=qrfalse'));

        }
        else{
            redirect(base_url('index.php/kantin/validation?value=false'));
        }
    }

    function datatable_booth_transaction() 
	{
		$list = $this->Booth_Transaction_Model->get_datatables_booth();
        $data = array();
        $no = $_POST['start'];
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI'");


        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->URL_BOOTH;
            $row[] = $value->NIP_MAHASISWA;
            $row[] = $value->TANGGAL_TRANSAKSI;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Booth_Transaction_Model->count_all_transaction(),
            "recordsFiltered" => $this->Booth_Transaction_Model->count_filtered_booth(),
            "data" => $data,
        );

        echo json_encode($output);
	}
}
    ?>