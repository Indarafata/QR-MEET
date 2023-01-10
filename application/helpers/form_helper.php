<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('hidden')) {
    function hidden($name,$value='') {
        return "<input type='hidden' id='$name' name='$name' value='$value'>";
    }
}

if (!function_exists('inputan')) {
    function inputan($label, $type, $name, $value = '', $required = '', $attr='') {
        $output = '';
        $hasil='';

        if($required == 1) {
            $hasil="required='required'";
        } else if($required == 2) {
            $hasil='disabled';
        } else if($required == 3) {
            $hasil="readOnly='true'";
        } else if($required == 4) {
            $hasil="data-date-format='yyyy-mm-dd' readonly";
        } else if($required == 5) {
            // $hasil="onchange='setTwoNumberDecimal'";
            $hasil ="step='any'";
            // $hasil ="step='any' onchange='setTwoNumberDecimal(this)'";
        } else if($required == 6) {
            $hasil="readonly";
        } else if($required == 7) {
            $hasil="disabled";
        }
        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        } else{
            $id_name= $name;
            $name_name= $name;
        }
        
        if ($type != 'textarea') {
            $output = "
                <div class='form-group m-form__group row $name_name'>
                    <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>
                    <div class='col-lg-9'>
                        <input type='$type' id='$id_name' name='$name_name' placeholder='Masukkan ".ucwords($label)."' class='form-control m-input' data-default-value='$value' value='$value' $hasil $attr/>
                        <span class='form-control-feedback m--font-danger error_msg error_$id_name'></span>
                    </div>
                </div>";
        } else {
            $output = "
                <div class='form-group m-form__group row $name_name'>
                    <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>
                    <div class='col-lg-9'>
                        <textarea id='$id_name' name='$name_name' class='form-control m-input' $hasil>$value</textarea>
                        <span class='form-control-feedback m--font-danger error_msg error_$id_name'></span>
                    </div>
                </div>";
        }

        return $output;
    }
}

if (!function_exists('mSwitch')) {
    function mSwitch($label, $name, $class = 'success', $checked = 0, $attr = '')
    {
        if(is_array($name)) {
            $id_name   = $name[0];
            $name_name = $name[1];
        } else{
            $id_name   = $name;
            $name_name = $name;
        }

        return "<div class='m-form__group form-group row $name'>
                <label class='col-3 col-form-label form-control-label'>
                " . ucwords($label) . "
                </label>
                <div class='col-9'>
                    <span class='m-switch m-switch--outline m-switch--$class'>
                        <label>
                            <input type='checkbox' ".($checked == 1 && 'checked' )." value=1 name=$name id='$id_name' $attr>
                            <span></span>
                        </label>
                    </span>
                <span class='form-control-feedback m--font-danger error_msg error_$id_name'></span>
                </div>
            </div>";
    }
}

if (!function_exists('inputdate')) {
    function inputdate($label,$name,$value,$format='datetime',$add="") {
    
        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        }else{
            $id_name= $name;
            $name_name= $name;
        }
        if($format=="datetime") {
            $valuedate = "";
            $valuetime = "";
            if($value) {
                $datetime = explode($value," ");
                $valuedate = $datetime[0];
                $valuetime = $datetime[1];
            }
            return "
            <div class=\"form-group m-form__group row\">
                <label class=\"col-lg-3 col-form-label form-control-label\">" . ucwords($label) . "</label>
                <div class=\"col-lg-8\">
                    <div class=\"form-group m-form__group row\">
                        <div class=\"col-sm-5\">
                            <input type=\"text\" id=\"$id_name-date\" value=\"$valuedate\" name=\"$name_name-date\" placeholder=\"Date\" class=\"form-control m-input\" readonly $add>
                        </div>
                        <div class=\"col-sm-6\">
                            <input type=\"text\" id=\"$id_name-time\" value=\"$valuetime\" name=\"$name_name-time\" placeholder=\"Time\" class=\"form-control m-input\" readonly $add>
                        </div>
                    </div>
                </div>
            </div>";
        }else if($format=="date") {
            return "
            <div class=\"form-group m-form__group row\">
                <label class=\"col-lg-3 col-form-label form-control-label\">" . ucwords($label) . "</label>
                <div class=\"col-lg-9\">
                    <input type=\"text\" id=\"$id_name-date\" value=\"$value\" name=\"$name_name-date\" placeholder=\"Date\" class=\"form-control m-input\" readonly $add>
                    <span class='form-control-feedback m--font-danger error_msg'></span>            
                </div>
            </div>";
        }else if($format=="time") {
            return "
            <div class=\"form-group m-form__group row\">
                <label class=\"col-lg-3 col-form-label form-control-label\">" . ucwords($label) . "</label>
                <div class=\"col-lg-9\">
                    <input type=\"text\" id=\"$id_name-time\" value=\"$value\" name=\"$name_name-time\" placeholder=\"Time\" class=\"form-control m-input\" readonly $add>
                    <span class='form-control-feedback m--font-danger error_msg'></span>            
                </div>
            </div>";
        }
        
    }
}

