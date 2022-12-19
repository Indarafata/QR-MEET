<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Magang_Model extends CI_Model {

    private $table = 'MEETING.ABSENSI_MAGANG';

    function __construct()
    {
        parent::__construct();
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        date_default_timezone_set("Asia/Jakarta");

    }
    function save_exception($data){
        return $this->db->insert('MEETING.EXCEPTION_MAGANG', $data);
    }
    function update($data,$id){     
        $this->db->where("NIPP",$id);
        $this->db->where("TO_CHAR(CHECKIN_DATE, 'YYYYMMDD') = TO_CHAR(SYSDATE, 'YYYYMMDD') OR TO_CHAR(CHECKOUT_DATE, 'YYYYMMDD') = TO_CHAR(SYSDATE, 'YYYYMMDD')");
        return $this->db->update('MEETING.ABSENSI_MAGANG', $data);
    }
    function update_magang_time($data){
        $this->db->where("CODE_REF","ABS_TIME");
        return $this->db->update('MEETING.GEN_REF', $data);
    }
    function update_magang_interval($data){
        $this->db->where("CODE_REF","ABS_INTERVAL");
        return $this->db->update('MEETING.GEN_REF', $data);
    }
    function update_magang_jarak($data){
        $this->db->where("CODE_REF","ABS_JARAK");
        return $this->db->update('MEETING.GEN_REF', $data);
    }
    function insert($data){
        return $this->db->insert('MEETING.ABSENSI_MAGANG', $data);
    }
    function insert_lokasi($data){
        return $this->db->insert('MEETING.AREA', $data);
    }

    private function _get_datatables_query_log_absensi_arr($nipp)
    {
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI'");
        $this->db->where('NIPP',$nipp);
        $this->db->select('*')->from('V_ABSENSI');
        $this->db->where_not_in('DAY_NAME',array('Sabtu','Minggu'));
        $column_orderTopUp = array(null);
        $column_searchTopUp = array(null);
        $order = array('DAY' => 'asc'); 
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }
 
    function get_datatables_log_absensi_arr($nipp)
    {
        $this->_get_datatables_query_log_absensi_arr($nipp);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_log_absensi_arr($nipp)
    {
        $this->_get_datatables_query_log_absensi_arr($nipp);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_log_absensi_arr($nipp)
    {
        $this->db->where('NIPP',$nipp);
        $this->db->select('*')->from('V_ABSENSI');
        $this->db->where_not_in('DAY_NAME',array('Sabtu','Minggu'));
        return $this->db->count_all_results();
    }

    private function _get_datatables_query_log_absensi_all()
    {
        $this->db->select('*')->from('V_GRP_ABSENSI');
        $column_orderTopUp = array(null ,'NAMA','NIPP');
        $column_searchTopUp = array(null ,'NAMA','NIPP');
        $order = array('NIPP' => 'asc'); 
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }
 
    function get_datatables_log_absensi_all()
    {
        $this->_get_datatables_query_log_absensi_all();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_log_absensi_all()
    {
        $this->_get_datatables_query_log_absensi_all();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_log_absensi_all()
    {
        $this->db->select('*')->from('V_GRP_ABSENSI');
        return $this->db->count_all_results();
    }

    private function _get_datatables_query_lokasi()
    {
        $this->db->select('*')->from('MEETING.AREA');
        $column_orderTopUp = array(null , 'ID_AREA','AREA_NAME', 'LAT' , 'LON');
        $column_searchTopUp = array(null , 'ID_AREA','AREA_NAME', 'LAT' , 'LON');
        $order = array('CREATED_DATE' => 'desc'); 
 
        $this->datatable_order_search($order, $column_orderTopUp, $column_searchTopUp);
    }
 
    function get_datatables_lokasi()
    {
        $this->_get_datatables_query_lokasi();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_lokasi()
    {
        $this->_get_datatables_query_lokasi();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_lokasi()
    {
        $this->db->select('*')->from('MEETING.AREA');
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
