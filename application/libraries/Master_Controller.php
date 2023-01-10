<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/ResponseFormatter.php';
/**
 * Description of Fasilitas Pelabuhan
 *
 * @author Arif Kurniawan
 */
class Master_Controller extends CI_Controller {

    public $title       = '';
	// public $menu        = '';
	// public $mainpath    = null;
	// public $show_data   = true;
	public $add         = true;
	public $edit        = true;
	public $detail      = true;
	public $delete      = true;
	public $btn_action  = true;
	public $filter      = []; // @label -> naam label; @name -> nama kolom database; @equal -> jenis jenis pilihan; @type -> select, number, text
	public $buttons     = []; // @label -> naam label; @onclick -> fungsi javacript(); @icon -> nama icon
	public $buttons_row = []; // @label -> naam label; @onclick -> fungsi javacript(); @icon -> nama icon
	// public $back_link   = true;
	public $limit       = 20;
	// public $skip        = 0;
	// public $page        = 1;
	// public $prev_page   = 1;
	// public $next_page   = 1;
	// public $last_page   = 0;
	public $order_by    = '';
	public $order_sort  = 'DESC';
	public $table       = '';
	public $table_view  = '';
    public $pk          = 'id';
    public $manual      = false;
    public $sequence    = '';
	// public $icon        = '';
	// public $request     = [];
	public $col           = [];  // @label -> nama colom table @name -> nama colom database @callback -> param $field untuk membuat mengedit
	public $form          = [];
	public $fixed_columns = ['leftColumns' => 2];
	// public $result      = [];
	// public $type_form   = [];
	// public $module      = [];
    // public $filter_list = [];
    public $column_order  = array(null, null); //nama field
    public $column_search = array(); //field yang diizin untuk pencarian
    public $column_search_except = array();
    public $custom_file_header = array();
    public $custom_file_footer = array();
    public $custom_file_js = array();
    public $custom_script = "";
	public $edit_after_set = "";
    
    function __construct() {
        parent::__construct();
        redirectIfNotLoggedIn();
        
        $this->load->model('CRUD_MASTER', 'my_crud');
        $this->load->library('encryption');
        $this->load->library('form_validation');
        
        $this->my_crud->_table = $this->table;
        $this->my_crud->primary_key = $this->pk;
        $this->where_params = [];
    }

    public function index()
    {
        $id = $this->input->get('id');

        $data = array(
            "libraries"          => array(lib_datatable()),
            "title_header"       => "MASTER ".$this->title,
            "list_header"        => "LIST ". $this->title,
            "content"            => "master/index",
            "id"                 => $id,
            // "col"                => array_column($this->col, 'label'),
            "col"                => $this->col,
            "forms"              => $this->form,
            "fixed_columns"      => $this->fixed_columns,
            "custom_file_header" => $this->custom_file_header,
            "custom_file_footer" => $this->custom_file_footer,
            "custom_file_js"     => $this->custom_file_js,
            "custom_script"      => $this->custom_script,
            'filter'             => $this->filter,
            'add'                => $this->add,
            'buttons'            => $this->buttons,
            'edit_after_set'     => $this->edit_after_set
        );

        $this->load->view("index", $data);
    }

    public function passToModel($view = false) {
        $this->my_crud->_table = $view ? ($this->table_view ?: $this->table) : $this->table;
        $this->my_crud->primary_key = $this->pk;
        $this->my_crud->where_params = $this->where_params;
        
        $this->column_search = array_column($this->col, 'name');

        $this->my_crud->column_order = array_merge($this->column_order, array_column($this->col, 'name'));       
        $this->my_crud->order = array($this->order_by => $this->order_sort);
        
        if (isset($this->column_search_except) && count($this->column_search_except) > 0) {
            foreach ($this->column_search_except as $except) {
                if (($key = array_search($except, $this->column_search)) !== false) {
                    unset($column_search[$key]);
                }
            }
        }

        $this->my_crud->column_search = $this->column_search;
    }

