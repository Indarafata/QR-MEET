<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting_Model extends CI_Model {

	private $table = 'MEETING.VW_MEETING';

    function __construct()
    {
        parent::__construct();
    }
    function update($data,$id){
        $this->db->where('ID_MEETING',$id);
        return $this->db->update('MEETING.MEETING', $data);
    }
    function insert($data){
        return $this->db->insert('MEETING.MEETING', $data);
    }

    private function _get_datatables_query_meeting()
    {
        $this->db->where('LOCATION is not null');
        $this->db->select('*')->from($this->table);
        $column_orderTopUp = array(null ,null, 'ID_MEETING', 'EVENT','EVENT_DATE','START_DATE' , 'ID_DEPT', 'LOCATION');
        $column_searchTopUp = array(null ,null, 'ID_MEETING', 'EVENT','EVENT_DATE' , 'START_DATE' ,'ID_DEPT' , 'LOCATION');
        $order = array('CREATED_DATE' => 'desc'); 
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }
 
    function get_datatables_meeting()
    {
        $this->_get_datatables_query_meeting();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_meeting()
    {
        $this->_get_datatables_query_meeting();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_meeting()
    {
        $this->db->select('ID_MEETING')->from($this->table);
        return $this->db->count_all_results();
    }

    private function datatable_order_search($order, $column_orderTopUp, $column_searchTopUp)
    {
        $i = 0;

        foreach ($column_searchTopUp as $item) {
            if ($_POST['columns'][$i]['search']['value'] != "" && $_POST['columns'][$i]['search']['value'] != null) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like("UPPER(" . $item . ")", strtoupper($_POST['columns'][$i]['search']['value']));
                } else {
                    $this->db->like("UPPER(" . $item . ")", strtoupper($_POST['columns'][$i]['search']['value']));
                }

                if (count($column_searchTopUp) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column_orderTopUp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    private function _get_datatables_query_list_absen($id)
    {
        $this->db->where('ID_MEETING',$id);
        $this->db->select('*')->from('VW_LIST_ABSEN');
        $column_orderTopUp = array(null, 'ID_USER', 'ID_MEETING','NAME','EMAIL', 'ID_DEPT', 'COMPANY' , 'CHECKIN_DATE');
        $column_searchTopUp = array(null , 'ID_USER', 'ID_MEETING','NAME','EMAIL', 'ID_DEPT', 'COMPANY' , 'CHECKIN_DATE');
        $order = array('ID_USER' => 'asc'); 
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }
 
    function get_datatables_list_absen($id)
    {
        $this->_get_datatables_query_list_absen($id);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_list_absen($id)
    {
        $this->_get_datatables_query_list_absen($id);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_list_absen($id)
    {
        $this->db->where('ID_MEETING',$id);
        $this->db->select('ID_MEETING')->from($this->table);
        return $this->db->count_all_results();
    }
}
