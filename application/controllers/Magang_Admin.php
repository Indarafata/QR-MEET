<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class magang_admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
        $this->load->model('Magang_Model');
        $this->load->helper('url');
		$this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");

	}	
	public function index()
	{
		$data['content']		= 'magang_menu/admin_create';
		$this->load->view('index', $data);
	}
	public function log_absensi_all()
	{
		$data['content']		= 'magang_menu/admin_view';
		$this->load->view('index', $data);
	}
    function datatable_lokasi_menu() 
	{
		$list = $this->Magang_Model->get_datatables_lokasi();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {
			
            $no++;
            $row = array();
            $row[] = $no;
			$row[] = $value->ID_AREA;
            $row[] = $value->AREA_NAME;
            $row[] = $value->LAT;
			$row[] = $value->LON;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Magang_Model->count_all_lokasi(),
            "recordsFiltered" => $this->Magang_Model->count_filtered_lokasi(),
            "data" => $data,
        );

        echo json_encode($output);
	}
    function insert_lokasi(){
        try{
            $lat = $this->input->post('lat');
            $lon = $this->input->post('lon');
            $nama = $this->input->post('nama');
    
            $data = array(
                'AREA_NAME' => $nama,
                'LON' => $lon,
                'LAT' => $lat,
                'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME
            );
            $this->Magang_Model->insert_lokasi($data);
        }catch(Exception $e){
        }
        redirect('/magang_admin');
    }

    function update(){

        try{
            $waktu_datang = $this->input->post('waktu_datang');
            $waktu_pulang = $this->input->post('waktu_pulang');
            $interval = $this->input->post('interval');
            $jarak = $this->input->post('jarak');
    
            $data_abs_time = array(
                'PARAM1' => $waktu_datang,
                'PARAM2' => $waktu_pulang
            );
            $data_abs_interval = array(
                'PARAM1' => $interval
            );
            $data_abs_jarak = array(
                'PARAM1' => $jarak
            );
            $this->Magang_Model->update_magang_time($data_abs_time);
            $this->Magang_Model->update_magang_interval($data_abs_interval);
            $this->Magang_Model->update_magang_jarak($data_abs_jarak);
        }catch(Exception $e){

        }
        redirect('/magang_admin');
    }

    function datatable_log_absensi_all_menu() 
	{
		$list = $this->Magang_Model->get_datatables_log_absensi_all();
        $data = array();
        $no = $_POST['start'];
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI'");

        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->NAMA;
            $row[] = '<button class="btn btn-primary" onclick="listDetail('.$value->NIPP.')">Detail</button>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Magang_Model->count_all_log_absensi_all(),
            "recordsFiltered" => $this->Magang_Model->count_filtered_log_absensi_all(),
            "data" => $data,
        );

        echo json_encode($output);
	}

    function datatable_log_absensi_arr_menu($nipp) 
	{
		$list = $this->Magang_Model->get_datatables_log_absensi_arr($nipp);
        $data = array();
        $no = $_POST['start'];
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI'");
		$type='-';
		$status_arr = '';
		$status_end = '';

        foreach ($list as $value) {
            $no++;
	
			$row = array();
            $row[] = $no;
				if($value->EXCEPTION_DATE == null && $value->STATUS_ARR == null && $value->STATUS_END == null){
					$row[] =  '<span class="text-danger">'.date("d-M", strtotime($value->DAY)).' | '.$value->DAY_NAME.'</span>';
					$row[] =  '<span class="text-danger">'.$value->STATUS_ARR.' - '.$value->CHECKIN_TIME.'</span>';
					$row[] =  '<span class="text-danger">'.$value->STATUS_END.' - '.$value->CHECKOUT_TIME.'</span>';
					$row[] =  '<span class="text-danger">'.$value->TYPE.' - '. $value->REMARK.'</span>';
				}else{
					if($value->EXCEPTION_DATE !=null){
						$row[] = '<span class="bg-danger p-2 text-white">'.date("d-M", strtotime($value->DAY)).' | '.$value->DAY_NAME.'</span>';
					}else{
						$row[] = '<span class="bg-success p-2 text-white">'.date("d-M", strtotime($value->DAY)).' | '.$value->DAY_NAME.'</span>';
					}
					$row[] = '<span class="">'.$value->STATUS_ARR.' - '.$value->CHECKIN_TIME.'</span>';
					$row[] = '<span class="">'.$value->STATUS_END.' - '.$value->CHECKOUT_TIME.'</span>';
					$row[] = '<span class="">'.$value->TYPE.' - '. $value->REMARK.'</span>';
				}
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Magang_Model->count_all_log_absensi_arr($nipp),
            "recordsFiltered" => $this->Magang_Model->count_filtered_log_absensi_arr($nipp),
            "data" => $data,
        );

        echo json_encode($output);
	}

    function get_user($id){
        echo json_encode($this->db->query("SELECT * FROM VW_USER WHERE USER_ID = '$id'")->ROW());
    }

    function get_jarak(){
        echo json_encode($this->db->query("SELECT PARAM1 FROM GEN_REF WHERE CODE_REF = 'ABS_JARAK'")->ROW());
    }
    function get_waktu(){
        echo json_encode($this->db->query("SELECT PARAM1 , PARAM2 FROM GEN_REF WHERE CODE_REF = 'ABS_TIME'")->ROW());
    }
    function get_interval(){
        echo json_encode($this->db->query("SELECT PARAM1 , PARAM2 FROM GEN_REF WHERE CODE_REF = 'ABS_INTERVAL'")->ROW());
    }
}