<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_Menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
        $this->load->model('Event_Model');

	}	
	public function index()
	{
        $data['active_menu']    = 'event_menu';
		$data['content']		= 'event_menu/view';
		$this->load->view('index', $data);
	}
    public function create_page()
	{
        $data['active_menu']    = 'event_menu';
		$data['content']		= 'event_menu/create';
		$this->load->view('index', $data);
	}
    public function update_page()
	{
        $data['active_menu']    = 'event_menu';
		$data['content']		= 'event_menu/update';
		$this->load->view('index', $data);
	}
    function datatable_event_menu() 
	{
		$list = $this->Event_Model->get_datatables_event();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {
            $no++;
            if($value->STATUS == 1){
                $status = '<span class="btn btn-sm btn-info mr-4">AKTIF</span>';
            }else if($value->STATUS == 0){
                $status = '<span class="btn btn-sm btn-danger mr-4">TIDAK AKTIF</span>';
            }

            $row = array();
            $row[] = $no;
            $row[] = $value->ID_EVENT;
            $row[] = $value->EVENT_NAME;
            $row[] = $value->CREATED_BY;
            $row[] = date("Y-m-d", strtotime($value->CREATED_DATE));
            $row[] = date("Y-m-d", strtotime($value->UPDATE_DATE));
            $row[] = $status;
            $row[] = '<a href="'.site_url('event_menu/update_page/'.$value->ID_EVENT).'" class="btn btn-warning">Edit</a>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Event_Model->count_all_event(),
            "recordsFiltered" => $this->Event_Model->count_filtered_event(),
            "data" => $data,
        );

        echo json_encode($output);
	}

    public function insert(){
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");

        $id_event = $this->input->post('id_event');
        $nama_event = $this->input->post('nama_event');
        $status = $this->input->post('status');

        $query = $this->db->query("SELECT COUNT(ID_EVENT) as total FROM MEETING.MASTER_EVENT WHERE ID_EVENT = '$id_event'")->result();
        if($query[0]->TOTAL == 0){
            $data = array(
                'ID_EVENT' => $id_event,
                'EVENT_NAME' => $nama_event,
                'STATUS' => $status,
                'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME,
                'UPDATE_BY' => $this->session->userdata('session_meeting')->USERNAME,
                'CREATED_DATE' => date("Y-m-d H:i:s"),
                'UPDATE_DATE' => date("Y-m-d H:i:s")
            );
            $this->Event_Model->insert($data);

            redirect(base_url('index.php/event_menu'));

        }else if($query[0]->TOTAL >= 1){
            redirect(base_url('index.php/event_menu/create_page'));

        }
    }
    public function update(){
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");

        $id_event = $this->input->post('id_event');
        $nama_event = $this->input->post('nama_event');
        $status = $this->input->post('status');

            $data = array(
                'EVENT_NAME' => $nama_event,
                'STATUS' => $status,
                'UPDATE_BY' => $this->session->userdata('session_meeting')->USERNAME,
                'UPDATE_DATE' => date("Y-m-d H:i:s")
            );
            $this->Event_Model->update($data , $id_event);

            redirect(base_url('index.php/event_menu'));
    }

    public function load_event($id){
        echo json_encode($this->db->query("SELECT * FROM MEETING.MASTER_EVENT WHERE ID_EVENT = '$id'")->row());
    }
}
