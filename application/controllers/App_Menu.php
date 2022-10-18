<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
		$this->load->model('Model_App_Menu');
		$this->load->model('Model_App_Application');

	}	

	public function index()
	{
        $data['active_menu']    = 'app_menu';
		$data['content']		= 'app_menu/view';
		$this->load->view('index', $data);
	}

	public function create()
	{
		$this->load->library('form_validation');

        $this->form_validation->set_rules('menu', 'Menu', 'required');
        $this->form_validation->set_rules('form_name', 'Form Name', 'required');
        $this->form_validation->set_rules('no_seq', 'Nomor Sequence', 'required');
        $this->form_validation->set_rules('id_aplikasi', 'Aplikasi', 'required');

		if($this->form_validation->run()) 
		{
			if($this->Model_App_Menu->insert())
				$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses insert data</div>');
			else
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal insert data</div>');
			redirect('App_Menu');
		}
		else 
		{
			$data['parent']			= $this->Model_App_Menu->getParents();
			$data['application']	= $this->Model_App_Application->getAll();
	        $data['active_menu']    = 'app_menu';
			$data['content']		= 'app_menu/create';
			$this->load->view('index', $data);
		}
	}

	public function update($id)
	{
		$this->load->library('form_validation');

        $this->form_validation->set_rules('menu', 'Menu', 'required');
        $this->form_validation->set_rules('form_name', 'Form Name', 'required');
        $this->form_validation->set_rules('no_seq', 'Nomor Sequence', 'required');
        $this->form_validation->set_rules('id_aplikasi', 'Aplikasi', 'required');

		if($this->form_validation->run()) 
		{
			if($this->Model_App_Menu->update($id))
				$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses update data</div>');
			else
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal update data</div>');
			redirect('App_Menu');
		}
		else 
		{
			$data['id']				= $id;
			$data['parent']			= $this->Model_App_Menu->getParents();
			$data['application']	= $this->Model_App_Application->getAll();
			$data['data']			= $this->Model_App_Menu->getById($id);
	        $data['active_menu']    = 'app_menu';
			$data['content']		= 'app_menu/update';
			$this->load->view('index', $data);
		}
	}

	public function delete($id)
	{
		if($this->Model_App_Menu->delete($id))
			$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses delete data</div>');
		else
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal delete data</div>');
		redirect('App_Menu');
	}

	public function active($id)
	{
		if($this->Model_App_Menu->active($id, $this->input->get('status')))
			$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses update data</div>');
		else
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal update data</div>');
		redirect('App_Menu');
	}

	function datatable_app_menu() 
	{
		$list = $this->Model_App_Menu->get_datatables_app_menu();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->PARENT_MENU;
            $row[] = $value->MENU;
            $row[] = $value->URL;
            $row[] = $value->NO_SEQ;
            
            if($value->STATUS == 1)
	            $row[] = '<div class="badge badge-success">Aktif</div>';
            else if($value->STATUS == 0)
	            $row[] = '<div class="badge badge-danger">Non Aktif</div>';

            $action = "<a class='btn btn-warning' href='".site_url('App_Menu/update/'.$value->ID)."'>".
		            	"<i class='fas fa-pencil-alt'></i>".
		            "</a> ".
		            " <a class='btn btn-danger' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")' href='".site_url('App_Menu/delete/'.$value->ID)."'>".
		            	"<i class='fa fa-trash'></i>".
		            "</a> ";

		    if($value->STATUS == 1) 
		    	$action .= 
		    		"<a class='btn btn-default' href='".site_url('App_Menu/active/'.$value->ID.'?status=0')."'>".
		            	"<i class='fa fa-toggle-on'></i>".
		            "</a> ";
		    else if($value->STATUS == 0) 
		    	$action .= 
		    		"<a class='btn btn-default' href='".site_url('App_Menu/active/'.$value->ID.'?status=1')."'>".
		            	"<i class='fa fa-toggle-off'></i>".
		            "</a> ";

		    $row[] = $action;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Model_App_Menu->count_all_app_menu(),
                        "recordsFiltered" => $this->Model_App_Menu->count_filtered_app_menu(),
                        "data" => $data,
                );

        echo json_encode($output);
	}


}