if (!function_exists('submitid')) {
    function submitid($id,$value) {
        return "
        <div class='form-group m-form__group'>
                <button id='$id' class='btn btn-primary submit-id'>$value</button>
        </div>
        ";
    }
}

if (!function_exists('selectan')) {
    function selectan($label, $name, $value, $default_value, $tipe=1, $attr = '') {
        $output = '';
        $option = '';

        if($tipe==1) {
            $option ="<option value=''>--Pilih--</option>";
        }else if($tipe==2) {
            $option = "";
        }else if($tipe==3) {
            $option = "<option value='ALL'>-- ALL --</option>";
        }
        $output = "
        <div class='form-group m-form__group row'>
        <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>      
        <div class='col-lg-9'>
        <select id='$name' name='$name' class='form-control m-select2' data-default-value='$default_value' $attr>";
        $output .=  $option;
        foreach ($value as $key => $d) {
            $hasil = $key == $default_value ? 'selected' : '';
        $output .= "<option value = '$key' $hasil>" . ucwords($d) . "</option>";
            }
        $output .= "</select>
        <span class='form-control-feedback m--font-danger error_msg'></span>
        </div>
                </div>";

        return $output;
    }
}

if (!function_exists('select')) {
    function select($label, $name) {
        $output = '';

        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        }else{
            $id_name= $name;
            $name_name= $name;
        }
        $output .= "
        <div class='form-group m-form__group row'>
        <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>      
        <div class='col-lg-9'>
        <select id='$id_name' name='$name_name' class='form-control m-input'>";
        $output .= "</select>
        <span class='form-control-feedback m--font-danger error_msg'></span>
        </div>
                </div>";

        return $output;
    }
}

if (!function_exists('selectan_db')) {
    function selectan_db($label, $name, $query, $pk, $field, $default_value,$tipe=1, $attr = '') {
        $output = '';

        $CI = & get_instance();
        // $CI->load->model('master');
        $data = $CI->db->query($query)->result();
        // $data = $CI->master->GetTable($tabel);
        if($tipe==1) {
            $option ="<option value=''>--Pilih--</option>";
        }else if($tipe==2) {
            $option = "";
        }else if($tipe==3) {
            $option = "<option value='ALL'>-- ALL --</option>";
        }
        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        }else{
            $id_name= $name;
            $name_name= $name;
        }
        $output .= "
        <div class='form-group m-form__group row'>
            <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>      
            <div class='col-lg-9'>
                <select id='$id_name' data-default-value='$default_value' name='$name_name' class='form-control m-select2' $attr>
                   ";
                if(count($data)>0) {
                    $output .= $option;
                    foreach ($data as $d) {
                        $hasil = $d->$pk == $default_value ? 'selected="selected"' : '';
                        $output .= "<option value = '" . $d->$pk . "' $hasil>" . ucwords($d->{str_replace(' ','',$field)}) . "</option>";
                    }
                }else{
                    $output .= "<option value=''>--Kosong--</option>";
                }
                
        $output .= " </select>
          <span class='form-control-feedback m--font-danger error_msg error_$id_name'></span>
          </div>
        </div>";

        return $output;
    }
}

