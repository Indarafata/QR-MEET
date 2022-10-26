<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Roles extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
		$this->load->model('Model_App_Roles');
		$this->load->model('Model_App_Menu');
		$this->load->model('Model_App_Menu_Roles');
		$this->load->model('Model_App_Application');
	}	

	public function index()
	{
        $data['active_menu']    = 'app_roles';
		$data['content']		= 'app_roles/view';
		$this->load->view('index', $data);
	}

	public function create()
	{
		if($this->input->post('submit') != '') 
		{
			$this->Model_App_Roles->insert();
			redirect('App_Roles');
		}
		else 
		{
	        $data['application']    = $this->Model_App_Application->getAll();
	        $data['active_menu']    = 'app_roles';
			$data['content']		= 'app_roles/create';
			$this->load->view('index', $data);
		}
	}

	public function update($id)
	{
		if($this->input->post('submit') != '') 
		{
			$this->Model_App_Roles->update($id);
			redirect('App_Roles');
		}
		else 
		{
			$data['id']				= $id;
	        $data['application']    = $this->Model_App_Application->getAll();
			$data['data']			= $this->Model_App_Roles->getById($id);
	        $data['active_menu']    = 'app_roles';
			$data['content']		= 'app_roles/update';
			$this->load->view('index', $data);
		}
	}

	public function delete($id)
	{
		$this->Model_App_Roles->delete($id);
		redirect('App_Roles');
	}

	public function update_menu($id, $id_aplikasi)
	{
		$this->load->library('form_validation');

		if($this->input->post('submit') != '') 
		{
			$this->Model_App_Menu_Roles->update_menu($id, $this->input->post('menus'));
			redirect('App_Roles');
		}
		else 
		{
			$menu_parent = $this->Model_App_Menu->getByIdAplikasi($id_aplikasi, '1', 1);
			$menu_childs = $this->Model_App_Menu->getByIdAplikasi($id_aplikasi, '0', 1);
			$menu_roles	 = $this->Model_App_Menu_Roles->getByRoleId($id);
			$menus 		 = $this->grouping_menu($id, $menu_parent, $menu_childs, $menu_roles);

			$data['id']				= $id;
			$data['id_aplikasi']	= $id_aplikasi;
	        $data['menus']    		= $menus;
			// $data['data_plat_roles']= $this->Model_App_Platform->getByRoles($id);
			// $data['platform']		= $this->Model_App_Platform->getAll();
	        $data['active_menu']    = 'app_roles';
			$data['content']		= 'app_roles/update_menu';
			$this->load->view('index', $data);
		}
	}

	private function grouping_menu($id_role, $menu_parent, $menu_childs, $menu_roles)
	{
		foreach ($menu_parent as $p => $parent) {
			$menu_parent[$p]['SELECTED'] = '';

			foreach ($menu_roles as $r => $role) {
				if($role['MENU_ID'] == $parent['ID']) {
					$menu_parent[$p]['SELECTED'] = 'selected';
					break;
				}
			}

			foreach ($menu_childs as $c => $child) {
				if($parent['ID'] == $child['PARENT_ID']) {
					$child['SELECTED'] = '';

					foreach ($menu_roles as $r => $role) {
						if($role['MENU_ID'] == $child['ID']) {
							$child['SELECTED'] = 'selected';
							break;
						}
					}
					$menu_parent[$p]['CHILDS'][] = $child;
				}
			}
		}
		return $menu_parent;
	}

	function datatable_app_roles() 
	{
		$list = $this->Model_App_Roles->get_datatables_app_roles();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->SITTL_ROLE_ID;
            $row[] = $value->NAMA;
            $row[] = $value->NAMA_APLIKASI .' ('.$value->ID_APLIKASI.')';
            
            $row[] = "<a class='btn btn-warning' href='".site_url('App_Roles/update/'.$value->ID)."'>".
		            	"<i class='fas fa-pencil-alt'></i>".
		            "</a> ".
		            " <a class='btn btn-danger' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")' href='".site_url('App_Roles/delete/'.$value->ID)."'>".
		            	"<i class='fa fa-trash'></i>".
		            "</a> ".
		            " <a class='btn btn-success' href='".site_url('App_Roles/update_menu/'.$value->ID.'/'.$value->ID_APLIKASI)."' title='Atur menu'>".
		            	"<i class='fa fa-list'></i>".
		            "</a> ";

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Model_App_Roles->count_all_app_roles(),
                        "recordsFiltered" => $this->Model_App_Roles->count_filtered_app_roles(),
                        "data" => $data,
                );

        echo json_encode($output);
	}


}
