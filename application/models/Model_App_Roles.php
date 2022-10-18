<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_App_Roles extends CI_Model {

	private $table = 'MEETING.CM_ROLES';
    private $view = 'MEETING.VW_CM_ROLES';

    function __construct()
    {
        parent::__construct();
        // $this->db = $this->load->database('tower', true);
    }

    public function getById($id)
    {
        $this->db->where('ID', $id);
        return $this->db->get($this->table)->result_array();
    }

    public function getBySittlRoleId($sittl_role_id)
    {
        $this->db->where('SITTL_ROLE_ID', $sittl_role_id);
        $this->db->from($this->table);
        // echo $this->db->get_compiled_select();die();
        return $this->db->get()->result_array();
    }

    public function insert()
    {
        $data = [
            'NAMA'          => $this->input->post('nama'),
            'KD_CABANG'     => $this->session->userdata('session_meeting')->KD_CABANG,
            'KD_TERMINAL'   => $this->session->userdata('session_meeting')->KD_TERMINAL,
            'ID_APLIKASI'   => $this->input->post('id_aplikasi'),
            'SITTL_ROLE_ID' => $this->input->post('sittl_role_id'),
            'CREATED_BY'    => $this->session->userdata('session_meeting')->IDUSER,
        ];

        return $this->db->insert($this->table, $data);
    }

    public function update($id)
    {
        $data = [
            'NAMA'          => $this->input->post('nama'),
            'KD_CABANG'     => $this->session->userdata('session_meeting')->KD_CABANG,
            'KD_TERMINAL'   => $this->session->userdata('session_meeting')->KD_TERMINAL,
            'ID_APLIKASI'   => $this->input->post('id_aplikasi'),
            'SITTL_ROLE_ID' => $this->input->post('sittl_role_id'),
            'UPDATED_BY'    => $this->session->userdata('session_meeting')->IDUSER,
        ];

        $this->db->where('ID', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('ID', $id);
        return $this->db->delete($this->table);
    }

    private function _get_datatables_query_app_roles()
    {
        $this->db->select('*')->from($this->view);
        // $this->db->where('KD_CABANG', $this->session->userdata('session_meeting')->KD_CABANG);
        // $this->db->where('KD_TERMINAL', $this->session->userdata('session_meeting')->KD_TERMINAL);
        $column_orderTopUp = array(null, 'ID', 'NAMA', 'KD_TERMINAL', 'KD_TERMINAL', 'STATUS', 'ID_APLIKASI', 'SITTL_ROLE_ID');
        $column_searchTopUp = array('ID', 'NAMA', 'KD_TERMINAL', 'KD_TERMINAL', 'STATUS', 'ID_APLIKASI', 'SITTL_ROLE_ID');
        $order = array('ID' => 'asc');
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }
 
    function get_datatables_app_roles()
    {
        $this->_get_datatables_query_app_roles();
        // echo $this->db->get_compiled_select();die();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_app_roles()
    {
        $this->_get_datatables_query_app_roles();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_app_roles()
    {
        $this->db->select('ID')->from($this->table);
        return $this->db->count_all_results();
    }

    private function datatable_order_search($order, $column_orderTopUp, $column_searchTopUp)
    {
        $i = 0;

        foreach ($column_searchTopUp as $item) 
        {
            if($_POST['search']['value']) 
            {                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like("UPPER(".$item.")", strtoupper($_POST['search']['value']));
                }
                else
                {
                    $this->db->or_like("UPPER(".$item.")", strtoupper($_POST['search']['value']));
                }
 
                if(count($column_searchTopUp) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($column_orderTopUp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($order))
        {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
   
}
