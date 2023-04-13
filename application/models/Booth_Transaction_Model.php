<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booth_Transaction_Model extends CI_Model {

	private $table = 'MEETING.BOOTH_TRANSACTION';

    function __construct()
    {
        parent::__construct();
    }

    function insert($data){
        return $this->db->insert('MEETING.BOOTH_TRANSACTION', $data);
    }

    function delete($id){
        $this->db->where('MAHASISWA_ID', $id); 
        return $this->db->delete('MEETING.BOOTH_TRANSACTION');
    }

    public function edit($id) {
        // $id = $_GET['ID'];
        return $this->db->query("
       SELECT * FROM BOOTH_TRANSACTION WHERE MAHASISWA_ID = $id
       ")->result();
    }

    public function update($data, $id) {
        $this->db->set($data);
        $this->db->where('MAHASISWA_ID', $id);
        $this->db->update('MEETING.BOOTH_TRANSACTION');
    }

    private function _get_datatables_query_user()
    {
        $this->db->select('*')->from($this->table);
        // $column_orderTopUp = array(null, 'USER_ID', 'USERNAME', 'TELP', 'ID_DEPT', 'COMPANY' , 'EMAIL' , 'CREATED_BY');
        $column_orderTopUp = array(null, 'URL_BOOTH', 'NIP_MAHASISWA', 'TANGGAL_TRANSAKSI');
        // $column_searchTopUp = array(null , 'USER_ID', 'USERNAME', 'TELP', 'ID_DEPT', 'COMPANY' , 'EMAIL' , 'CREATED_BY');
        $column_searchTopUp = array(null, 'URL_BOOTH', 'NIP_MAHASISWA', 'TANGGAL_TRANSAKSI');
        $order = array('TRANSACTION' => 'asc'); 
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }

   public function get_data() {
    //   $query = $this->db->get('MEETING.BOOTH_TRANSACTION');
        $nip = $_SESSION['logged_in_user_name'];
        return $this->db->query("SELECT * FROM BOOTH_TRANSACTION WHERE NIP_MAHASISWA = $nip")->result();
   }
 
    function get_datatables_booth()
    {
        $this->_get_datatables_query_user();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    

    function count_filtered_booth()
    {
        $this->_get_datatables_query_user();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_transaction()
    {
        $this->db->select('TRANSACTION_ID')->from($this->table);
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
