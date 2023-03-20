<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kantin extends CI_Controller {

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
		$data['content']		= 'magang_menu/create';
		$this->load->view('index', $data);
	}
}
    ?>