if (!function_exists('select_cabang')) {
    function select_cabang($label,$name, $pk, $field, $required,$tipe) {
        $output = '';

        $CI          = & get_instance();
        $kd_cabang   = get_session_cabang();
        $kd_regional = get_session_regional();
        if($kd_regional!=1000) {
            $CI->db->where("KODE_REGIONAL",$kd_regional);
            if($kd_cabang!=null) {
                $CI->db->where("KD_CABANG",$kd_cabang);
            }
        }
        $data = $CI->db->get("TSTO")->result();
        if($tipe==1) {
            $option ="<option value=''>--Pilih--</option>";
        }else if($tipe==2) {
            $option = "";
        }else if($tipe==3) {
            $option = "<option value='ALL'>-- ALL --</option>";
        }
        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        }else{
            $id_name= $name;
            $name_name= $name;
        }
        $output .= "
        <div class='form-group m-form__group row'>
            <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>      
            <div class='col-lg-9'>
                <select id='$id_name' name='$name_name' class='form-control m-input'>
                   ";
                if(count($data)>0) {
                    if(count($data)>1) {
                        $output .= $option;
                    }
                    foreach ($data as $d) {
                        $hasil = $d->$pk == $required ? 'selected' : '';
                        $output .= "<option value = '" . $d->$pk . "' $hasil>" . ucwords($d->$field) . "</option>";
                    }
                }else{
                    $output .= "<option value='kosong'>--Kosong--</option>";
                }
                
          $output .= " </select>
          <span class='form-control-feedback m--font-danger error_msg'></span>
          </div>
        </div>";
		return $output;
    }
}

if (!function_exists('select_regional')) {
    function select_regional($label,$name, $pk, $field, $required,$tipe) {
        $output = '';
        $CI = & get_instance();
        $kd_regional = get_session_regional();
        $CI->db->select("DISTINCT KODE_REGIONAL, NAMA_REGIONAL",FALSE);
        if($kd_regional!=1000) {
            $CI->db->where("KODE_REGIONAL",$kd_regional);        
        }
        $data = $CI->db->get("TSTO")->result();
        if($tipe==1) {
            $option ="<option value=''>--Pilih--</option>";
        }else if($tipe==2) {
            $option = "";
        }else if($tipe==3) {
            $option = "<option value='ALL'>-- ALL --</option>";
        }
        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        }else{
            $id_name= $name;
            $name_name= $name;
        }
        $output .= "
        <div class='form-group m-form__group row'>
            <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>      
            <div class='col-lg-9'>
                <select id='$id_name' name='$name_name' class='form-control m-input'>
                   ";
                if(count($data)>0) {
                    if(count($data)>1) {
                        $output .= $option;
                    }
                    foreach ($data as $d) {
                        $hasil = $d->$pk == $required ? 'selected' : '';
                        $output .= "<option value = '" . $d->$pk . "' $hasil>" . ucwords($d->$field) . "</option>";
                    }
                }else{
                    $output .= "<option value='kosong'>--Kosong--</option>";
                }
                
          $output .= " </select>
          <span class='form-control-feedback m--font-danger error_msg'></span>
          </div>
        </div>";
		return $output;
    }
}

if (!function_exists('select_regional_new')) {
    function select_regional_new($label,$name, $pk, $field, $required,$tipe) {
        $output = '';
        $CI = & get_instance();
        $kd_regional = get_session_regional();
        $CI->db->select("DISTINCT KODE_REGIONAL_SAP_NEW, NAMA_REGIONAL",FALSE);
        if($kd_regional!=1000) {
            $CI->db->where("KODE_REGIONAL",$kd_regional);        
        }
        $data = $CI->db->get("TSTO")->result();
        
        if($tipe==1) {
            $option ="<option value=''>--Pilih--</option>";
        }else if($tipe==2) {
            $option = "";
        }else if($tipe==3) {
            $option = "<option value='ALL'>-- ALL --</option>";
        }
        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        }else{
            $id_name= $name;
            $name_name= $name;
        }
        $output .= "
        <div class='form-group m-form__group row'>
            <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>      
            <div class='col-lg-9'>
                <select id='$id_name' name='$name_name' class='form-control m-input'>
                   ";
                if(count($data)>0) {
                    if(count($data)>1) {
                        $output .= $option;
                    }
                    foreach ($data as $d) {
                        $hasil = $d->$pk == $required ? 'selected' : '';
                        $output .= "<option value = '" . $d->$pk . "' $hasil>" . ucwords($d->$field) . "</option>";
                    }
                }else{
                    $output .= "<option value='kosong'>--Kosong--</option>";
                }
                
          $output .= " </select>
          <span class='form-control-feedback m--font-danger error_msg'></span>
          </div>
        </div>";
        return $output;
    }
}

