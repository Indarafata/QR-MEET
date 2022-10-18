<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class magang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
        $this->load->model('Meeting_Model');
        $this->load->helper('url');

	}	
	public function index()
	{
		$data['content']		= 'magang_menu/create';
		$this->load->view('index', $data);
	}

    public function absen(){
        $lat = $this->input->post("txt_lat");
        $long = $this->input->post("txt_long");
        $jarak = $this->input->post("txt_jarak");
    }
}
