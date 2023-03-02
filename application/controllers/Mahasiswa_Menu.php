<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mahasiswa_menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
        $this->load->model('Mahasiswa_Menu_Model');

	}	
	public function index()
	{
        $data['active_menu']    = 'mahasiswa_menu';
        $data['content']		= 'mahasiswa_menu/list_mahasiswa';
		$this->load->view('index', $data);
	}
    public function create_page()
	{
        $data['active_menu']    = 'mahasiswa_menu';
		$data['content']		= 'mahasiswa_menu/create_mahasiswa';
		$this->load->view('index', $data);
	}
    // public function list_absen_page()
	// {
    //     $data['active_menu']    = 'mahasiswa_menu';
	// 	$data['content']		= 'mahasiswa_menu/list_absen';
	// 	$this->load->view('index', $data);
	// }
    function datatable_mahasiswa_menu() 
	{
		$list = $this->Mahasiswa_Menu_Model->get_datatables_mahasiswa();
        $data = array();
        $no = $_POST['start'];
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI'");


        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->MAHASISWA_NIM;
            $row[] = $value->MAHASISWA_NAMA;
            $row[] = $value->MAHASISWA_PRODI;
            $row[] = $value->MAHASISWA_JURUSAN;
            $row[] = $value->MAHASISWA_UNIVERSITAS;
            $row[] = $value->CREATED_BY;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mahasiswa_Menu_Model->count_all_mahasiswa(),
            "recordsFiltered" => $this->Mahasiswa_Menu_Model->count_filtered_mahasiswa(),
            "data" => $data,
        );

        echo json_encode($output);
	}

    public function insert(){
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");

        $nama = strtolower($this->input->post('nama'));
        $nim = $this->input->post('nim');
        $mulaiMagang = $this->input->post('start_date');
        $selesaiMagang = $this->input->post('end_date');
        $prodi = $this->input->post('prodi');
        $jurusan = $this->input->post('jurusan');
        $universitas = $this->input->post('universitas');


        $query = $this->db->query("SELECT COUNT(MAHASISWA_ID) as total FROM MEETING.USER_MAHASISWA WHERE MAHASISWA_ID LIKE '%$nama%'")->result();
        if($query[0]->TOTAL == 0){
            $data = array(
                'MAHASISWA_NIM' => $nama,
                'MAHASISWA_NAMA' => $nim,
                'MAHASISWA_START_DATE' => $mulaiMagang,
                'MAHASISWA_END_DATE' => $selesaiMagang,
                'MAHASISWA_PRODI' => $prodi,
                'MAHASISWA_JURUSAN' => $jurusan,
                'MAHASISWA_UNIVERSITAS' => $universitas,
                'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME,
                'CREATED_DATE' => date("Y-m-d H:i:s"),
            );
            $this->User_Menu_Model->insert($data);

            redirect(base_url('index.php/user_menu'));

        }else if($query[0]->TOTAL >= 1){
            redirect(base_url('index.php/user_menu/create_page'));

        }
    }

    // public function departement(){
    //     $data = $this->db->query("SELECT * FROM MEETING.DEPARTEMENT")->result();
    //     echo json_encode($data);
    // }
}
