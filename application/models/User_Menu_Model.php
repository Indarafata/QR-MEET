<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Menu_Model extends CI_Model {

	private $table = 'MEETING.VW_USER';

    function __construct()
    {
        parent::__construct();
    }

    function insert($data){
        return $this->db->insert('MEETING.USERS', $data);
    }

    private function _get_datatables_query_user()
    {
        $this->db->select('*')->from($this->table);
        $column_orderTopUp = array(null, 'USER_ID', 'USERNAME', 'TELP', 'ID_DEPT', 'COMPANY' , 'EMAIL' , 'CREATED_BY');
        $column_searchTopUp = array(null , 'USER_ID', 'USERNAME', 'TELP', 'ID_DEPT', 'COMPANY' , 'EMAIL' , 'CREATED_BY');
        $order = array('USER_ID' => 'asc'); 
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }
 
    function get_datatables_user()
    {
        $this->_get_datatables_query_user();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    

    function count_filtered_user()
    {
        $this->_get_datatables_query_user();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_user()
    {
        $this->db->select('ID_user')->from($this->table);
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
}
