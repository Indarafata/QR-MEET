<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_version extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		redirectIfNotLoggedIn();
		check_permission();
		set_time_limit(10000);
		$this->load->model('Model_App_Version');
	}

	public function index()
	{
		$data['active_menu']    = 'app_version';
		$data['content']		= 'app_version/view';
		$this->load->view('index', $data);
	}

	public function create()
	{
		if ($this->input->post('submit') != '') {
			if ($this->Model_App_Version->insert(
				$this->input->post('build_number'),
				$this->input->post('version'),
				$this->input->post('url'),
				$this->input->post('must_update')
			))
				$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses insert data</div>');
			else
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal insert data</div>');
			redirect('app_version');
		} else {
			$data['active_menu'] = 'app_version';
			$data['content']     = 'app_version/create';
			$this->load->view('index', $data);
		}
	}

	public function update($id)
	{
		if ($this->input->post('submit') != '') {
			if ($this->Model_App_Version->update(
				$id,
				$this->input->post('build_number'),
				$this->input->post('version'),
				$this->input->post('url'),
				$this->input->post('must_update')
			))
				$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses update data</div>');
			else
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal update data</div>');
			redirect('app_version');
		} else {
			$data['id']          = $id;
			$data['data']        = $this->Model_App_Version->get($id);
			$data['active_menu'] = 'app_version';
			$data['content']     = 'app_version/update';
			$this->load->view('index', $data);
		}
	}

	public function delete($id)
	{
		if ($this->Model_App_Version->delete($id))
			$this->session->set_flashdata('notif', '<div class="alert alert-success">Sukses delete data</div>');
		else
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Gagal delete data</div>');
		redirect('app_version');
	}

	function datatable()
	{
		$list = $this->Model_App_Version->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->BUILD_NUMBER;
			$row[] = $value->VERSION;
			$row[] = $value->URL;
			$row[] = $value->MUST_UPDATE;
			$row[] = "<a class='btn btn-warning' href='" . site_url('app_version/update/' . $value->ID) . "'>" .
				"<i class='fa fa-pencil'></i>" .
				"</a> " .
				" <a class='btn btn-danger' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")' href='" . site_url('app_version/delete/' . $value->ID) . "'>" .
				"<i class='fa fa-trash'></i>" .
				"</a> ";

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($list),
			"recordsFiltered" => $this->Model_App_Version->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}
}
