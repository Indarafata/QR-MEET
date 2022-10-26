<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
        $this->load->model('User_Menu_Model');

	}	
	public function index()
	{
        $data['active_menu']    = 'user_menu';
		$data['content']		= 'user_menu/view';
		$this->load->view('index', $data);
	}
    public function create_page()
	{
        $data['active_menu']    = 'user_menu';
		$data['content']		= 'user_menu/create';
		$this->load->view('index', $data);
	}
    public function list_absen_page()
	{
        $data['active_menu']    = 'user_menu';
		$data['content']		= 'user_menu/list_absen';
		$this->load->view('index', $data);
	}
    function datatable_user_menu() 
	{
		$list = $this->User_Menu_Model->get_datatables_user();
        $data = array();
        $no = $_POST['start'];
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI'");


        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->USER_ID;
            $row[] = $value->USERNAME;
            $row[] = $value->TELP;
            $row[] = $value->ID_DEPT;
            $row[] = $value->COMPANY;
            $row[] = $value->EMAIL;
            $row[] = $value->CREATED_BY;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_Menu_Model->count_all_user(),
            "recordsFiltered" => $this->User_Menu_Model->count_filtered_user(),
            "data" => $data,
        );

        echo json_encode($output);
	}

    public function insert(){
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");

        $nama = strtolower($this->input->post('nama'));
        $id_dept = $this->input->post('id_dept');
        $telepon = $this->input->post('telepon');
        $email = $this->input->post('email');
        $company = $this->input->post('company');


        $query = $this->db->query("SELECT COUNT(USER_ID) as total FROM MEETING.USERS WHERE USER_ID LIKE '%$nama%'")->result();
        if($query[0]->TOTAL == 0){
            $data = array(
                'USER_ID' => $nama,
                'USERNAME' => $nama,
                'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME,
                'ACTIVE_YN' => 'Y',
                'TELP' => $telepon,
                'COMPANY' => $company,
                'EMAIL' => $email,
                'ID_DEPT' => $id_dept,
                'CREATED_DATE' => date("Y-m-d H:i:s"),
            );
            $this->User_Menu_Model->insert($data);

            redirect(base_url('index.php/user_menu'));

        }else if($query[0]->TOTAL >= 1){
            redirect(base_url('index.php/user_menu/create_page'));

        }
    }

    public function departement(){
        $data = $this->db->query("SELECT * FROM MEETING.DEPARTEMENT")->result();
        echo json_encode($data);
    }
}
