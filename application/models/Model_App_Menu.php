<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_App_Menu extends CI_Model {

	private $table = 'MEETING.CM_MENU';
	private $view  = 'MEETING.VW_CM_MENU';

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

    public function getByIdAplikasi($id_aplikasi, $is_parent='', $status=null)
    {
        if($is_parent == '1') {
            $this->db->where("(PARENT_ID IS NULL OR PARENT_ID='')");
        } else if($is_parent == '0') {
            $this->db->where("(PARENT_ID IS NOT NULL)");
        }
        if($status != null) {
            $this->db->where('STATUS', $status);
        }
        $this->db->where('ID_APLIKASI', $id_aplikasi);
        // $this->db->where('KD_CABANG', $this->session->userdata('session_meeting')->KD_CABANG);
        // $this->db->where('KD_TERMINAL', $this->session->userdata('session_meeting')->KD_TERMINAL);
        $this->db->order_by('NO_SEQ', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
    public function get_group_menu(){
        // $this->db->distinct('MENU_GROUP');
        $this->db->select('MENU_GROUP');
        $this->db->where('MENU_GROUP is not null');
        $this->db->group_by('MENU_GROUP');// add group_by
        $query = $this->db->get('MEETING.CM_MENU');
        return $query->result_array();
        // $this->db->query("SELECT * FROM ");
        // return $this->db->get($this->view)->result_array();
    }

    public function getParents()
    {
        // $this->db->where('KD_CABANG', $this->session->userdata('session_meeting')->KD_CABANG);
        // $this->db->where('KD_TERMINAL', $this->session->userdata('session_meeting')->KD_TERMINAL);
        $this->db->where("PARENT_ID IS NULL OR PARENT_ID=''");
        return $this->db->get($this->view)->result_array();
    }

    public function getAll()
    {
        $this->db->where('KD_CABANG', $this->session->userdata('session_meeting')->KD_CABANG);
        $this->db->where('KD_TERMINAL', $this->session->userdata('session_meeting')->KD_TERMINAL);
        return $this->db->get($this->table)->result_array();
    }

    public function insert()
    {
        $data = [
            'PARENT_ID'     => $this->input->post('parent_id'),
            'MENU'          => $this->input->post('menu'),
            'URL'           => $this->input->post('url'),
            'FORM_NAME'     => $this->input->post('form_name'),
            'NO_SEQ'        => $this->input->post('no_seq'),
            'KD_CABANG'     => $this->session->userdata('session_meeting')->KD_CABANG,
            'KD_TERMINAL'   => $this->session->userdata('session_meeting')->KD_TERMINAL,
            'VERSI'         => $this->input->post('versi'),
            'ID_APLIKASI'   => $this->input->post('id_aplikasi'),
            'CREATED_BY'    => $this->session->userdata('session_meeting')->IDUSER,
        ];

        return $this->db->insert($this->table, $data);
    }

    public function update($id)
    {
        $data = [
            'PARENT_ID'     => $this->input->post('parent_id'),
            'MENU'          => $this->input->post('menu'),
            'URL'           => $this->input->post('url'),
            'FORM_NAME'     => $this->input->post('form_name'),
            'NO_SEQ'        => $this->input->post('no_seq'),
            'KD_CABANG'     => $this->session->userdata('session_meeting')->KD_CABANG,
            'KD_TERMINAL'   => $this->session->userdata('session_meeting')->KD_TERMINAL,
            'VERSI'         => $this->input->post('versi'),
            'ID_APLIKASI'   => $this->input->post('id_aplikasi'),
            'CREATED_BY'    => $this->session->userdata('session_meeting')->IDUSER,
        ];

        $this->db->where('ID', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('ID', $id);
        return $this->db->delete($this->table);
    }

    public function active($id, $status)
    {
        $data = ['STATUS'    => $status,];
        $this->db->where('ID', $id);
        return $this->db->update($this->table, $data);
    }

    private function _get_datatables_query_app_menu()
    {
        $this->db->select('*')->from($this->view);
        // $this->db->where('KD_CABANG', $this->session->userdata('session_meeting')->KD_CABANG);
        // $this->db->where('KD_TERMINAL', $this->session->userdata('session_meeting')->KD_TERMINAL);
        $column_orderTopUp = array(null, 'PARENT_MENU', 'MENU', 'URL', 'NO_SEQ', null, null);
        $column_searchTopUp = array(null, 'PARENT_MENU', 'MENU', 'URL', 'NO_SEQ',  null, null);
        $order = array('PARENT_ID' => 'desc'); 
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }
 
    function get_datatables_app_menu()
    {
        $this->_get_datatables_query_app_menu();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_app_menu()
    {
        $this->_get_datatables_query_app_menu();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_app_menu()
    {
        $this->db->select('ID')->from($this->table);
        return $this->db->count_all_results();
    }

    private function datatable_order_search($order, $column_orderTopUp, $column_searchTopUp)
    {
        $i = 0;

        foreach ($column_searchTopUp as $item) 
        {
            if($_POST['columns'][$i]['search']['value'] != "" && $_POST['columns'][$i]['search']['value'] != null) 
            {                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like("UPPER(".$item.")", strtoupper($_POST['columns'][$i]['search']['value']));
                }
                else
                {
                    $this->db->like("UPPER(".$item.")", strtoupper($_POST['columns'][$i]['search']['value']));
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
