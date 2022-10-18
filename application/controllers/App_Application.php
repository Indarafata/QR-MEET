<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Application extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
		$this->load->model('Model_App_Application');

	}	

	public function index()
	{
        $data['active_menu']    = 'app_application';
		$data['content']		= 'app_application/view';
		$this->load->view('index', $data);
	}

	public function create()
	{
		if($this->input->post('submit') != '') 
		{
			$filename = time().'.png';

			if(!$this->uploadImage($filename)) {
				$filename = "";
			}

			if($this->Model_App_Application->insert($filename))
				$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses insert data</div>');
			else
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal insert data</div>');
			redirect('app_application');
		}
		else 
		{
	        $data['active_menu']    = 'app_application';
			$data['content']		= 'app_application/create';
			$this->load->view('index', $data);
		}
	}

	public function update($code)
	{
		if($this->input->post('submit') != '') 
		{
			$filename = time().'.png';

			if($this->uploadImage($filename) != true) {
				$filename = "";
			}

			if($this->Model_App_Application->update($code, $filename))
				$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses update data</div>');
			else
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal update data</div>');
			redirect('app_application');
		}
		else 
		{
			$data['code']			= $code;
			$data['data']			= $this->Model_App_Application->getByCode($code);
	        $data['active_menu']    = 'app_application';
			$data['content']		= 'app_application/update';
			$this->load->view('index', $data);
		}
	}

	public function delete($code)
	{
		if($this->Model_App_Application->delete($code))
			$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses delete data</div>');
		else
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal delete data</div>');
		redirect('app_application');
	}

	function uploadImage($filename){
		$config['upload_path']          = './assets/img/application/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = '100000000';
		$config['max_width']            = '102000000';
		$config['max_height']           = '760000000';
		$config['file_name']			= $filename;
 
		$this->load->library('upload', $config);
 
		return $this->upload->do_upload('userfile');
	}	

	function datatable() 
	{
		$list = $this->Model_App_Application->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->CODE;
            $row[] = $value->NAME;
            $row[] = $value->URL;
            $row[] = "<a href='".base_url('assets/img/application/'.$value->ICON)."' target='_blank'>".
            			"<img src='".base_url('assets/img/application/'.$value->ICON)."' width='50'/>".
            		"</a>";
            $row[] = $value->NO_SEQ;
            $row[] = $value->KD_CABANG;
            $row[] = $value->KD_TERMINAL;
            $row[] = "<a class='btn btn-warning' href='".site_url('app_application/update/'.$value->CODE)."'>".
		            	"<i class='fa fa-pencil'></i>".
		            "</a> ".
		            " <a class='btn btn-danger' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")' href='".site_url('app_application/delete/'.$value->CODE)."'>".
		            	"<i class='fa fa-trash'></i>".
		            "</a> ";

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => count($list),
                        "recordsFiltered" => $this->Model_App_Application->count_filtered(),
                        "data" => $data,
                );

        echo json_encode($output);
	}


}
