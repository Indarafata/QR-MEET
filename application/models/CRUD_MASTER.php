<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class CRUD_MASTER extends CI_Model
{
	public $_table        = ''; //nama tabel
    public $primary_key   = 'id';
    public $column_order  = array(); //nama field
    public $column_search = array(); //field yang diizin untuk pencarian 
    public $order         = array(); // default order ('colomn' => 'asc/desc')
    public $join          = array();
    public $where_params  = array();

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        strtoupper($this->primary_key) == 'ID' ? 
            $this->db->select("ROWIDTOCHAR($this->_table.ROWID) as id, $this->_table.*")->from($this->_table) : 
            $this->db->select("$this->_table.*")->from($this->_table);
            
        if (count($this->join) > 0) {
            foreach ($this->join as $j) {
                $this->db->select($j['table'].".$j[selector] as f".substr(md5($j['table'].$j['selector']), 0, 6));
                $this->db->join($j['table'], "$j[table].$j[nameJ] = $this->_table.$j[nameA]", 'LEFT');                
            }
        }
            
        if (count($this->where_params) > 0) {
            foreach ($this->where_params as $key => $value) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else if (is_numeric($key)) {
                    $this->db->where($value, null, false);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }

        foreach ($this->input->post('filters') ?: [] as $key => $param) {
            if (is_array($param)) {
                $this->db->where_in($key, $param);
            } else if (is_numeric($key)) {
                $this->db->where($param, null, false);
            } else {
                if($param !== '') {
                    $this->db->where($key, $param);
                }
            }
        }

        $i = 0;
        
        $search_value = $_POST['search']['value'];
        foreach ($this->column_search as $item) // looping awal
        {
            if($search_value) // jika datatable mengirimkan pencarian dengan metode POST
            {
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like("UPPER(".$this->_table.".".$item.")", strtoupper($search_value));

                    if (count($this->join) > 0) {
                        foreach ($this->join as $j) {
                            $this->db->or_like("UPPER(".$j['table'].".".$j['selector'].")", strtoupper($search_value));            
                        }
                    }
                } else {
                    $this->db->or_like("UPPER(".$this->_table.".".$item.")", strtoupper($search_value));
                }
                
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
        
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->_table.".".$this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
		
		if (isset($_POST['custom_filter']) && $_POST['custom_filter']) {
            foreach ($_POST as $i => $v) {
                if (strpos($i, 'filter_') !== false) {
                    if (isset($v) && $v != '') {
                        $this->db->where($v, NULL, false);
                    }
                }
            }
        }
    }
    
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        // cek_array($query->result());die();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function count_all()
    {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    public function insert($data)
    {
        if (!isset($data) || empty($data)) {
            return true;
        }
        
        if (strtoupper($this->primary_key) == 'ID') {
            unset($data['ID']);
        }
        return $this->db->insert($this->_table, $data);
    }

    public function delete($id)
    {
        if (in_array(strtoupper($this->primary_key), ['ID', 'ROWID', 'ROW_ID'])) {
            return $this->db->delete($this->_table, array('ROWID' => $id));
        } else {
            return $this->db->delete($this->_table, array($this->primary_key => $id));
        }
    }

    public function soft_delete($id)
    {
        if (in_array(strtoupper($this->primary_key), ['ID', 'ROWID', 'ROW_ID'])) {
            $this->db->where('ROWID', $id);
        } else {
            $this->db->where($this->primary_key, $id);
        }
        $this->db->set('DELETED_DATE', 'SYSDATE', FALSE);
        return $this->db->update($this->_table);
    }

    public function soft_undelete($id)
    {
        if (in_array(strtoupper($this->primary_key), ['ID', 'ROWID', 'ROW_ID'])) {
            $this->db->where('ROWID', $id);
        } else {
            $this->db->where($this->primary_key, $id);
        }
        $this->db->set('DELETED_DATE', NULL);
        return $this->db->update($this->_table);
    }

    public function getById($id, $params = [])
    {
        if (in_array(strtoupper($this->primary_key), ['ID', 'ROWID', 'ROW_ID'])) {
            $this->db->where(array('ROWID' => $id));
        } else {
            $this->db->where(array($this->primary_key => $id));
        }

        // filter param
		foreach ($params as $key => $param) {
			if (is_array($param)) {
				$this->db->where_in($key, $param);
			} else if (is_numeric($key)) {
				$this->db->where($param, null, false);
			} else {
				$this->db->where($key, $param);
			}
		}

        return $this->db->get($this->_table)->row();
    }

    public function edit($data, $id, $params = [])
    {
        if (!isset($data) || empty($data)) {
            return true;
        }

        if (in_array(strtoupper($this->primary_key), ['ID', 'ROWID', 'ROW_ID'])) {
            $this->db->where('ROWID', $id);
        } else {
            $this->db->where($this->primary_key, $id);
        }

        // filter param
		foreach ($params as $key => $param) {
			if (is_array($param)) {
				$this->db->where_in($key, $param);
			} else if (is_numeric($key)) {
				$this->db->where($param, null, false);
			} else {
				$this->db->where($key, $param);
			}
		}
        
        return $this->db->update($this->_table, $data);
    }
}