if (!function_exists('select_cabang_dt')) {
    function select_cabang_dt($label,$name, $pk, $field, $required,$tipe) {
        $output = '';

        $CI = & get_instance();
        $kd_cabang = get_session_cabang();
        if(isset($kd_cabang)) {
            $CI->db->where("KD_CABANG",$kd_cabang);
        }
        $data = $CI->db->get("TSTO")->result();
        if($tipe==1) {
            $option ="<option value=''>--Pilih--</option>";
        }else if($tipe==2) {
            $option = "";
        }else if($tipe==3) {
            $option = "<option value='ALL'>-- ALL --</option>";
        }
        $output .= "
        <div class='m-form__group m-form__group--inline'>
                    <div class='m-form__label'>
                      <label>
                      " . ucwords($label) . " 
                      </label>
                    </div>
                    <div class='m-form__control'>
                      <select class='form-control m-bootstrap-select'  id='$name' name='$name'>
                   ";
                if(count($data)>0) {
                    if(count($data)>1) {
                        $output .= $option;
                    }
                    foreach ($data as $d) {
                        $hasil = $d->$pk == $required ? 'selected' : '';
                        $output .= "<option value = '" . $d->$pk . "' $hasil>" . ucwords($d->$field) . "</option>";
                    }
                }else{
                    $output .= "<option value='kosong'>--Kosong--</option>";
                }
                
          $output .= " </select>
          <span class='form-control-feedback m--font-danger error_msg'></span>
          </div>
        </div>
        <div class='d-md-none m--margin-bottom-10'></div>";
		return $output;
    }
}

if (!function_exists('formfile')) {
    function formfile($label,$name,$origin,$type=1) {
        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        }else{
            $id_name= $name;
            $name_name= $name;
        }
        if($type==1) {
            return "
                <div class='form-group m-form__group row'>
                <label class='col-lg-3 col-form-label form-control-label'> 
                    " . ucwords($label) . "
                    </label>
                    <div class='col-lg-9'>
                    <input type='file' name='$name_name' id='$id_name'accept='$origin' class='form-control m-input'>
                    </div>
                </div>";
        }else if($type==2) {
            return "
                <div class='form-group m-form__group row'>
                <label class='col-lg-3 col-form-label form-control-label'> 
                    " . ucwords($label) . "
                    </label>
                    <div class='col-lg-9'>
                    <label class='btn btn-secondary' for='$id_name' style='margin-bottom: 0px;'>
                        <strong class='browse-$id_name'>UPLOAD...</strong>
                    </label>
                    <input style='opacity: 0; position: absolute; z-index: -1;' id='$id_name' accept='$origin' type='file' name='$name_name'/>
                    </div>
                </div>";
                
        }
        
    }
}

if (!function_exists('button')) {
    function button($name,$value) {
        return "<div class='m-portlet__foot m-portlet__no-border m-portlet__foot--fit'>
        <div class='m-form__actions m-form__actions--solid'>
            <div class='col-md-4'>
        <button id='$name' type='submit'  class='btn btn-success'>
        $value
        </button>
        <button type='reset' class='btn btn-secondary'>
                                            Cancel
                                        </button>
            </div>
            </div>
        </div>
        ";
    }
}

if (!function_exists('mDropZone')) {
    function mDropZone($label = '')
    {
        return "<div class='form-group m-form__group row'>
                <label class='col-form-label form-control-label col-lg-3'>
                    " . ucwords($label) . "
                </label>
                <div class='col-lg-9'>
                    <div class='m-dropzone dropzone m-dropzone--success' action='".base_url('master/Master/upload_dropzone')."' id='m-dropzone-three'>
                        <div class='m-dropzone__msg dz-message needsclick'>
                            <h3 class='m-dropzone__msg-title'>
                                Drop files here or click to upload.
                            </h3>
                            <span class='m-dropzone__msg-desc'>
                                Only image, pdf and psd files are allowed for upload
                            </span>
                        </div>
                    </div>
                </div>
            </div>";
    }
}

if (!function_exists('indate')) {
    function indate($label,$name,$value,$attr="") {
        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        }else{
            $id_name= $name;
            $name_name= $name;
        }

        return "
        <div class=\"form-group m-form__group row\">
            <label class=\"col-lg-3 col-form-label form-control-label\">" . ucwords($label) . "</label>
            <div class=\"col-lg-9\">
                <input type=\"text\" id=\"$id_name\" value=\"$value\" name=\"$name_name\" placeholder=\"Date\" class=\"form-control m-input\" $attr>
                <span class='form-control-feedback m--font-danger error_msg error_$id_name'></span>            
            </div>
        </div>";
    }
}

