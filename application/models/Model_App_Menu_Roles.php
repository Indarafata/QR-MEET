<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_App_Menu_Roles extends CI_Model {

	private $table = 'MEETING.CM_MENU_ROLES';
    private $view = "MEETING.VW_CM_MENU_ROLES";

    function __construct()
    {
        parent::__construct();
        // $this->db = $this->load->database('tower', true);
    }

    public function getByRoleId($role_id)
    {
        $this->db->where('ROLE_ID', $role_id);
        $this->db->where('STATUS', 1);
        $this->db->where('ID_APLIKASI', getKdAplikasi());
        $this->db->order_by('NO_SEQ', 'ASC');
        $this->db->from($this->view);
        // echo $this->db->get_compiled_select();die();
        return $this->db->get()->result_array();
    }

    public function update_menu($role_id, $menus)
    {
        $this->db->where('ROLE_ID', $role_id);
        $this->db->delete($this->table);

        foreach ($menus as $key => $val) {
            $data = [
                'ROLE_ID'       => $role_id,
                'MENU_ID'       => $val,
                'UPDATED_BY'    => $this->session->userdata('session_meeting')->IDUSER,
            ];

            $this->db->insert($this->table, $data);
        }
        return true;
    }

}
