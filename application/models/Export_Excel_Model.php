<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Export_Excel_Model extends CI_Model {

	public function List($id) {
        $this->db->where('ID_MEETING',$id);
        $this->db->select('*');
		$this->db->from('MEETING.VW_LIST_ABSEN');
		$query = $this->db->get();
		return $query->result_array();
	}
}
?>