    public function ajaxPostInsert()
    {

        $this->passToModel();

        $post_data = $this->input->post();

        // $arr = array_column($post_data,'value', 'name');
        $same = '';
        foreach ($post_data as $key => $value) {
            if ($value['name'] != $same) {
                $arr[$value['name']] = $value['value'];
            } else {
                $val = $arr[$same];
                if (!is_array($val)) {
                    unset($arr[$value['name']]);                    
                    $arr[$value['name']][] = $val;
            }
                $arr[$value['name']][] = $value['value'];
            }
            $same = $value['name'];
        }

        $_POST = $arr;
        $validation = $this->insertValidation();

        if(is_bool($validation) && !$validation) {
            mResponse(NULL, $this->form_validation->error_array());
            return false;
        }

        if ($this->sequence != '') {
            $this->db->select($this->sequence.'.NEXTVAL as ID');
            $seq = $this->db->get('DUAL')->row();
            
            $arr = array_merge(array($this->pk => $seq->ID), $arr);
        }

        $this->beforeInsert($arr);

        if($this->my_crud->insert($arr)) {
            if (in_array(strtoupper($this->pk), ['ID', 'ROW_ID'])) {
                $where = array();
                foreach ($arr as $key => $value) {
                    $value != '' ? $where[$key] = $value : '';
                }

                $this->db->select('ROWIDTOCHAR(ROWID) as ID');
                $this->db->where($where);
                $this->db->from($this->table);
                $id = $this->db->get()->row();
                
                $id = $id->ID;
                $this->afterInsert($arr, $id);
            } else {
                $this->afterInsert($arr, $arr[$this->pk]);
            }
            mResponse('Data berhasil ditambahkan');
        } else {
            mResponse(NULL, 'Terdapat error pada database');
        }
    }

    public function ajaxPostDelete()
    {
        $this->passToModel();
        $id = input_post('id');
        $id = $this->encryption->decrypt($id);

        $validation = $this->deleteValidation($id);
        if(is_bool($validation) && !$validation) {
            return false;
        }

        if($this->my_crud->delete($id)) {
            mResponse('Data berhasil dihapus');
        } else {
            mResponse(NULL, 'Terdapat error pada database');
        }
    }

    public function ajaxPostSoftDelete()
    {
        $this->passToModel();
        $id = input_post('id');
        $id = $this->encryption->decrypt($id);

        $validation = $this->deleteValidation($id);
        if(is_bool($validation) && !$validation) {
            return false;
        }

        if($this->my_crud->soft_delete($id)) {
            mResponse('Data berhasil dihapus');
        } else {
            mResponse(NULL, 'Terdapat error pada database');
        }
    }

    public function ajaxPostSoftUndelete()
    {
        $this->passToModel();
        $id = input_post('id') ?: input_get('id');
        $id = $this->encryption->decrypt($id);

        if($this->my_crud->soft_undelete($id)) {
            mResponse('Data berhasil dikembalikan');
        } else {
            mResponse(NULL, 'Terdapat error pada database');
        }
    }


    public function ajaxGetEdit()
    {
        
    }

    public function ajaxPostEdit()
    {
        $this->passToModel();
        
        $data    = $this->input->post();
        $id      = $this->encryption->decrypt($data['id']);
        $filters = $this->input->post('filters') ?: [];
        unset($data['id']);
        unset($data['filters']);

        $same = '';
        foreach ($data as $key => $value) {
            if ($value['name'] != $same) {
                $arr[$value['name']] = $value['value'];
            } else {
                $val = $arr[$same];
                if (!is_array($val)) {
                    unset($arr[$value['name']]);                    
                    $arr[$value['name']][] = $val;
            }
                $arr[$value['name']][] = $value['value'];
            }
            $same = $value['name'];
        }
        
        $_POST = $arr;
        $this->manual ? $_POST['ID'] = $id : $_POST[$this->pk] = $id;
        $validation = $this->editValidation();

        if(is_bool($validation) && !$validation) {
            mResponse(NULL, $this->form_validation->error_array());
            return false;
        }
        
        $this->beforeEdit($arr, $id);

        if($this->my_crud->edit($arr, $id, $filters)) {
            $this->afterEdit($arr, $id);
            mResponse('Data berhasil diubah');
        } else {
            mResponse(NULL, 'Terdapat error pada database');
        }
    }

    public function ajaxGetDetail()
    {
        $this->passToModel();
        $id      = $this->input->get('id');
        $filters = $this->input->get('filters') ?: [];
        $id      = $this->encryption->decrypt($id);
        $data    = $this->my_crud->getById($id, $filters);
        $this->injectDetail($data);
        // echo $this->input->get('id');
        // echo $id;
        // echo $this->db->last_query();die();

        if ($data) {
            mResponse($data);
        } else {
            mResponse(NULL, 'Tidak terdapat data');
        }
    }
 