if (!function_exists('input_time')) {
    function input_time($label,$name,$value,$required=false,$attr="") {
        if(is_array($name)) {
            $id_name= $name[0];
            $name_name= $name[1];
        }else{
            $id_name= $name;
            $name_name= $name;
        }

        return "
        <div class=\"form-group m-form__group row\">
            <label class=\"col-lg-3 col-form-label form-control-label\">" . ucwords($label) . "</label>
            <div class=\"col-lg-9\">
                <input class=\"form-control\" type=\"time\" value=\"$value\" data-default-value=\"$value\" id=\"$id_name\" name=\"$name_name\" placeholder=\"Masukkan ".ucwords($label)."\" ".($required ? "required=\"required\"" : '')." $attr>
                <span class='form-control-feedback m--font-danger error_msg error_$id_name'></span>            
            </div>
        </div>";
    }
}

if (!function_exists('filter_form')) {
    function filter_form($label, $name, $equal, $type, $table = '', $query = '', $pk = '', $field = '', $value = '', $customOption = null)
    {
        foreach ($equal as $key => $eq) {
            $key == 0 ? $equal = '' : '';

            $equal .= "<option value='$eq'>$eq</option>";
        }

        if ($type == 'text' || $type == 'number') {
            return "<div class='form-group m-form__group row ".$name."_fil'>
                        <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>
                        <div class='col-lg-3'>
                            <select id='".$name."_eq' name='".$name."_eq' class='form-control m-input'>
                                $equal
                            </select>
                        </div>
                        <div class='col-lg-6'>
                            <input type='hidden' id='".$name."_tab' value='$table' >
                            <input type='$type' id='".$name."_fil' name='".$name."_fil' placeholder='Masukan ".ucwords($label)."' class='form-control m-input'/>
                            <span class='form-control-feedback m--font-danger error_msg error_".$name."_fil'></span>
                        </div>
                    </div>";
        } elseif ($type == 'select') {
            $option = '<option value="">-- Pilih Data --</option>';

            $CI = & get_instance();
            $data = $customOption ?: $CI->db->query($query)->result();
            
            if(count($data)>0) {
                if ($customOption == null) {
                    foreach ($data as $d) {
                        $option .= "<option value = '" . $d->$pk . "' ". ($d->$pk == $value ? 'selected' : '') .">" . ucwords($d->$field) . "</option>";
                    }
                } else {
                    foreach ($data as $d) {
                        $option .= "<option value = '" . $d . "' ". ($d == $value ? 'selected' : '') .">" . ucwords($d) . "</option>";
                    }
                }
            } else {
                $option = "<option value=''>--Kosong--</option>";
            }
            
            return "
            <div class='form-group m-form__group row ".$name."_fil'>
                <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($label) . " </label>   
                <div class='col-lg-3'>
                    <select id='".$name."_eq' name='".$name."_eq' class='form-control m-input'>
                        $equal
                    </select>
                </div>
                <div class='col-lg-6'>
                    <input type='hidden' id='".$name."_tab' value='$table' >
                    <select id='".$name."_fil' name='".$name."_fil' class='form-control m-select2'>
                        $option
                    </select>
                    <span class='form-control-feedback m--font-danger error_msg error_".$name."_fil'></span>
                </div>
            </div>";
        }
    }
}

if (!function_exists('formButton')) {
    function formButton($data) {
        $button = "";
        foreach ($data['btnData'] as $key => $value) {
            $value = explode('|', $value);
            $size = isset($value[2]) ? 'btn-'.$value[2] : '';
            $button .= "<div id='$key' class='btn btn-$value[1] ml-3 $size'>
                        $value[0]
                    </div>";
        }
        
        echo "<div class='form-group m-form__group row $data[name]'>
                <label class='col-lg-3 col-form-label form-control-label'> " . ucwords($data['label']) . " </label>
                <div class='col-lg-9'>
                    $button
                    <span class='form-control-feedback m--font-danger error_msg error_$data[name]'></span>
                </div>
            </div>";
    }
}
?>