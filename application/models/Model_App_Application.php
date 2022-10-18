<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_App_Application extends CI_Model {

	private $table = 'MEETING.CM_APPLICATION';

    function __construct()
    {
        parent::__construct();
        // $this->db = $this->load->database('tower', true);
    }

    public function getByCode($code)
    {
        $this->db->where('CODE', $code);
        return $this->db->get($this->table)->result_array();
    }

    public function getAll()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function insert()
    {
        $data = [
            'CODE'          => $this->input->post('code'),
            'NAME'          => $this->input->post('name'),
            'URL'           => $this->input->post('url'),
            'ICON'          => 'default.png',
            'DESCRIPTION'   => $this->input->post('description'),
            'NO_SEQ'        => $this->input->post('no_seq'),
            'KD_CABANG'     => $this->input->post('kd_cabang'),
            'KD_TERMINAL'   => $this->input->post('kd_terminal'),
            'CREATED_BY'    => $this->session->userdata('session_meeting')->IDUSER,
        ];

        return $this->db->insert($this->table, $data);
    }

    public function update($code)
    {
        $data = [
            'CODE'          => $this->input->post('code'),
            'NAME'          => $this->input->post('name'),
            'URL'           => $this->input->post('url'),
            'ICON'          => 'default.png',
            'DESCRIPTION'   => $this->input->post('description'),
            'NO_SEQ'        => $this->input->post('no_seq'),
            'KD_CABANG'     => $this->input->post('kd_cabang'),
            'KD_TERMINAL'   => $this->input->post('kd_terminal'),
            'UPDATED_BY'    => $this->session->userdata('session_meeting')->IDUSER,
        ];

        $this->db->where('CODE', $code);
        return $this->db->update($this->table, $data);
    }

    public function delete($code)
    {
        $this->db->where('CODE', $code);
        return $this->db->delete($this->table);
    }

    private function _get_datatables_query_app_application()
    {
        $this->db->select('*')->from($this->table);
        $column_orderTopUp = array(null, 'CODE', 'NAME', 'URL', 'ICON', 'NO_SEQ', 'KD_CABANG', 'KD_TERMINAL');
        $column_searchTopUp = array('CODE', 'NAME');
        $order = array('CODE' => 'asc'); 
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }
 
    function get_datatables_app_application()
    {
        $this->_get_datatables_query_app_application();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_app_application()
    {
        $this->_get_datatables_query_app_application();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_app_application()
    {
        $this->db->select('CODE')->from($this->table);
        return $this->db->count_all_results();
    }

    public function getKendalaJson2($keyword)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE UPPER(NAME) LIKE '%".strtoupper($keyword)."%' OR UPPER(CODE) LIKE '%".strtoupper($keyword)."%'";
        $vessel = $this->db->query($sql)->result_array();

        $data = array();
        foreach($vessel as $value){
            $data[] = array("id"=>$value['CODE'], "text"=>$value['CODE']." - ".$value['NAME']);
        }
        return $data;
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