    function get_data()
    {
        $arr_join = array();
        $this->passToModel(true);

        foreach ($this->col as $key => $value) {
            if (isset($value['join'])) {
                $join             = explode(';',$value['join']);
                $join[0]          = explode('.', $join[0]);
                $join['table']    = $join[0][0];
                $join['nameJ']    = $join[0][1];
                $join['nameA']    = $value['name'];
                $join['selector'] = $join[1];

                $arr_join[] = $join;
            }
        }

        if (count($arr_join) > 0) {
            $this->my_crud->join = $arr_join;
        }

        $list = $this->my_crud->get_datatables();
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            // $row[] = '<td>
            //     <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            //         Aksi
            //     </button>
            //     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">'. $this->editBtn($field->{$this->pk}) . $this->deleteBtn($field->{$this->pk}).'</div></td>';
            $row_buttons = [];
            foreach ($this->buttons_row as $key => $buttons_row) {
                if (isset($buttons_row['callback'])) {
                    $row_buttons[] = $buttons_row['callback']($field);
                }
            }
            $row_buttons[] = ($this->delete?'<button title="Delete" type="submit" onclick="hapus(\''.$this->encryption->encrypt($field->{$this->pk}).'\')" class="btn btn-sm btn-danger waves-effect waves-themed mr-2"><span class="fa fa-times"></span></button>':'');
            $row_buttons[] = ($this->edit?'<button title="Update" type="submit" onclick="edit(\''.$this->encryption->encrypt($field->{$this->pk}).'\')" class="btn btn-sm btn-warning waves-effect waves-themed mr-2"><span class="fa fa-edit"></span></button>':'');

            $row[] = '<td>'. implode("", $row_buttons) .'</td>';
            foreach ($this->col as $key => $value) {

                if (isset($value['callback'])) {
                    $row[] = call_user_func($value['callback'], $field) ;
                    continue;
                }

                if (@$value['type'] == 'number') {
                    $item = $value['name'];
                    // $row[] = number_format($field->$item);
                    $row[] = number_format($field->$item, 2, '.', ',');
                    continue;
                }

                if (isset($value['join'])) {
                    $join          = explode(';',$value['join']);
                    $join[0]       = explode('.', $join[0]);
                    $join['field'] = "f".substr(md5($join[0][0].$join[1]), 0, 6);
					$item		   = $join['field'];
                    $row[]         = $field->$item;
                    continue;
                }
				$item = $value['name'];
                $row[] = $field->$item;
            }
                
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->my_crud->count_all(),
            "recordsFiltered" => $this->my_crud->count_filtered(),
            "data" => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    private function editBtn($id)
    {
        if ($this->edit) {
            return "<div class=\"dropdown-item\" onclick=\"edit('".$this->encryption->encrypt($id)."')\" style=\"cursor: pointer\">
                    <i class=\"la la-pencil\"></i>
                    Edit
                </div>";
        } else {
            return "";
        }
        
    }

    private function deleteBtn($id)
    {
        if ($this->delete) {
            return "<div class=\"dropdown-item\" onclick=\"hapus('".$this->encryption->encrypt($id)."')\" style=\"cursor: pointer\">
                    <i class=\"la la-trash\"></i>
                    Hapus
                </div>";
        } else {
            return "";
        }
        
    }

    private function detailBtn($id)
    {
        if ($this->detail) {
            return "<div class=\"dropdown-item\" onclick=\"detail('".$this->encryption->encrypt($id)."')\" style=\"cursor: pointer\">
                    <i class=\"la la-eye\"></i>
                    Detail
                </div>";
        } else {
            return "";
        }
        
    }

    public function insertValidation()
    {
        
    }

    public function beforeInsert(&$data)
    {
    
    }

    public function afterInsert($data, $id)
    {
        
    }

    public function editValidation()
    {
        
    }

    public function beforeEdit(&$data, &$id)
    {
    
    }

    public function afterEdit($data, $id)
    {
        
    }

    public function deleteValidation($id)
    {
        
    }

    public function injectDetail(&$data)
    {
        
    }
}