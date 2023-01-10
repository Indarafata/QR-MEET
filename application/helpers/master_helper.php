<?php


/*
 * @author Aan
 */
//KEY JWT
function JWTKey(){
    return '@_arifkurniawan';
}
function lib_datatable(){
    return "LIB_DATATABLE";
}

function lib_datepicker(){
    return "LIB_DATEPICKER";
}

function lib_uiblock(){
    return "LIB_UIBLOCK";
}

function lib_alert(){
    return "LIB_ALERT";
}

function lib_autocomplete(){
    return "LIB_AUTOCOMPLETE";
}

function lib_chosen(){
    return "LIB_CHOSEN";
}

function lib_select2(){
    return "LIB_SELECT2";
}

function lib_summernote(){
    return "LIB_SUMMERNOTE";
}

function lib_fileupload(){
    return "LIB_FILEUPLOAD";
}

function lib_barchart(){
    return "LIB_BARCHART";
}

function input_post($val){
    $CI =& get_instance();
    $data = $CI->input->post($val);
    if(!isset($data)){
        return null;
    }
    else if(is_array($data)){
        $array = array();
        foreach($data as $d){
            $array[] = str_replace(array("'", '"', '<', '>'), array('&#39;', '&quot;', '&lt;', '&gt;'), stripslashes($d));
        }
        return $array;
    }
    else if(strpos($data, '{')){
        return str_replace(array("'",'<', '>','""'), array('&#39;', '&lt;', '&gt;','"'), stripslashes($data));
    }else{
        return str_replace(array("'", '"', '<', '>'), array('&#39;', '&quot;', '&lt;', '&gt;'), stripslashes($data));
    }
}

function input_get($val){
    $CI =& get_instance();
    $data = $CI->input->get($val);
    if(!isset($data)){
        return null;
    }
    else if(is_array($data)){
        $array = array();
        foreach($data as $d){
            $array[] = str_replace(array("'", '"', '<', '>'), array('&#39;', '&quot;', '&lt;', '&gt;'), stripslashes($d));
        }
        return $array;
    }
    else if(strpos($data, '{')){
        return str_replace(array("'",'<', '>','""'), array('&#39;', '&lt;', '&gt;','"'), stripslashes($data));
    }else{
        return str_replace(array("'", '"', '<', '>'), array('&#39;', '&quot;', '&lt;', '&gt;'), stripslashes($data));
    }
}

function mResponse($success = NULL, $failed = NULL)
{
    $status = NULL;
    $msg = NULL;
    $data = NULL;

    if ($failed !== NULL) {
        $status = 0;
        $msg = "error";
        $data = $failed;
    } else {
        $status = 1;
        $msg = "success";
        $data = $success;
    }
    header('Content-Type: application/json');
    echo json_encode(array("status" => $status, "msg" => $msg, "data" => $data));
}

function response($message, $data=null, $success = true, $code=null)
{
    $code   = $code ?: ($success ? 200 : 500);
    $status = $success ? 'success' : 'failed';
    header('Content-Type: application/json');
    echo json_encode([
        "message" => $message,
        "data"    => $data,
        "status"  => $status,
        "code"    => $code
    ]);
    die();
}

if (!function_exists('replaceToUpper')) {
    function replaceToUpper($array, $key) {
        $replacement = array('NAMA' => strtoupper($array['NAMA']));
        $array = array_replace($array, $replacement);
    }
}

function swal_loader($title = 'Loading...')
{
    $text =  "Swal.fire({
            title: '$title',
            html : '<div class=\"spinner-border text-info\" role=\"status\"></div>',
            showConfirmButton: false,
            customClass : 'sweetalert-xs',
            allowOutsideClick:false
        });";

    return $text;
}

function swal_close()
{
    return "Swal.close();";
}

function swal_popup($title, $text, $type)
{
    $text = "Swal.fire({
        title: '$title',
        text: '$text',
        type: '". ($type == 1 ? "success" : "error") ."',
        allowOutsideClick:false
    });";

    return $text;
}

function db_call_func($name, $params = [], $result = '')
{
    $ci =& get_instance();
    $params_str = [];
    $params_str = $params;
    if ($result) {
        $params_str[$result] = "";
    }
    $params_str = count($params) ? (":" . implode(", :", array_keys($params_str))) : "";
    
    $stid = oci_parse($ci->db->conn_id, "BEGIN $name ( $params_str ); END;");
    foreach ($params as $key => $value) {
        oci_bind_by_name($stid, ":$key", $params[$key], 2000);
    }
    
    if ($result) {
        oci_bind_by_name($stid, ":$result", $vresult, 2000);
    }

    if (oci_execute($stid)) {
        $result = $result ? $vresult : 'SUCCESS';
    } else {
        $result = "ERROR";
    }

    oci_free_statement($stid);
    return $result;
}